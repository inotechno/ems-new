<?php

namespace App\Livewire\Announcement;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class AnnouncementList extends Component
{
    #[Reactive]
    public $announcements;

    public function render()
    {
        return view('livewire.announcement.announcement-list');
    }
}
