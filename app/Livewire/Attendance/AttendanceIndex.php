<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class AttendanceIndex extends Component
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
        // Fetch attendance data with related models
        $attendances = Attendance::with(['employee.user', 'machine', 'site', 'attendanceMethod'])
            ->when($this->search, function ($query) {
                $query->whereHas('employee.user', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->start_date, function ($query) {
                $query->whereDate('timestamp', '>=', $this->start_date);
            })
            ->when($this->end_date, function ($query) {
                $query->whereDate('timestamp', '<=', $this->end_date);
            })
            ->select('employee_id')
            ->selectRaw('DATE(timestamp) as date')
            ->selectRaw('MIN(timestamp) as check_in')
            ->selectRaw('MAX(timestamp) as check_out')
            ->groupBy('employee_id', 'date')
            ->orderBy('date', 'desc')
            ->paginate($this->perPage);

        // Fetch all check-in and check-out records at once with relations
        $checkInDetails = Attendance::whereIn('timestamp', $attendances->pluck('check_in'))
            ->with(['employee.user', 'machine', 'site', 'attendanceMethod'])
            ->get()
            ->keyBy(function ($item) {
                return $item->employee_id . '-' . $item->timestamp;
            });

        $checkOutDetails = Attendance::whereIn('timestamp', $attendances->pluck('check_out'))
            ->with(['employee.user', 'machine', 'site', 'attendanceMethod'])
            ->get()
            ->keyBy(function ($item) {
                return $item->employee_id . '-' . $item->timestamp;
            });

        // Transform the paginated results
        $attendances->getCollection()->transform(function ($attendance) use ($checkInDetails, $checkOutDetails) {
            $checkInKey = $attendance->employee_id . '-' . $attendance->check_in;
            $checkOutKey = $attendance->employee_id . '-' . $attendance->check_out;

            $checkInDetail = $checkInDetails[$checkInKey] ?? null;
            $checkOutDetail = $checkOutDetails[$checkOutKey] ?? null;

            $checkInTimestamp = $checkInDetail ? new \DateTime($checkInDetail->timestamp) : null;
            $checkOutTimestamp = $checkOutDetail ? new \DateTime($checkOutDetail->timestamp) : null;

            $duration = null;
            $formattedDuration = null;

            if ($checkInTimestamp && $checkOutTimestamp) {
                $interval = $checkInTimestamp->diff($checkOutTimestamp);
                $hours = $interval->h + ($interval->days * 24); // Total hours
                $minutes = $interval->i; // Minutes
                $seconds = $interval->s; // Seconds

                $duration = $hours + ($minutes / 60) + ($seconds / 3600); // Total hours in decimal

                // Format duration as "H hours, M minutes, S seconds"
                $formattedDuration = sprintf('%d hours, %d minutes, %d seconds', $hours, $minutes, $seconds);
            }

            return [
                'id' => $checkInDetail->uid . '-' . $checkOutDetail->uid,
                'employee' => $checkInDetail ? [
                    'id' => $checkInDetail->employee->id,
                    'name' => $checkInDetail->employee->user->name,
                    'email' => $checkInDetail->employee->user->email,
                    'avatar_url' => $checkInDetail->employee->user->avatar_url,
                ] : null,
                'check_in' => $checkInDetail ? [
                    'timestamp' => $checkInDetail->timestamp,
                    'machine' => $checkInDetail->machine ? [
                        'id' => $checkInDetail->machine->id,
                        'name' => $checkInDetail->machine->name,
                        // Add more machine details as needed
                    ] : null,
                    'site' => $checkInDetail->site ? [
                        'id' => $checkInDetail->site->id,
                        'name' => $checkInDetail->site->name,
                        // Add more site details as needed
                    ] : null,
                    'attendance_method' => $checkInDetail->attendanceMethod ? [
                        'id' => $checkInDetail->attendanceMethod->id,
                        'name' => $checkInDetail->attendanceMethod->name,
                        // Add more attendance method details as needed
                    ] : null,
                    'uid' => $checkInDetail->uid,
                    'longitude' => $checkInDetail->longitude,
                    'latitude' => $checkInDetail->latitude,
                ] : null,
                'check_out' => $checkOutDetail ? [
                    'timestamp' => $checkOutDetail->timestamp,
                    'machine' => $checkOutDetail->machine ? [
                        'id' => $checkOutDetail->machine->id,
                        'name' => $checkOutDetail->machine->name,
                        // Add more machine details as needed
                    ] : null,
                    'site' => $checkOutDetail->site ? [
                        'id' => $checkOutDetail->site->id,
                        'name' => $checkOutDetail->site->name,
                        // Add more site details as needed
                    ] : null,
                    'attendance_method' => $checkOutDetail->attendanceMethod ? [
                        'id' => $checkOutDetail->attendanceMethod->id,
                        'name' => $checkOutDetail->attendanceMethod->name,
                        // Add more attendance method details as needed
                    ] : null,
                    'uid' => $checkOutDetail->uid,
                    'longitude' => $checkOutDetail->longitude,
                    'latitude' => $checkOutDetail->latitude,
                ] : null,
                'employee_id' => $attendance->employee_id,
                'date' => $attendance->date,
                'duration_string' => $formattedDuration, // Total hours
                'duration' => $duration, // Total hours in decimal
            ];
        });

        // dd($attendances);

        return view('livewire.attendance.attendance-index', [
            'attendances' => $attendances
        ])->layout('layouts.app', ['title' => 'Attendance List']);
    }
}
