<?php

namespace App\Livewire\DailyReport;

use App\Livewire\BaseComponent;
use App\Models\DailyReport;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;

class DailyReportTeam extends BaseComponent
{
    use LivewireAlert;

    public $employee_id = [];
    public $perPage = 10;
    public $start_date;
    public $end_date;

    #[Url(except: '')]
    public $search = '';

    public $employees;

    public function mount()
    {
        $this->employees = Employee::with('user')->get();
    }

    public function render()
    {
        $daily_reports = DailyReport::with('employee.user', 'dailyReportRecipients.employee.user')->when($this->search, function ($query) {
            $query->where('description', 'like', '%' . $this->search . '%');
        })->when($this->employee_id, function ($query) {
            $query->whereIn('employee_id', $this->employee_id);
        })->when($this->start_date, function ($query) {
            $query->whereDate('date', '>=', $this->start_date);
        })->when($this->end_date, function ($query) {
            $query->whereDate('date', '<=', $this->end_date);
        })->latest();

        $daily_reports = $daily_reports->whereHas('dailyReportRecipients', function ($query) {
            $query->where('employee_id', $this->authUser->employee->id);
        })->paginate($this->perPage);

        // dd($daily_reports);
        return view('livewire.daily-report.daily-report-team', compact('daily_reports'))->layout('layouts.app', ['title' => 'Team Daily Report']);
    }
}
