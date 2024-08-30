<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'date',
        'day',
        'description',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function getShortDescriptionAttribute()
    {
        return substr($this->description, 0, 50); // Sesuaikan panjang deskripsi singkat yang diinginkan
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function dailyReportRecipients()
    {
        return $this->hasMany(DailyReportRecipient::class);
    }

    public function dailyReportReads()
    {
        return $this->hasMany(DailyReportRead::class);
    }

    public function dailyReportComments()
    {
        return $this->hasMany(DailyReportComment::class);
    }

}
