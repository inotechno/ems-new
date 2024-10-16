<?php

namespace App\Livewire\Report;

use App\Models\Visit;
use Illuminate\Support\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class VisitPreview extends Component
{
    use LivewireAlert;
    public $startDate;
    public $endDate;
    public $selectedEmployees;
    public $reports;

    #[On('visit-preview')]
    public function preview($employees, $startDate, $endDate)
    {
        $this->selectedEmployees = $employees;

        $this->startDate = Carbon::parse($startDate)->startOfDay();
        $this->endDate = Carbon::parse($endDate)->endOfDay();

        // dd($this->startDate, $this->endDate);
        $this->countDays = daysBetween($this->startDate, $this->endDate) + 1;

        try {
            // Fetch absent requests
            $visits = Visit::with('employee.user', 'site', 'visitCategory')->select('employee_id', 'visit_category_id','site_id','created_at', 'longitude', 'latitude', 'distance', 'notes')
                ->whereIn('employee_id', $this->selectedEmployees)
                ->where('is_approved', true)
                ->where(function ($query){
                    $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
                })
                ->get();

            $this->reports = $visits;
            // dd($this->reports);
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.report.visit-preview');
    }
}
