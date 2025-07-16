<?php

namespace App\Livewire\Employee;

use App\Models\Employee;
use App\Models\Position;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EmployeeIndex extends Component
{

    use LivewireAlert, WithPagination;

    #[Url(except: '')]
    public $search = '';

    #[Url]
    public $perPage = 12;
    public $status = '';

    public $position_id;

    public $positions;

    public function mount()
    {
        $this->positions = Position::get();
    }

    protected $queryStrings = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    protected $listeners = [
        'refreshIndex' => '$refresh',
    ];

    public function resetFilter()
    {
        $this->search = '';
        $this->position_id = '';
        $this->perPage = 10;
    }

    public function render()
    {
        $employees = Employee::with('user.roles', 'position')->when($this->search, function ($query) {
            $query->whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        })->when($this->position_id, function ($query) {
            $query->where('position_id', $this->position_id);
        })->latest()->paginate($this->perPage);

        // dd($employees);

        return view('livewire.employee.employee-index', compact('employees'))->layout('layouts.app', ['title' => 'Employee List']);
    }
}
