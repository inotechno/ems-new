<?php

namespace App\Livewire\Component\Widget\Table;

use App\Models\AttendanceAnalytic;
use App\Models\Employee;
use Illuminate\Support\Carbon;
use Livewire\Component;

class WorkingHoursAnalyticsModal extends Component
{
    public $employeeId;
    public $employeeName;
    public $selectedMonth;
    public $months;

    public $labels = [];
    public $series = [];
    public $chartId;

    protected $listeners = ['openEmployeeChart', 'resetChartId'];

    public function mount()
    {
        $this->selectedMonth = now()->month;
        $this->months = collect(range(1, 12))->mapWithKeys(fn($m) => [$m => Carbon::create()->month($m)->format('M')])->toArray();
    }

    public function openEmployeeChart($id, $month)
    {
        $this->dispatch('modal-hide');
        $this->selectedMonth = $month;
        $this->employeeId = $id;
        $this->employeeName = Employee::find($id)?->user?->name ?? 'Unknown';

        if (!$this->chartId) {
            $this->chartId = 'employee-line-chart-' . $this->employeeId;
        }

        $this->getChartData();
        $this->dispatch('refresh-employee-chart', series: $this->series, labels: $this->labels, chartId: $this->chartId);
        $this->dispatch('modal-show');
    }

    public function resetChartId()
    {
        $this->chartId = null;
    }

    public function updatedSelectedMonth()
    {
        $this->getChartData();
        $this->dispatch('refresh-employee-chart', series: $this->series, labels: $this->labels, chartId: $this->chartId);
    }

    public function getChartData()
    {
        $this->labels = [];
        $thisMonthData = [];
        $lastMonthData = [];

        $year = now()->year;
        $startThis = Carbon::create($year, $this->selectedMonth)->startOfMonth();
        $endThis = Carbon::create($year, $this->selectedMonth)->endOfMonth();

        $startLast = $startThis->copy()->subMonth();
        $endLast = $endThis->copy()->subMonth();

        $thisMonthAnalytics = AttendanceAnalytic::where('employee_id', $this->employeeId)
            ->whereBetween('date', [$startThis, $endThis])
            ->get()
            ->keyBy(fn($r) => Carbon::parse($r->date)->day); // kunci: tanggal

        $lastMonthAnalytics = AttendanceAnalytic::where('employee_id', $this->employeeId)
            ->whereBetween('date', [$startLast, $endLast])
            ->get()
            ->keyBy(fn($r) => Carbon::parse($r->date)->day);

        // Loop tanggal 1 s/d jumlah hari maksimal antara 2 bulan
        $maxDays = max($startThis->daysInMonth, $startLast->daysInMonth);

        for ($i = 1; $i <= $maxDays; $i++) {
            $this->labels[] = str_pad($i, 2, '0', STR_PAD_LEFT); // contoh: "01", "02", dst

            // This month
            if ($thisMonthAnalytics->has($i)) {
                [$h, $m, $s] = explode(':', $thisMonthAnalytics[$i]->working_hourse);
                $thisMonthData[] = round($h + ($m / 60) + ($s / 3600), 2);
            } else {
                $thisMonthData[] = 0;
            }

            // Last month
            if ($lastMonthAnalytics->has($i)) {
                [$h, $m, $s] = explode(':', $lastMonthAnalytics[$i]->working_hourse);
                $lastMonthData[] = round($h + ($m / 60) + ($s / 3600), 2);
            } else {
                $lastMonthData[] = 0;
            }
        }

        $this->series = [
            ['name' => 'This Month', 'data' => $thisMonthData],
            ['name' => 'Last Month', 'data' => $lastMonthData],
        ];
    }

    public function render()
    {
        return view('livewire.component.widget.table.working-hours-analytics-modal');
    }
}
