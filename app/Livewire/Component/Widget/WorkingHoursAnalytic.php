<?php

namespace App\Livewire\Component\Widget;

use App\Livewire\BaseComponent;
use App\Models\AttendanceAnalytic;
use Illuminate\Support\Carbon;

class WorkingHoursAnalytic extends BaseComponent
{
    public $start_date;
    public $end_date;

    public $start_date_last_month;
    public $end_date_last_month;

    public $series, $labels;
    public $this_month, $last_month;
    public $percentage_based_on_last_month;
    public $months;
    public $selectedMonth;
    public $chartId;
    public $chartKey = 0;
    public $user;

    public function mount($user)
    {
        $this->user = $user;
        $this->chartId = 'chart-' . $this->selectedMonth;
        $this->chartKey++;
        $this->selectedMonth = Carbon::now()->month;
        $this->months = [
            '1' => 'Jan',
            '2' => 'Feb',
            '3' => 'Mar',
            '4' => 'Apr',
            '5' => 'May',
            '6' => 'Jun',
            '7' => 'Jul',
            '8' => 'Aug',
            '9' => 'Sep',
            '10' => 'Oct',
            '11' => 'Nov',
            '12' => 'Dec',
        ];

        $this->start_date = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->end_date = Carbon::now()->endOfMonth()->format('Y-m-d');

        $this->getData();
    }

    public function updatedSelectedMonth()
    {
        $year = Carbon::now()->year;

        // Misal selectedMonth = 1 (Januari), maka set awal dan akhir bulan
        $this->start_date = Carbon::createFromDate($year, $this->selectedMonth, 1)->startOfMonth()->format('Y-m-d');
        $this->end_date = Carbon::createFromDate($year, $this->selectedMonth, 1)->endOfMonth()->format('Y-m-d');
        $this->getData();

        $this->chartId = 'chart-' . $this->selectedMonth;
        $this->chartKey++;
        $this->dispatch('refresh-chart', series: $this->series, labels: $this->labels);
    }

    public function getData()
    {
        // Reset array agar tidak numpuk saat bulan berubah
        $this->labels = [];
        $this->this_month = [];
        $this->last_month = [];
        $this->series = [];

        $employeeId = $this->user->employee->id;

        $attendance_analytics = AttendanceAnalytic::where('employee_id', $employeeId)
            ->whereBetween('date', [$this->start_date, $this->end_date])
            ->orderBy('date', 'asc')
            ->get();

        $attendance_analytic_last_month = AttendanceAnalytic::where('employee_id', $employeeId)
            ->whereBetween('date', [
                Carbon::parse($this->start_date)->subMonth(),
                Carbon::parse($this->end_date)->subMonth()
            ])
            ->orderBy('date', 'asc')
            ->get();

        // Loop data bulan ini
        foreach ($attendance_analytics as $record) {
            [$h, $m, $s] = explode(':', $record->working_hourse);
            $decimal = round((int) $h + ((int) $m / 60) + ((int) $s / 3600), 2);

            $this->labels[] = Carbon::parse($record->date)->format('d M');
            $this->this_month[] = $decimal;
        }

        // Loop data bulan lalu
        foreach ($attendance_analytic_last_month as $record) {
            [$h, $m, $s] = explode(':', $record->working_hourse);
            $decimal = round((int) $h + ((int) $m / 60) + ((int) $s / 3600), 2);

            $this->last_month[] = $decimal;
        }

        // Data untuk chart
        $this->series = [
            [
                'name' => 'Working Hours',
                'data' => $this->this_month,
            ]
        ];

        // Hitung presentase dibanding bulan lalu
        $last = collect($this->last_month)->sum();
        $now = collect($this->this_month)->sum();

        $this->percentage_based_on_last_month = $last == 0 ? 0 : round((($now - $last) / $last) * 100, 2);

        // Label periode
        $this->start_date_last_month = Carbon::parse($this->start_date)->subMonth()->format('Y-m-d');
        $this->end_date_last_month = Carbon::parse($this->end_date)->subMonth()->format('Y-m-d');
    }
    public function render()
    {
        return view('livewire.component.widget.working-hours-analytic', [
            'chartKey' => $this->chartKey,
        ]);
    }
}
