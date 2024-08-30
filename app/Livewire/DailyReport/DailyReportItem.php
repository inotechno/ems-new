<?php

namespace App\Livewire\DailyReport;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class DailyReportItem extends Component
{
    #[Reactive]
    public $daily_report;

    public function render()
    {
        $employee = $this->daily_report->employee;
        $user = $employee->user;

        return view('livewire.daily-report.daily-report-item', [
            'daily_report' => $this->daily_report,
            'employee' => $employee,
            'user' => $user
        ]);
    }
}
