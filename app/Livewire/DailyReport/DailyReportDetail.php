<?php

namespace App\Livewire\DailyReport;

use App\Livewire\BaseComponent;
use App\Models\DailyReport;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DailyReportDetail extends BaseComponent
{
    public $daily_report;
    public $date, $description, $day, $recipients, $employee, $reads;

    public function mount($id)
    {
        $this->daily_report = DailyReport::find($id);

        if(!$this->daily_report) {
            return redirect()->route('daily-report.index');
        }

        $this->setReadDailyReport();
        $this->date = $this->daily_report->date->format('d M Y');
        $this->employee = $this->daily_report->employee;
        $this->description = $this->daily_report->description;
        $this->day = $this->daily_report->day;
        $this->recipients = $this->daily_report->dailyReportRecipients;
        $this->reads = $this->daily_report->dailyReportReads;

        activity()
            ->causedBy($this->authUser) // Pengguna yang melakukan login
            ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
            ->event('read')
            ->log("{$this->authUser->name} telah melihat daily report");
    }

    public function setReadDailyReport()
    {
        $checkRead = $this->daily_report->dailyReportReads()->where('employee_id', $this->authUser->employee->id)->first();
        if (!$checkRead) {
            $this->daily_report->dailyReportReads()->create([
                'employee_id' => $this->authUser->employee->id
            ]);
        }
    }

    public function render()
    {
        return view('livewire.daily-report.daily-report-detail')->layout('layouts.app', ['title' => 'Daily Report Detail']);
    }
}
