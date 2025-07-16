<?php

namespace App\Livewire\Role;

use App\Livewire\BaseComponent;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class RoleItem extends BaseComponent
{
    use LivewireAlert;

    #[Reactive]
    public $role;
    public $limitDisplay = 5;

    public function deleteConfirm()
    {
        // dd($this->user);
        $this->alert('warning', 'Are you sure you want to delete this role?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,

            'showConfirmButton' => true,
            'confirmButtonColor' => '#DD6B55',
            'confirmButtonText' => 'Yes, Delete',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'delete-role',
            'showCancelButton' => true,

            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => false,
            'stopKeydownPropagation' => false,
        ]);
    }

    #[On('delete-role')]
    public function delete()
    {
        $this->role->delete();
        $this->alert('success', 'Role deleted successfully');

        activity()
            ->causedBy($this->authUser) // Pengguna yang melakukan login
            ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
            ->event('delete')
            ->log("{$this->authUser->name} telah menghapus role");

        $this->dispatch('refreshIndex');
    }

    public function render()
    {
        return view('livewire.role.role-item');
    }


}
