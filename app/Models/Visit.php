<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'site_id',
        'visit_category_id',
        'longitude',
        'latitude',
        'distance',
        'notes',
        'file_path',
        'file_url',
        'is_approved',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function visitCategory()
    {
        return $this->belongsTo(VisitCategory::class);
    }

}
