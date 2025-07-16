<?php

namespace App\Livewire\EmailTemplateManager;

use App\Livewire\BaseComponent;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class EmailTemplateManagerItem extends BaseComponent
{
    use LivewireAlert;

    #[Reactive]
    public $template;

    public function deleteConfirm()
    {
        // dd($this->user);
        $this->alert('warning', 'Are you sure you want to delete this template?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,

            'showConfirmButton' => true,
            'confirmButtonColor' => '#DD6B55',
            'confirmButtonText' => 'Yes, Delete',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'delete-template',
            'showCancelButton' => true,

            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => false,
            'stopKeydownPropagation' => false,
        ]);
    }

    #[On('delete-template')]
    public function delete()
    {
        $this->template->delete();
        $this->alert('success', 'Template deleted successfully');

        activity()
            ->causedBy($this->authUser) // Pengguna yang melakukan login
            ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
            ->event('delete')
            ->log("{$this->authUser->name} telah menghapus Email Template");

        $this->dispatch('refreshIndex');
    }

    public function render()
    {
        return view('livewire.email-template-manager.email-template-manager-item');
    }
}
