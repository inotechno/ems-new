<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class FinancialRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'financial_type_id',
        'amount',
        'title',
        'notes',
        'receipt_image_path',
        'receipt_image_url',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'receipt_image_path' => 'string',
        'receipt_image_url' => 'string',
        'amount' => 'integer',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the financialType that owns the FinancialRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function financialType()
    {
        return $this->belongsTo(Helper::class, 'financial_type_id', 'id');
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

    public function checkAndUpdateApprovalStatus()
    {
        // Jumlah recipients terkait dengan AbsentRequest ini
        $totalRecipients = $this->recipients()->count();

        // Jumlah recipients yang sudah approve
        $approvedRecipients = $this->validates()->where('status', 'approved')->count();

        // Jika jumlah recipients yang sudah approve sama dengan total recipients, maka isApproved menjadi true
        $isApproved = $totalRecipients > 0 && $approvedRecipients === $totalRecipients;

        // Perbarui status isApproved pada AbsentRequest
        $this->update(['is_approved' => $isApproved]);
    }

    public function isRejectedByRecipients(): bool
    {
        $totalRecipients = $this->recipients()->count();
        $rejectedRecipients = $this->validates()->where('status', 'rejected')->count();
        return $totalRecipients > 0 && $rejectedRecipients === $totalRecipients;
    }
}
