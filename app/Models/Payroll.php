<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'payroll_period_id',
        'basic_salary',
        'allowance_pulsa',
        'allowance_position',
        'allowance_transport',
        'allowance_meal',
        'allowance_others',
        'deduction_pph21',
        'deduction_bpjs_tk',
        'deduction_bpjs_kesehatan',
        'deduction_pension',
        'deduction_loan',
        'deduction_late',
        'deduction_daily_report',
        'total_allowance',
        'total_deduction',
        'net_salary',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function payrollPeriod()
    {
        return $this->belongsTo(PayrollPeriod::class);
    }
}
