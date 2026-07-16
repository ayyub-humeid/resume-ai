<?php

namespace App\Notifications;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class CandidateReviewProcessed extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $recruiterId,
        public int $candidateId,
        public string $candidateName,
        public string $status, // 'completed' | 'failed'
        public ?int $matchScore = null,
        public ?string $jobTitle = null,
    ) {}

    public function via($notifiable): array
    {
        return ['broadcast'];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return (new BroadcastMessage([
            'candidate_id' => $this->candidateId,
            'candidate_name' => $this->candidateName,
            'job_title' => $this->jobTitle,
            'status' => $this->status,
            'match_score' => $this->matchScore,
            'message' => $this->status === 'completed'
                ? "{$this->candidateName}'s review is complete."
                : "{$this->candidateName}'s review failed.",
        ]))->onQueue('notifications');
    }

    // Custom event name on the frontend (Echo .listen('.candidate.review.processed', ...))
    public function broadcastType(): string
    {
        return 'candidate.review.processed';
    }

    // Custom channel instead of the default App.Models.User.{id}
    public function broadcastOn(): array
    {
        return [new PrivateChannel('recruiter.' . $this->recruiterId)];
    }
}
