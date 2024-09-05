<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestValidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'validatable_id',
        'validatable_type',
        'employee_id',
        'status',
    ];

    public function validatable()
    {
        return $this->morphTo();
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
