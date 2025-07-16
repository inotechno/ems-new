<?php

namespace App\Livewire\Component;

use App\Livewire\BaseComponent;
use App\Models\Notification;
use Livewire\Component;

class NotificationHeader extends BaseComponent
{
    public $notifications;
    public $countNotifications = 0;

    public function mount()
    {
        $this->notifications = Notification::where('user_id', $this->authUser->id)->where('is_read', false)->get();
        $this->countNotifications = $this->notifications->count();
    }

    public function markAsRead($id, $url)
    {
        readNotification($id);
        return redirect($url);
    }

    public function render()
    {
        return view('livewire.component.notification-header');
    }
}
