<?php

namespace App\Livewire\General;

use Livewire\Component;

class NotificationBell extends Component
{
    public function markAsRead($notificationId)
    {
        $notification = auth()->user()->notifications()->find($notificationId);
        if ($notification) {
            $notification->markAsRead();
        }
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
    }

    public function render()
    {
        return view('livewire.general.notification-bell', [
            'notifications' => auth()->user()->notifications()->latest()->take(10)->get()
        ]);
    }
}
