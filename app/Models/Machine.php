<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ip_address',
        'port',
        'comkey',
        'is_active',
        'password',
        'machine_type_id',
        'site_id',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function machineType()
    {
        return $this->belongsTo(Helper::class, 'machine_type_id', 'id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function attendanceTemps()
    {
        return $this->hasMany(AttendanceTemp::class);
    }

    public function logs()
    {
        return $this->hasMany(MachineLog::class);
    }
}
