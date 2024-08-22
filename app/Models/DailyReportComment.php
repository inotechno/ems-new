<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyReportComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'daily_report_id',
        'comment',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dailyReport()
    {
        return $this->belongsTo(DailyReport::class);
    }
}
