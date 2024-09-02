<?php

namespace App\Livewire\Role;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class RoleItem extends Component
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
        $this->dispatch('refreshIndex');
    }

    public function render()
    {
        return view('livewire.role.role-item');
    }


}
