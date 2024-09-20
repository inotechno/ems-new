<?php

namespace App\Livewire\Announcement;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class AnnouncementItem extends Component
{
    use LivewireAlert;

    #[Reactive()]
    public $announcement;

    public function render()
    {
        return view('livewire.announcement.announcement-item');
    }
}
