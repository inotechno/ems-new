<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'employee_id', 'code', 'description', 'start_date', 'end_date', 'status'];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'projects_employees', 'project_id', 'employee_id');
    }

    public function projectManager()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
