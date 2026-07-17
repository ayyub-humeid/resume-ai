<?php

namespace App\Jobs;

use App\Models\Candidate;
use App\Services\ResumeAnalysisService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class AnalyzeCandidate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 180;

    public function __construct(public array $candidateIds, public int $recruiterId)
    {
    }

    public function handle(ResumeAnalysisService $service): void
    {
        $candidates = Candidate::query()
            ->whereIn('id', $this->candidateIds)
            ->where('recruiter_id', $this->recruiterId)
            ->with('job')
            ->get();

        $processedCount = 0;

        foreach ($candidates as $candidate) {
            if (!$candidate->job || blank($candidate->raw_text)) {
                continue;
            }

            try {
                $result = $service->analyzeText($candidate->raw_text, $candidate->job->description);
                $candidate->update([
                    'match_score' => $result['match_score'],
                    'review_data' => $result,
                    'review_state' => 'complete'
                ]);
                $processedCount++;
            } catch (Throwable $exception) {
                report($exception);
                $candidate->update(['review_state' => 'failed']);
                // Continue with next candidate instead of failing entire job
            }
        }

        // Notify the recruiter that the batch job is complete
        $user = \App\Models\User::find($this->recruiterId);
        if ($user) {
            $user->notify(new \App\Notifications\CandidateReviewProcessed($this->recruiterId, $processedCount));
        }
    }
}
