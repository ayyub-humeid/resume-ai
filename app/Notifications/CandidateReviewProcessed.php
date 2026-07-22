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
            'title' => __('Candidate Ranking Finished'),
            'body' => __('We have successfully finished analyzing and ranking :count candidate(s).', ['count' => $this->processedCount]),
            'link' => route('dashboard.recruiter.candidates'),
            'type' => 'success'
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return (new BroadcastMessage([
            'title' => __('Candidate Ranking Finished'),
            'body' => __('We have successfully finished analyzing and ranking :count candidate(s).', ['count' => $this->processedCount]),
            'link' => route('dashboard.recruiter.candidates'),
            'message' => __('Ranking finished! :count candidate(s) were successfully analyzed.', ['count' => $this->processedCount]),
            'type' => 'success'
        ]));
    }

    public function broadcastOn(): array
    {
        return [new PrivateChannel('recruiter.notifications.' . $this->recruiterId)];
    }
}
