<?php

namespace App\Console\Commands;

use App\Helpers\HolidayHelper;
use App\Models\Employee;
use App\Jobs\CalculateWorkingHourseJob;
use Carbon\CarbonPeriod;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CalculateWorkingHourse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-working-hourse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate working hourse for each employee from table attendance for yesterday';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $date = Carbon::parse('2025-06-26')->subDays(1)->format('Y-m-d'); // Calculate for yesterday
        // $date = Carbon::now()->subDays(1)->format('Y-m-d'); // Calculate for yesterday

        $datePeriods = CarbonPeriod::create(Carbon::parse('2023-01-01'), Carbon::now()->subDays(1));

        foreach ($datePeriods as $date) {
            if (HolidayHelper::isHoliday($date)) {
                continue;
            }

            $employees = Employee::all();

            foreach ($employees as $employee) {
                CalculateWorkingHourseJob::dispatch($employee->id, $date);
            }
        }

        // $employees = Employee::all();

        // foreach ($employees as $employee) {
        //     CalculateWorkingHourseJob::dispatch($employee->id, $date);
        // }

        \Log::info('Calculate working hourse for each employee');
        \Log::info('Success');
    }
}
