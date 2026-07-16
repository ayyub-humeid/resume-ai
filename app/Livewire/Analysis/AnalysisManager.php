<?php

namespace App\Livewire\Analysis;

use App\Models\Analysis;
use App\Models\JobListing;
use App\Models\Resume;
use App\Services\CoverLetterGeneratorService;
use App\Services\ResumeAnalysisService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Throwable;

class AnalysisManager extends Component
{
    public string $page = 'index';
    public ?int $resumeId = null;
    public string $jobTitle = '';
    public string $company = '';
    public string $jobDescription = '';
    public ?Analysis $selectedAnalysis = null;
    public ?int $pendingDeletionId = null;
    public string $message = '';

    // Transient cover-letter draft state — never persisted until approved
    public ?string $draftCoverLetter = null;
    public bool $showCoverLetterReview = false;

    public function create(): void
    {
        $this->resetValidation();
        $this->reset(['resumeId', 'jobTitle', 'company', 'jobDescription']);
        $this->page = 'create';
    }

    public function index(): void
    {
        $this->resetValidation();
        $this->page = 'index';
    }

    public function runAnalysis(ResumeAnalysisService $analysisService): void
    {
        $validated = $this->validate([
            'resumeId' => ['required', 'integer'],
            'jobTitle' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'jobDescription' => ['required', 'string', 'min:80', 'max:30000'],
        ]);

        $resume = Resume::query()->where('user_id', auth()->id())->findOrFail($validated['resumeId']);

        try {
            $result = $analysisService->analyze($resume, $validated['jobDescription']);
            \Log::info('Analysis result: ' . json_encode($result));
            $analysis = DB::transaction(function () use ($validated, $resume, $result) {
                $job = JobListing::create([
                    'user_id' => auth()->id(),
                    'title' => $validated['jobTitle'],
                    'company' => $validated['company'] ?: null,
                    'description' => $validated['jobDescription'],
                ]);

                return Analysis::create($result + [
                    'user_id' => auth()->id(),
                    'resume_id' => $resume->id,
                    'job_id' => $job->id,
                ]);
            });
        } catch (Throwable $exception) {
            report($exception);
            $this->addError('analysis', 'Analysis could not be generated. Please check the job description and try again.');
            return;
        }

        $this->selectedAnalysis = $analysis->load(['resume', 'job']);
        $this->page = 'show';
        $this->message = 'Your analysis is ready.';
    }

    public function show(int $analysisId): void
    {
        $this->selectedAnalysis = $this->ownedAnalysis($analysisId)->load(['resume', 'job']);

        // Fix #1: clear any stale draft/review state from a previously viewed analysis
        $this->draftCoverLetter = null;
        $this->showCoverLetterReview = false;
        $this->resetErrorBag('coverLetter');

        $this->page = 'show';
    }

    // public function askToDelete(int $analysisId): void
    // {
    //     $this->ownedAnalysis($analysisId);
    //     $this->pendingDeletionId = $analysisId;
    //     $this->dispatch('confirmation-requested');
    // }

    public function generateCoverLetter(CoverLetterGeneratorService $service): void
    {
        if (! $this->selectedAnalysis) {
            return;
        }

        // Re-verify ownership before doing any AI work / touching the model
        $analysis = $this->ownedAnalysis($this->selectedAnalysis->id)->load(['resume', 'job']);

        try {
            $this->draftCoverLetter = $service->generate($analysis);
            $this->showCoverLetterReview = true;
            $this->resetErrorBag('coverLetter');
        } catch (Throwable $exception) {
            report($exception);
            $this->addError('coverLetter', 'Cover letter could not be generated. Please try again.');
        }
    }

    public function approveCoverLetter(): void
    {
        if (! $this->selectedAnalysis || ! $this->draftCoverLetter) {
            return;
        }

        // Fix #2: don't trust the hydrated $selectedAnalysis payload —
        // re-fetch scoped to the authenticated user before writing.
        $analysis = $this->ownedAnalysis($this->selectedAnalysis->id);

        $analysis->update([
            'cover_letter' => $this->draftCoverLetter,
        ]);

        $this->selectedAnalysis = $analysis->load(['resume', 'job']);
        $this->showCoverLetterReview = false;
        $this->draftCoverLetter = null;
        $this->message = 'Cover letter saved.';
    }

    public function cancelCoverLetter(): void
    {
        $this->showCoverLetterReview = false;
        $this->draftCoverLetter = null;
    }

    public function delete(int $analysisId): void
    {
        // if (! $this->pendingDeletionId) return;
         $this->ownedAnalysis($analysisId);
        $this->pendingDeletionId = $analysisId;

        $analysis = $this->ownedAnalysis($this->pendingDeletionId);
        $job = $analysis->job;
        $analysis->delete();
        $job?->delete();

        $this->reset('pendingDeletionId', 'selectedAnalysis', 'draftCoverLetter', 'showCoverLetterReview');
        $this->page = 'index';
        $this->message = 'Analysis deleted.';
    }

    public function render()
    {
        return view('livewire.analysis.analysis-manager', [
            'analyses' => Analysis::query()->where('user_id', auth()->id())->with(['resume', 'job'])->latest()->get(),
            'resumes' => Resume::query()->where('user_id', auth()->id())->latest()->get(),
        ]);
    }

    private function ownedAnalysis(int $analysisId): Analysis
    {
        return Analysis::query()->where('user_id', auth()->id())->findOrFail($analysisId);
    }
}
