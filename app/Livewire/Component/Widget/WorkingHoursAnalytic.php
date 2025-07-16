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

        // Ambil data employee_id
        $employeeId = $this->user->employee->id;

        // Tentukan start dan end tanggal untuk bulan ini dan bulan lalu
        $year = now()->year;
        $startThisMonth = Carbon::create($year, $this->selectedMonth)->startOfMonth();
        $endThisMonth = Carbon::create($year, $this->selectedMonth)->endOfMonth();

        $startLastMonth = $startThisMonth->copy()->subMonth();
        $endLastMonth = $endThisMonth->copy()->subMonth();

        // Ambil data attendance untuk bulan ini dan bulan lalu
        $thisMonthAnalytics = AttendanceAnalytic::where('employee_id', $employeeId)
            ->whereBetween('date', [$startThisMonth, $endThisMonth])
            ->get()
            ->keyBy(fn($r) => Carbon::parse($r->date)->day); // key by day

        $lastMonthAnalytics = AttendanceAnalytic::where('employee_id', $employeeId)
            ->whereBetween('date', [$startLastMonth, $endLastMonth])
            ->get()
            ->keyBy(fn($r) => Carbon::parse($r->date)->day); // key by day

        // Loop untuk mengambil data berdasarkan tanggal dari 1 sampai dengan jumlah hari terbanyak antara dua bulan
        $maxDays = max($startThisMonth->daysInMonth, $startLastMonth->daysInMonth);

        for ($i = 1; $i <= $maxDays; $i++) {
            $this->labels[] = str_pad($i, 2, '0', STR_PAD_LEFT); // Tanggal 1, 2, 3, dst.

            // Data bulan ini
            if ($thisMonthAnalytics->has($i)) {
                [$h, $m, $s] = explode(':', $thisMonthAnalytics[$i]->working_hourse);
                $thisMonthData = round($h + ($m / 60) + ($s / 3600), 2);
            } else {
                $thisMonthData = 0;
            }
            $this->this_month[] = $thisMonthData;

            // Data bulan lalu
            if ($lastMonthAnalytics->has($i)) {
                [$h, $m, $s] = explode(':', $lastMonthAnalytics[$i]->working_hourse);
                $lastMonthData = round($h + ($m / 60) + ($s / 3600), 2);
            } else {
                $lastMonthData = 0;
            }
            $this->last_month[] = $lastMonthData;
        }

        // Menyusun data untuk chart
        $this->series = [
            ['name' => 'This Month', 'data' => $this->this_month],
            ['name' => 'Last Month', 'data' => $this->last_month],
        ];

        // Hitung persentase perbandingan bulan ini dengan bulan lalu
        $last = collect($this->last_month)->sum();
        $now = collect($this->this_month)->sum();
        $this->percentage_based_on_last_month = $last == 0 ? 0 : round((($now - $last) / $last) * 100, 2);

        // Tentukan label periode untuk bulan ini dan bulan lalu
        $this->start_date_last_month = $startLastMonth->format('Y-m-d');
        $this->end_date_last_month = $endLastMonth->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.component.widget.working-hours-analytic', [
            'chartKey' => $this->chartKey,
        ]);
    }
}
