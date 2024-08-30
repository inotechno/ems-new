<?php

namespace App\Livewire\DailyReport;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class DailyReportList extends Component
{
    #[Reactive]
    public $daily_reports;

    public function render()
    {
        return view('livewire.daily-report.daily-report-list');
    }
}
