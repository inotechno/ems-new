<?php

namespace App\Livewire\Announcement;

use App\Models\Announcement;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Str;

class AnnouncementForm extends Component
{
    use LivewireAlert;

    public $title;
    public $description;
    public $slug;
    public $content;
    public $previewContent;
    public $recipients = [];
    public $mode = 'create';

    public function mount($slug = null)
    {
        if ($slug) {
            $announcement = \App\Models\Announcement::where('slug', $slug)->first();
            $this->title = $announcement->title;
            $this->description = $announcement->description;
            $this->slug = $announcement->slug;

            $this->mode = 'update';
        }
    }

    #[On('contentChanged')]
    public function setContent($content)
    {
        $this->content = $content;
        $this->previewContent = $content;
    }

    public function save()
    {
        $this->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        if($this->mode == 'create') {
            $this->store();
        } else {
            $this->update();
        }
    }

    public function store()
    {
        try {
            $announcement = Announcement::create([
                'slug' => Str::slug($this->title),
                'title' => $this->title,
                'description' => $this->description,
            ]);

            $announcement->recipients()->sync($this->recipients);

            $this->alert('success', 'Announcement created successfully.');
            return redirect()->route('announcements.index');
        } catch (\Exception $e) {
            $this->alert('error', 'Announcement creation failed.');
        }
    }

    public function update()
    {
        try {
            $this->announcement->update([
                'title' => $this->title,
                'description' => $this->description,
                'slug' => Str::slug($this->title),
            ]);

            $this->announcement->recipients()->sync($this->recipients);
            $this->alert('success', 'Announcement updated successfully.');
            return redirect()->route('announcements.index');
        } catch (\Exception $e) {
            $this->alert('error', 'Announcement update failed.');
        }
    }

    public function render()
    {
        return view('livewire.announcement.announcement-form');
    }
}
