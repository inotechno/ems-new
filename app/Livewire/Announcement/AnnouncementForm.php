<?php

namespace App\Livewire\Announcement;

use App\Models\Announcement;
use App\Models\Employee;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Schema;
use Str;

class AnnouncementForm extends Component
{
    use LivewireAlert;

    public $title;
    public $slug;
    public $body;
    public $recipients = [];
    public $users;
    public $type = 'create';
    public $preview;

    public function mount($slug = null)
    {
        if ($slug) {
            $announcement = \App\Models\Announcement::with('recipients')->where('slug', $slug)->first();
            $this->title = $announcement->title;
            $this->description = $announcement->description;
            $this->slug = $announcement->slug;
            $this->recipients = $announcement->recipients->pluck('id')->toArray();

            $this->type = 'update';
            $this->dispatch('contentChanged', $this->description);
            $this->dispatch('set-default-form', param: 'recipients', value: $this->recipients);
        }

        $this->users = User::get();
    }

    #[On('setContent')]
    public function setContent($content)
    {
        $content = htmlspecialchars_decode($content);
        $this->body = $content;
        $this->preview = $content;
    }

    #[On('change-input-form')]
    public function changeInputForm($param, $value)
    {
        $this->$param = $value;
        // dd($this->recipients);
    }

    public function save()
    {
        // dd($this);
        try {
            $this->validate([
                'title' => 'required',
                'body' => 'required',
                'recipients' => 'required',
            ]);

            if ($this->type == 'create') {
                $this->store();
            } else {
                $this->update();
            }
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function store()
    {
        try {
            $announcement = Announcement::create([
                'slug' => Str::slug($this->title),
                'title' => $this->title,
                'description' => $this->body,
            ]);

            $announcement->recipients()->sync($this->recipients);

            $this->alert('success', 'Announcement created successfully.');
            return redirect()->route('announcement.index');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function update()
    {
        try {
            $this->announcement->update([
                'title' => $this->title,
                'description' => $this->body,
                'slug' => Str::slug($this->title),
            ]);

            $this->announcement->recipients()->sync($this->recipients);
            $this->alert('success', 'Announcement updated successfully.');
            return redirect()->route('announcement.index');
        } catch (\Exception $e) {
            $this->alert('error', 'Announcement update failed.');
        }
    }

    public function render()
    {
        $user = Schema::getColumnListing('users');

        $placeholders_user = $user; // Data yang akan digunakan sebagai placeholder

        return view('livewire.announcement.announcement-form', [
            'placeholders_user' => $placeholders_user,
        ])->layout('layouts.app', ['title' => 'Email Template Manager']);
    }
}
