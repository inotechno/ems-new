<?php

namespace App\Livewire\Announcement;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Str;

class AnnouncementItem extends Component
{
    use LivewireAlert;

    #[Reactive]
    public $announcement;
    public $title;
    public $description;
    public $description_excerpt;
    public $slug;
    public $recipients;
    public $limitDisplay = 7;
    public $created_at;

    public function mount()
    {
        $this->title = $this->announcement->title;
        $this->description = $this->announcement->description;
        $this->description_excerpt = Str::limit(strip_tags($this->announcement->description), 100);
        $this->slug = $this->announcement->slug;

        $this->recipients = $this->announcement->recipients;
        $this->created_at = $this->announcement->created_at->format('F j, Y');
    }

    public function render()
    {
        $user = $this->recipients;
// dd($user->count() - $this->limitDisplay);
        return view('livewire.announcement.announcement-item', [
            'usersLimit' => $user->take($this->limitDisplay),
            'moreCount' => $user->count() - $this->limitDisplay,
        ]);
    }
}
