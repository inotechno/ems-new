<?php

namespace App\Livewire\Machine;

use App\Models\Machine;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class MachineItem extends Component
{
    use LivewireAlert;

    #[Reactive]
    public $machine;

    public function deleteConfirm()
    {
        $this->alert(
            'question',
            'Are you sure you want to delete this machine?',
            [
                'toast' => false,
                'timer' => 3000,
                'position' => 'center',
                'showConfirmButton' => true,
                'showCancelButton' => true,
                'confirmButtonColor' => '#cc2626',
                'confirmButtonText' => 'Yes, Delete it!',
                'cancelButtonText' => 'No, Cancel!',
                'onConfirmed' => 'delete-machine',
                'timerProgressBar' => true,
            ]
        );
    }

    #[On('delete-machine')]
    public function delete()
    {
        $this->machine->delete();
        $this->alert('success', 'Machine deleted successfully');
        $this->dispatch('refreshIndex');
    }

    public function render()
    {
        // dd($this->machine);
        return view('livewire.machine.machine-item');
    }
}
