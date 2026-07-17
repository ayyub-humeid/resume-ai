<?php

namespace App\Livewire\Recruiter;

use App\Models\Candidate;
use App\Models\JobListing;
use App\Services\ResumeParserService;
use Livewire\Component;
use Livewire\WithFileUploads;

class CandidateBulkUpload extends Component
{
    use WithFileUploads;

    public string $jobTitle = '';
    public string $existingJobId = '';
    public string $company = '';
    public string $jobDescription = '';
    public array $files = [];
    public string $message = '';

    public function mount(): void
    {
        $this->existingJobId = request()->query('job_id', '');
    }

    public function submit(ResumeParserService $parser): void
    {
        $validated = $this->validate([
            'jobTitle' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'jobDescription' => ['nullable', 'string', 'min:80', 'max:30000'],
            'files' => ['required', 'array', 'min:1', 'max:10'],
            'files.*' => ['file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        if ($this->existingJobId === '') {
            $this->validate([
                'jobTitle' => ['required', 'string', 'max:255'],
                'jobDescription' => ['required', 'string', 'min:80', 'max:30000'],
            ]);
        }

        $job = $this->existingJobId !== ''
            ? JobListing::query()->where('user_id', auth()->id())->findOrFail($this->existingJobId)
            : JobListing::create([
                'user_id' => auth()->id(),
                'title' => $validated['jobTitle'],
                'company' => $validated['company'] ?: null,
                'description' => $validated['jobDescription'],
            ]);

        $uploaded = 0;
        $failed = 0;

        foreach ($this->files as $file) {
            try {
                $path = $file->store('candidates', 'public');
                $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

                Candidate::create([
                    'recruiter_id' => auth()->id(),
                    'job_id' => $job->id,
                    'name' => $name,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'raw_text' => $parser->parse(storage_path('app/public/' . $path)),
                ]);
                $uploaded++;
            } catch (\Throwable $exception) {
                report($exception);
                $failed++;
            }
        }

        $this->reset(['jobTitle', 'company', 'jobDescription', 'files']);
        $this->message = "{$uploaded} candidate(s) added." . ($failed ? " {$failed} file(s) failed and can be uploaded again." : '');
    }

    public function render()
    {
        return view('livewire.recruiter.candidate-bulk-upload', [
            'jobs' => JobListing::query()->where('user_id', auth()->id())->where('status', 'open')->latest()->get(['id', 'title']),
        ]);
    }
}
