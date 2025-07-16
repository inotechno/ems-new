<?php

namespace App\Livewire\Announcement;

use App\Jobs\SendAnnouncement;
use App\Livewire\BaseComponent;
use App\Models\Announcement;
use App\Models\Employee;
use App\Models\User;
use App\Services\EmailService;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Schema;
use Str;

class AnnouncementForm extends BaseComponent
{
    use LivewireAlert;

    public $announcement;
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
            $this->announcement = $announcement;
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

            SendAnnouncement::dispatch($announcement);

            $this->alert('success', 'Announcement created successfully.');

            activity()
                ->causedBy($this->authUser) // Pengguna yang melakukan login
                ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
                ->event('create')
                ->log("{$this->authUser->name} telah membuat Announcement");

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

            activity()
                ->causedBy($this->authUser) // Pengguna yang melakukan login
                ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
                ->event('update')
                ->log("{$this->authUser->name} telah mengubah Announcement");

            return redirect()->route('announcement.index');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
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
