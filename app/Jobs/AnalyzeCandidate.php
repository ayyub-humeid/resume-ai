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

    public function __construct(public int $candidateId, public int $recruiterId) {}

    public function handle(ResumeAnalysisService $service): void
    {
        $candidate = Candidate::query()->where('id', $this->candidateId)->where('recruiter_id', $this->recruiterId)->with('job')->first();

        if (! $candidate || ! $candidate->job || blank($candidate->raw_text)) {
            return;
        }

        try {
            $result = $service->analyzeText($candidate->raw_text, $candidate->job->description);
            $candidate->update(['match_score' => $result['match_score'], 'review_data' => $result, 'review_state' => 'complete']);

        } catch (Throwable $exception) {
            report($exception);
            $candidate->update(['review_state' => 'failed']);
            throw $exception;
        }
    }
}
