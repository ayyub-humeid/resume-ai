<?php

namespace App\Notifications;

use Illuminate\Broadcasting\PrivateChannel;
// use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class CandidateReviewProcessed extends Notification
// implements ShouldQueue
{
    // use Queueable;

    public function __construct(
        public int $recruiterId,
        public int $processedCount
    ) {
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => 'Candidate Ranking Finished',
            'body' => "We have successfully finished analyzing and ranking {$this->processedCount} candidate(s).",
            'link' => route('dashboard.recruiter.candidates'),
            'type' => 'success'
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return (new BroadcastMessage([
            'title' => 'Candidate Ranking Finished',
            'body' => "We have successfully finished analyzing and ranking {$this->processedCount} candidate(s).",
            'link' => route('dashboard.recruiter.candidates'),
            'message' => "Ranking finished! {$this->processedCount} candidate(s) were successfully analyzed.",
            'type' => 'success'
        ]));
    }

    public function broadcastOn(): array
    {
        return [new PrivateChannel('recruiter.notifications.' . $this->recruiterId)];
    }
}
