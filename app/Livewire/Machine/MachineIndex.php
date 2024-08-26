<?php

namespace App\Livewire\Machine;

use App\Models\Machine;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class MachineIndex extends Component
{
    use LivewireAlert, WithPagination;

    #[Url(except: '')]
    public $search;
    public $is_active = true;
    public $perPage = 10;
    public $showForm = true;

    protected $listeners = [
        'refreshIndex' => '$refresh',
    ];

    public function changeStatusForm()
    {
        if ($this->showForm) {
            $this->showForm = false;
        } else {
            $this->showForm = true;
        }
    }

    #[On('change-status-form')]
    public function updateShowForm()
    {
        $this->showForm = true;
        $this->dispatch('collapse-form');
    }

    public function render()
    {
        $machines = Machine::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('ip_address', 'like', '%' . $this->search . '%')
                ->orWhere('port', 'like', '%' . $this->search . '%');
        })->where('is_active', $this->is_active)->orderBy('name', 'ASC');

        $machines = $machines->paginate($this->perPage);

        // dd($machines->getCollection());
        return view('livewire.machine.machine-index', compact('machines'))->layout('layouts.app', ['title' => 'Machine']);
    }
}
