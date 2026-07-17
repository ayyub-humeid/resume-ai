<?php

namespace App\Livewire\Recruiter;

use App\Models\JobListing;
use App\Models\Candidate;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;

class JobManager extends Component
{
    use WithPagination;

    public string $pageState = 'index'; // 'index', 'create', 'edit', 'show', 'showCandidates'
    public ?int $selectedJobId = null;
    public string $search = '';
    public string $filterstatus = 'all';

    // Form fields
    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('nullable|string|max:255')]
    public string $company = '';

    #[Validate('required|string')]
    public string $description = '';

    #[Validate('nullable|url|max:255')]
    public string $source_url = '';

    #[Validate('required|in:open,closed')]
    public string $status = 'open';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function changeState(string $state, ?int $jobId = null)
    {
        $this->pageState = $state;
        
        if ($jobId !== null) {
            $this->selectedJobId = $jobId;
        }

        $this->resetValidation();

        if ($state === 'create') {
            $this->resetForm();
        } elseif ($state === 'edit' && $this->selectedJobId) {
            $this->loadJob($this->selectedJobId);
        }
    }

    public function resetForm()
    {
        $this->title = '';
        $this->company = '';
        $this->description = '';
        $this->source_url = '';
        $this->status = 'open';
    }

    public function loadJob(int $id)
    {
        $job = JobListing::where('user_id', auth()->id())->findOrFail($id);
        $this->title = $job->title;
        $this->company = $job->company;
        $this->description = $job->description;
        $this->source_url = $job->source_url ?? '';
        $this->status = $job->status;
    }

    public function save()
    {
        $this->validate();

        if ($this->pageState === 'create') {
            JobListing::create([
                'user_id' => auth()->id(),
                'title' => $this->title,
                'company' => $this->company,
                'description' => $this->description,
                'source_url' => $this->source_url,
                'status' => $this->status,
            ]);
            $this->dispatch('toast', ['message' => 'Job created successfully', 'type' => 'success']);
        } elseif ($this->pageState === 'edit' && $this->selectedJobId) {
            $job = JobListing::where('user_id', auth()->id())->findOrFail($this->selectedJobId);
            $job->update([
                'title' => $this->title,
                'company' => $this->company,
                'description' => $this->description,
                'source_url' => $this->source_url,
                'status' => $this->status,
            ]);
            $this->dispatch('toast', ['message' => 'Job updated successfully', 'type' => 'success']);
        }

        $this->changeState('index');
    }

    public function delete(int $id)
    {
        $job = JobListing::where('user_id', auth()->id())->findOrFail($id);
        $job->delete();

        $this->dispatch('toast', ['message' => 'Job deleted successfully', 'type' => 'success']);

        if (in_array($this->pageState, ['show', 'showCandidates']) && $this->selectedJobId === $id) {
            $this->changeState('index');
        }
    }

    public function updateCandidateStatus(int $candidateId, string $status)
    {
        $candidate = Candidate::whereHas('job', function ($q) {
            $q->where('user_id', auth()->id());
        })->findOrFail($candidateId);

        $candidate->update(['status' => $status]);
        $this->dispatch('toast', ['message' => 'Candidate status updated', 'type' => 'success']);
    }

    public function render()
    {
        $jobs = [];
        $selectedJob = null;
        $rankedCandidates = collect();

        if ($this->pageState === 'index') {
            $jobs = JobListing::where('user_id', auth()->id())
                ->when($this->filterstatus !== 'all', fn($query) => $query->where('status', $this->filterstatus))
                ->when($this->search, function ($q) {
                    $q->where(function($subQ) {
                        $subQ->where('title', 'like', "%{$this->search}%")
                             ->orWhere('company', 'like', "%{$this->search}%");
                    });
                })
                ->withCount('candidates')
                ->latest()
                ->paginate(10);
        } elseif (in_array($this->pageState, ['show', 'showCandidates']) && $this->selectedJobId) {
            $selectedJob = JobListing::withCount('candidates')
                ->where('user_id', auth()->id())
                ->findOrFail($this->selectedJobId);

            if ($this->pageState === 'showCandidates') {
                $rankedCandidates = Candidate::where('job_id', $this->selectedJobId)
                    ->get()
                    ->sortByDesc('match_score')
                    ->values();
            }
        }

        return view('livewire.recruiter.job-manager', [
            'jobs' => $jobs,
            'selectedJob' => $selectedJob,
            'rankedCandidates' => $rankedCandidates,
        ]);
    }
}
