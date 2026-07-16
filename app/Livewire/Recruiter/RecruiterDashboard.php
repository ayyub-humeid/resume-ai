<?php

namespace App\Livewire\Recruiter;

use App\Models\Candidate;
use App\Models\JobListing;
use Livewire\Component;
use Livewire\WithPagination;

class RecruiterDashboard extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = 'active';

    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedStatus(): void { $this->resetPage(); }

    public function toggleStatus(int $jobId): void
    {
        $job = JobListing::query()->where('user_id', auth()->id())->findOrFail($jobId);
        $job->update(['status' => $job->status === 'archived' ? 'active' : 'archived']);
    }

    public function render()
    {
        $jobs = JobListing::query()
            ->where('user_id', auth()->id())
            ->withCount('candidates')
            ->when($this->search !== '', fn ($query) => $query->where(fn ($query) => $query->where('title', 'like', "%{$this->search}%")->orWhere('company', 'like', "%{$this->search}%")))
            ->when($this->status !== 'all', fn ($query) => $query->where('status', $this->status))
            ->latest()
            ->paginate(8);

        return view('livewire.recruiter.recruiter-dashboard', [
            'jobs' => $jobs,
            'activeRoles' => JobListing::query()->where('user_id', auth()->id())->where('status', 'active')->count(),
            'candidateCount' => Candidate::query()->where('recruiter_id', auth()->id())->count(),
            'shortlistedCount' => Candidate::query()->where('recruiter_id', auth()->id())->where('status', 'shortlisted')->count(),
        ]);
    }
}
