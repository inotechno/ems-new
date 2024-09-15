<?php

namespace App\Livewire\Visit;

use App\Livewire\BaseComponent;
use App\Models\Visit;
use Livewire\Component;
use Livewire\WithPagination;

class VisitIndex extends BaseComponent
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
        // Fetch visit data with related models
        $visits = Visit::with(['employee.user', 'site', 'visitCategory'])
            ->when($this->search, function ($query) {
                $query->whereHas('employee.user', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->start_date, function ($query) {
                $query->whereDate('created_at', '>=', $this->start_date);
            })
            ->when($this->end_date, function ($query) {
                $query->whereDate('created_at', '<=', $this->end_date);
            })
            ->select('employee_id')
            ->selectRaw('DATE(created_at) as date')
            ->selectRaw('MIN(created_at) as check_in')
            ->selectRaw('MAX(created_at) as check_out')
            ->groupBy('employee_id', 'date')
            ->orderBy('date', 'desc');

        if ($this->authUser->can('view:visit-all')) {
            $visits = $visits->paginate($this->perPage);
        } else {
            $visits = $visits->where('employee_id', $this->authUser->employee->id)->paginate($this->perPage);
        }

        // Fetch all check-in and check-out records at once with relations
        $checkInDetails = Visit::whereIn('created_at', $visits->pluck('check_in'))
            ->with(['employee.user', 'site', 'visitCategory'])
            ->get()
            ->keyBy(function ($item) {
                return $item->employee_id . '-' . $item->created_at;
            });

        $checkOutDetails = Visit::whereIn('created_at', $visits->pluck('check_out'))
            ->with(['employee.user', 'site', 'visitCategory'])
            ->get()
            ->keyBy(function ($item) {
                return $item->employee_id . '-' . $item->created_at;
            });

        // Transform the paginated results
        $visits->getCollection()->transform(function ($visit) use ($checkInDetails, $checkOutDetails) {
            $checkInKey = $visit->employee_id . '-' . $visit->check_in;
            $checkOutKey = $visit->employee_id . '-' . $visit->check_out;

            $checkInDetail = $checkInDetails[$checkInKey] ?? null;
            $checkOutDetail = $checkOutDetails[$checkOutKey] ?? null;

            $checkInTimestamp = $checkInDetail ? new \DateTime($checkInDetail->created_at) : null;
            $checkOutTimestamp = $checkOutDetail ? new \DateTime($checkOutDetail->created_at) : null;

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
                    'id' => $checkInDetail->id,
                    'created_at' => $checkInDetail->created_at,
                    'visit_category' => $checkInDetail->visitCategory ? [
                        'id' => $checkInDetail->visitCategory->id,
                        'name' => $checkInDetail->visitCategory->name,
                    ] : null,
                    'site' => $checkInDetail->site ? [
                        'id' => $checkInDetail->site->id,
                        'name' => $checkInDetail->site->name,
                        'longitude' => $checkInDetail->site->longitude,
                        'latitude' => $checkInDetail->site->latitude,
                    ] : null,
                    'longitude' => $checkInDetail->longitude,
                    'latitude' => $checkInDetail->latitude,
                    'file_url' => $checkInDetail->file_url ?? null,
                    'distance' => $checkInDetail->distance,
                    'notes' => $checkInDetail->notes,
                ] : null,
                'check_out' => $checkOutDetail ? [
                    'id' => $checkOutDetail->id,
                    'created_at' => $checkOutDetail->created_at,
                    'visit_category' => $checkOutDetail->visitCategory ? [
                        'id' => $checkOutDetail->visitCategory->id,
                        'name' => $checkOutDetail->visitCategory->name,
                    ] : null,
                    'site' => $checkOutDetail->site ? [
                        'id' => $checkOutDetail->site->id,
                        'name' => $checkOutDetail->site->name,
                        'longitude' => $checkOutDetail->site->longitude,
                        'latitude' => $checkOutDetail->site->latitude,
                    ] : null,
                    'longitude' => $checkOutDetail->longitude,
                    'latitude' => $checkOutDetail->latitude,
                    'file_url' => $checkOutDetail->file_url ?? null,
                    'distance' => $checkOutDetail->distance,
                    'notes' => $checkOutDetail->notes,
                ] : null,
                'employee_id' => $visit->employee_id,
                'date' => $visit->date,
                'duration_string' => $formattedDuration, // Total hours
                'duration' => $duration, // Total hours in decimal
            ];
        });

        return view('livewire.visit.visit-index', [
            'visits' => $visits
        ])->layout('layouts.app', ['title' => 'Visit']);
    }
}
