<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'start_date',
        'end_date',
        'current_total_leave',
        'notes',
        'total_leave_after_request',
        'is_approved',
    ];

    public function recipients(): MorphMany
    {
        return $this->morphMany(RequestRecipient::class, 'recipientable');
    }

    public function reads(): MorphMany
    {
        return $this->morphMany(RequestRead::class, 'readable');
    }

    public function validates(): MorphMany
    {
        return $this->morphMany(RequestValidate::class, 'validatable');
    }
}
