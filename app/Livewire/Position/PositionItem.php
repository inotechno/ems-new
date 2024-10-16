<?php

namespace App\Livewire\Position;

use App\Models\Position;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class PositionItem extends Component
{
    use LivewireAlert;

    protected $listeners = [
        'refreshIndex' => '$refresh',
    ];

    public $position;

    public $limitDisplay = 5;

    public function mount(Position $position)
    {
        $this->position = $position;
    }

    public function deleteConfirm()
    {
        $this->alert('warning', 'Are you sure you want to delete this position?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,

            'showConfirmButton' => true,
            'confirmButtonColor' => '#DD6B55',
            'confirmButtonText' => 'Yes, Delete',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'delete-position',
            'showCancelButton' => true,

            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => false,
            'stopKeydownPropagation' => false,
        ]);
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
        $employees = $this->position->employees;
        return view('livewire.position.position-item', [
            'employees' => $employees,
            'employeesLimit' => $employees->take($this->limitDisplay),
            'moreCount' => $employees->count() - $this->limitDisplay,
        ]);
    }
}
