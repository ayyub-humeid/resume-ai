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
        public int $processedCount
    ) {}

    public function via($notifiable): array
    {
        return ['broadcast'];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return (new BroadcastMessage([
            'message' => "Finished ranking {$this->processedCount} candidate(s).",
            'type' => 'success'
        ]));
    }

    public function broadcastOn(): array
    {
        return [new PrivateChannel('recruiter.notifications.' . $this->recruiterId)];
    }
}
