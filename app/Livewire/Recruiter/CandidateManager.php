<?php

namespace App\Livewire\Recruiter;

use App\Models\Candidate;
use App\Models\JobListing;
use App\Jobs\AnalyzeCandidate;
use Livewire\Component;
use Livewire\WithPagination;

class CandidateManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = 'all';
    public string $jobFilter = 'all';
    public array $selectedCandidates = [];

    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedStatus(): void { $this->resetPage(); }
    public function updatedJobFilter(): void { $this->resetPage(); }

    public function updateStatus(int $candidateId, string $status): void
    {
        abort_unless(in_array($status, ['new', 'reviewing', 'shortlisted', 'rejected'], true), 422);

        Candidate::query()->where('recruiter_id', auth()->id())->findOrFail($candidateId)->update(['status' => $status]);
    }

    public function reviewSelected(): void
    {
         if ($this->jobFilter === 'all') {
        $this->addError('selection', 'Choose a role before reviewing all of its candidates.');
        return;
    }

        if (empty($this->selectedCandidates)) {
            $this->addError('selection', 'Select at least one candidate to review.');
            return;
        }

        $this->queueReviews($this->selectedCandidates);
    }

    public function reviewAll(): void
    {
        if ($this->jobFilter === 'all') {
            $this->addError('selection', 'Choose a role before reviewing all of its candidates.');
            return;
        }

        $ids = Candidate::query()->where('recruiter_id', auth()->id())->where('job_id', $this->jobFilter)->
        whereNotIn('status', ['completed', 'rejected','reviewing'])
        ->pluck('id')->all();
        $this->queueReviews($ids);
    }

    private function queueReviews(array $ids): void
    {

        $candidates = Candidate::query()->where('recruiter_id', auth()->id())->whereIn('id', $ids)->with('job')->get();

        $queued = 0;
        foreach ($candidates as $candidate) {
            if (! $candidate->job || blank($candidate->raw_text)) {
                continue;
            }

            $candidate->update(['review_state' => 'queued']);
            AnalyzeCandidate::dispatch($candidate->id, auth()->id());
            $queued++;
        }

        $this->selectedCandidates = [];
        $this->dispatch('toast', message: "{$queued} candidate review(s) queued.");
    }

    public function render()
    {
        $candidates = Candidate::query()
            ->where('recruiter_id', auth()->id())
            ->with('job')
            ->when($this->search !== '', fn ($query) => $query->where(fn ($query) => $query->where('name', 'like', "%{$this->search}%")->orWhere('email', 'like', "%{$this->search}%")))
            ->when($this->status !== 'all', fn ($query) => $query->where('status', $this->status))
            ->when($this->jobFilter !== 'all', fn ($query) => $query->where('job_id', $this->jobFilter))
            ->orderByDesc('match_score')->latest()
            ->paginate(10);

        return view('livewire.recruiter.candidate-manager', [
            'candidates' => $candidates,
            'jobs' => JobListing::query()->where('user_id', auth()->id())->latest()->get(['id', 'title']),
        ]);
    }
}
