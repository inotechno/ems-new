<?php

namespace App\Livewire\Report;

use App\Models\FinancialRequest;
use Illuminate\Support\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class FinancialRequestPreview extends Component
{
    use LivewireAlert;
    public $startDate;
    public $endDate;
    public $selectedEmployees;
    public $reports;

    #[On('financial-request-preview')]
    public function preview($employees, $startDate, $endDate)
    {
        $this->selectedEmployees = $employees;

        $this->startDate = Carbon::parse($startDate)->startOfDay();
        $this->endDate = Carbon::parse($endDate)->endOfDay();

        // dd($this->startDate, $this->endDate);
        $this->countDays = daysBetween($this->startDate, $this->endDate) + 1;

        try {
            // Fetch absent requests
            $financialRequests = FinancialRequest::with('employee.user', 'financialType')->select('employee_id', 'created_at', 'financial_type_id', 'amount', 'notes')
                ->whereIn('employee_id', $this->selectedEmployees)
                ->where('is_approved', true)
                ->where(function ($query) {
                    $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
                })
                ->get();

            $this->reports = $financialRequests;
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.report.financial-request-preview');
    }
}
