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
        $this->alert(
            'question',
            'Are you sure you want to delete this role?',
            [
                'toast' => false,
                'timer' => 3000,
                'role' => 'center',
                'showConfirmButton' => true,
                'showCancelButton' => true,
                'confirmButtonColor' => '#cc2626',
                'confirmButtonText' => 'Yes, Delete it!',
                'cancelButtonText' => 'No, Cancel!',
                'onConfirmed' => 'delete-role',
                'timerProgressBar' => true,
            ]
        );
    }

    #[On('delete-role')]
    public function delete()
    {
        $this->role->delete();
        $this->alert('success', 'role deleted successfully');
        $this->dispatch('refreshIndex');
    }

    public function render()
    {
        return view('livewire.role.role-item');
    }


}
