<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyReportRead extends Model
{
    use HasFactory;

    protected $fillable = [
        'daily_report_id',
        'employee_id',
    ];

    public function dailyReport()
    {
        return $this->belongsTo(DailyReport::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
