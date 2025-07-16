<?php

namespace App\Livewire\Component\Widget\Table;

use App\Models\AttendanceAnalytic;
use App\Models\Employee;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class WorkingHoursAnalytics extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap-without-text'; // Gunakan Bootstrap tanpa text untuk pagination

    public $employeesData = [];
    public $selectedMonth;
    public $months;
    public $perPage = 10;

    public function mount()
    {
        $this->selectedMonth = Carbon::now()->month;

        $this->months = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Aug',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dec',
        ];

        $this->fetchData();
    }

    public function updatedSelectedMonth()
    {
        $this->resetPage(); // Reset pagination saat bulan berubah
        $this->fetchData();
    }

    public function openEmployeeChart($id, $month)
    {
        $this->dispatch('openEmployeeChart', id: $id, month: $month);
    }

    public function fetchData()
    {
        $year = Carbon::now()->year;
        $startThisMonth = Carbon::createFromDate($year, $this->selectedMonth)->startOfMonth();
        $endThisMonth = Carbon::createFromDate($year, $this->selectedMonth)->endOfMonth();
        $startLastMonth = $startThisMonth->copy()->subMonth();
        $endLastMonth = $endThisMonth->copy()->subMonth();

        // Eager load user dan attendance analytic untuk kedua bulan
        $employees = Employee::with('user')->get();

        // Ambil semua data attendance analitik dalam satu query untuk kedua bulan
        $attendanceData = AttendanceAnalytic::whereIn('employee_id', $employees->pluck('id')->toArray())
            ->whereBetween('date', [$startLastMonth, $endThisMonth])  // Ambil data untuk bulan ini dan bulan lalu
            ->get()
            ->groupBy(function ($item) {
                // Group berdasarkan employee_id dan bulan (format Y-m)
                return $item->employee_id . ':' . Carbon::parse($item->date)->format('Y-m');
            });

        $this->employeesData = $employees->map(function ($employee) use ($attendanceData, $startThisMonth, $endThisMonth, $startLastMonth, $endLastMonth) {
            // Ambil data bulan ini dan bulan lalu dari hasil yang sudah dikelompokkan
            $thisMonthData = $attendanceData->get($employee->id . ':' . $startThisMonth->format('Y-m'), collect());
            $lastMonthData = $attendanceData->get($employee->id . ':' . $startLastMonth->format('Y-m'), collect());

            // Jumlahkan working hours per bulan
            $thisMonth = $thisMonthData->sum(function ($record) {
                [$h, $m, $s] = explode(':', $record->working_hourse);
                return round((int) $h + ((int) $m / 60) + ((int) $s / 3600), 2);
            });

            $lastMonth = $lastMonthData->sum(function ($record) {
                [$h, $m, $s] = explode(':', $record->working_hourse);
                return round((int) $h + ((int) $m / 60) + ((int) $s / 3600), 2);
            });

            // Hitung persentase perbandingan
            $percentage = $lastMonth == 0 ? 0 : round((($thisMonth - $lastMonth) / $lastMonth) * 100, 2);

            return [
                'id' => $employee->id,
                'name' => $employee->user->name,
                'this_month' => $thisMonth,
                'last_month' => $lastMonth,
                'percentage' => $percentage,
            ];
        });

        // Sortir berdasarkan name
        $this->employeesData = $this->employeesData->sortBy('name')->values()->all();
        $this->dispatch('refresh-data-working-hours-analytics');
    }



    public function render()
    {
        $page = $this->getPage();
        $perPage = $this->perPage;

        $items = collect($this->employeesData);
        $sliced = $items->slice(($page - 1) * $perPage, $perPage)->values();

        $paginated = new LengthAwarePaginator(
            $sliced,
            $items->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('livewire.component.widget.table.working-hours-analytics', [
            'employees' => $paginated,
        ]);
    }
}
