<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'site_id',
        'supervisor_id',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Employee::class, 'supervisor_id');
    }

    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    public function employees()
    {
        return $this->hasManyThrough(Employee::class, Position::class, 'department_id', 'id', 'id', 'employee_id');
    }
}
