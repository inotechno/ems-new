<?php

namespace App\Livewire\DailyReport;

use App\Models\DailyReport;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DailyReportDetail extends Component
{
    public $daily_report;
    public $date, $description, $day, $recipients, $employee, $reads;

    public function mount($id)
    {
        $this->daily_report = DailyReport::find($id);
        $this->setReadDailyReport();
        $this->date = $this->daily_report->date->format('d, M Y');
        $this->employee = $this->daily_report->employee;
        $this->description = $this->daily_report->description;
        $this->day = $this->daily_report->day;
        $this->recipients = $this->daily_report->dailyReportRecipients;
        $this->reads = $this->daily_report->dailyReportReads;
    }

    public function setReadDailyReport()
    {
        $checkRead = $this->daily_report->dailyReportReads()->where('employee_id', Auth::user()->employee->id)->first();
        if (!$checkRead) {
            $this->daily_report->dailyReportReads()->create([
                'employee_id' => Auth::user()->employee->id
            ]);
        }
    }

    public function render()
    {
        return view('livewire.daily-report.daily-report-detail')->layout('layouts.app', ['title' => 'Daily Report Detail']);
    }
}
