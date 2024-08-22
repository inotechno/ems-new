<?php

namespace App\Livewire\Position;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class PositionItem extends Component
{
    use LivewireAlert;

    #[Reactive]
    public $position;
    public $limitDisplay = 5;

    public function deleteConfirm()
    {
        $this->alert(
            'question',
            'Are you sure you want to delete this position?',
            [
                'toast' => false,
                'timer' => 3000,
                'position' => 'center',
                'showConfirmButton' => true,
                'showCancelButton' => true,
                'confirmButtonColor' => '#cc2626',
                'confirmButtonText' => 'Yes, Delete it!',
                'cancelButtonText' => 'No, Cancel!',
                'onConfirmed' => 'delete-position',
                'timerProgressBar' => true,
            ]
        );
    }

    #[On('delete-position')]
    public function delete()
    {
        $this->position->delete();
        $this->alert('success', 'Position deleted successfully');
        $this->dispatch('refreshIndex');
    }

    public function render()
    {
        return view('livewire.position.position-item', [
            'employees' => $this->position->employees->take($this->limitDisplay),
            'moreCount' => $this->position->employees->count() - $this->limitDisplay,
        ]);
    }
}
