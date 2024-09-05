<?php

namespace App\Models;

use App\Models\RequestRead;
use App\Models\RequestValidate;
use App\Models\RequestRecipient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class AbsentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'start_date',
        'end_date',
        'notes',
        'file_path',
        'file_url',
        'is_approved',
        'type_absent'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the employee that owns the AbsentRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get all of the recipients for the AbsentRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
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

    /**
     * Get all of the read for the AbsentRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function reads(): MorphMany
    {
        return $this->morphMany(RequestRead::class, 'readable');
    }

    /**
     * Get all of the validates for the AbsentRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function validates(): MorphMany
    {
        return $this->morphMany(RequestValidate::class, 'validatable');
    }

    public function isApprovedByRecipient($employeeId): bool
    {
        return $this->validates()->where('employee_id', $employeeId)->where('status', 'approved')->exists();
    }
}
