<?php

namespace App\Livewire\AttendanceTemp;

use App\Models\AttendanceTemp;
use Livewire\Component;
use Livewire\WithPagination;

class AttendanceTempIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $start_date = '';
    public $end_date = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'start_date' => ['except' => ''],
        'end_date' => ['except' => ''],
        'employee_id' => ['except' => ''],
    ];

    protected $listeners = ['refresh' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStart_date()
    {
        $this->resetPage();
    }

    public function updatingEnd_date()
    {
        $this->resetPage();
    }

    public function resetFilter()
    {
        $this->reset(['search', 'start_date', 'end_date']);
    }

    public function render()
    {
        $attendances = AttendanceTemp::with('employee.user', 'attendanceMethod')
        ->when($this->search, function ($query) {
            $query->whereHas('employee.user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        })->when($this->start_date, function ($query) {
            $query->whereDate('timestamp', '>=', $this->start_date);
        })->when($this->end_date, function ($query) {
            $query->whereDate('timestamp', '<=', $this->end_date);
        });

        $attendances = $attendances->paginate($this->perPage);

        return view('livewire.attendance-temp.attendance-temp-index', compact('attendances'))->layout('layouts.app', ['title' => 'Attendance Temp', 'attendances' => $attendances]);
    }
}
