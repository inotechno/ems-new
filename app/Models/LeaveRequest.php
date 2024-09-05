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
        'total_days',
        'total_leave_after_request',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function employee(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function recipients(): MorphMany
    {
        return $this->morphMany(RequestRecipient::class, 'recipientable');
    }

    /**
     * Check if the employee with given id is a recipient of this request
     *
     * @param int $employeeId
     * @return bool
     */
    public function hasRecipient($employeeId): bool
    {
        return $this->recipients()->where('employee_id', $employeeId)->exists();
    }

    public function reads(): MorphMany
    {
        return $this->morphMany(RequestRead::class, 'readable');
    }

    public function validates(): MorphMany
    {
        return $this->morphMany(RequestValidate::class, 'validatable');
    }

    public function isApprovedByRecipient($employeeId): bool
    {
        return $this->validates()->where('employee_id', $employeeId)->where('status', 'approved')->exists();
    }
}
