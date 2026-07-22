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

    public function updatedSearch(): void
    {
        $this->resetPage();
    }
    public function updatedStatus(): void
    {
        $this->resetPage();
    }
    public function updatedJobFilter(): void
    {
        $this->resetPage();
    }

    public function updateStatus(int $candidateId, string $status): void
    {
        abort_unless(in_array($status, ['new', 'reviewing', 'shortlisted', 'rejected'], true), 422);

        Candidate::query()->where('recruiter_id', auth()->id())->findOrFail($candidateId)->update(['status' => $status]);

        $this->dispatch('toast', [
            'message' => __('Candidate status updated successfully.'),
            'type' => 'success'
        ]);
    }

    public function reviewSelected(): void
    {
        $this->resetErrorBag();

        if ($this->jobFilter === 'all') {
            $this->addError('selection', __('Choose a role before reviewing all of its candidates.'));
            return;
        }

        if (empty($this->selectedCandidates)) {
            $this->addError('selection', __('Select at least one candidate to review.'));
            return;
        }

        $this->queueReviews($this->selectedCandidates);
    }

    public function reviewAll(): void
    {
        $this->resetErrorBag();

        if ($this->jobFilter === 'all') {
            $this->addError('selection', __('Choose a role before reviewing all of its candidates.'));
            return;
        }

        $ids = Candidate::query()->where('recruiter_id', auth()->id())->where('job_id', $this->jobFilter)->
            whereNotIn('status', ['completed', 'rejected', 'reviewing'])
            ->pluck('id')->all();

        if (empty($ids)) {
            $this->addError('selection', __('No candidates found to review for this role.'));
            return;
        }

        $this->queueReviews($ids);
    }

    private function queueReviews(array $ids): void
    {
        // Extend time limit for unqueued job execution on shared hosting
        if (function_exists('set_time_limit')) {
            @set_time_limit(300);
        }
        @ini_set('max_execution_time', '300');

        $candidates = Candidate::query()->where('recruiter_id', auth()->id())->whereIn('id', $ids)->with('job')->get();

        $validCandidateIds = [];
        foreach ($candidates as $candidate) {
            if (!$candidate->job || blank($candidate->raw_text)) {
                continue;
            }
            $validCandidateIds[] = $candidate->id;
            $candidate->update(['review_state' => 'queued']);
        }

        if (count($validCandidateIds) > 0) {
            AnalyzeCandidate::dispatchSync($validCandidateIds, auth()->id());

            $this->selectedCandidates = [];
            $this->dispatch('toast', [
                'message' => __(':count candidate review(s) processed successfully.', ['count' => count($validCandidateIds)]),
                'type' => 'success'
            ]);
        } else {
            $this->addError('selection', __('No valid candidates found to review.'));
        }
    }

    public function render()
    {
        $candidates = Candidate::query()
            ->where('recruiter_id', auth()->id())
            ->with('job')
            ->when($this->search !== '', fn($query) => $query->where(fn($query) => $query->where('name', 'like', "%{$this->search}%")->orWhere('email', 'like', "%{$this->search}%")))
            ->when($this->status !== 'all', fn($query) => $query->where('status', $this->status))
            ->when($this->jobFilter !== 'all', fn($query) => $query->where('job_id', $this->jobFilter))
            ->orderByDesc('match_score')->latest()
            ->paginate(10);

        return view('livewire.recruiter.candidate-manager', [
            'candidates' => $candidates,
            'jobs' => JobListing::query()->where('user_id', auth()->id())->latest()->get(['id', 'title']),
        ]);
    }
}
