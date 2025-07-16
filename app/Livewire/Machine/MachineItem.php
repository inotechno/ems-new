<?php

namespace App\Livewire\Machine;

use App\Livewire\BaseComponent;
use App\Models\Machine;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;

class MachineItem extends BaseComponent
{
    use LivewireAlert;

    #[Reactive]
    public $machine;

    public function deleteConfirm()
    {
        // dd($this->user);
        $this->alert('warning', 'Are you sure you want to delete this machine?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,

            'showConfirmButton' => true,
            'confirmButtonColor' => '#DD6B55',
            'confirmButtonText' => 'Yes, Delete',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'delete-machine',
            'showCancelButton' => true,

            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => false,
            'stopKeydownPropagation' => false,
        ]);
    }


    #[On('delete-machine')]
    public function delete()
    {
        $this->machine->delete();
        $this->alert('success', 'Machine deleted successfully');

        activity()
            ->causedBy($this->authUser) // Pengguna yang melakukan login
            ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
            ->event('delete')
            ->log("{$this->authUser->name} telah menghapus machine");

        $this->dispatch('refreshIndex');
    }

    public function render()
    {
        // dd($this->machine);
        return view('livewire.machine.machine-item');
    }
}
