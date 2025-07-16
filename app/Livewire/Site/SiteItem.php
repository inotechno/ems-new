<?php

namespace App\Livewire\Site;

use App\Livewire\BaseComponent;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;

class SiteItem extends BaseComponent
{
    use LivewireAlert;

    #[Reactive]
    public $site;

    public function deleteConfirm()
    {
        // dd($this->user);
        $this->alert('warning', 'Are you sure you want to delete this site?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,

            'showConfirmButton' => true,
            'confirmButtonColor' => '#DD6B55',
            'confirmButtonText' => 'Yes, Delete',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'delete-site',
            'showCancelButton' => true,

            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => false,
            'stopKeydownPropagation' => false,
        ]);
    }

    #[On('delete-site')]
    public function delete()
    {
        $this->site->delete();
        $this->alert('success', 'Site deleted successfully');

        activity()
            ->causedBy($this->authUser) // Pengguna yang melakukan login
            ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
            ->event('delete')
            ->log("{$this->authUser->name} telah menghapus site");

        $this->dispatch('refreshIndex');
    }

    public function render()
    {
        return view('livewire.site.site-item');
    }
}
