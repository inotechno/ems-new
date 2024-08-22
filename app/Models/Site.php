<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',
        'name',
        'longitude',
        'latitude',
        'image_path',
        'image_url',
        'qrcode_path',
        'qrcode_url',
        'address'
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function attendanceTemps()
    {
        return $this->hasMany(AttendanceTemp::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
}
