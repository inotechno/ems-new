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
        'amount',
        'title',
        'notes',
        'receipt_image_path',
        'receipt_image_url',
        'is_approved',
    ];

    /**
     * Get the financialType that owns the FinancialRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function financialType(): BelongsTo
    {
        return $this->belongsTo(Helper::class, 'financial_type_id', 'id');
    }

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
