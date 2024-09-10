<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Helper extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'value'
    ];

    /**
     * Get all of the financialRequests for the Helper
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function financialRequests(): HasMany
    {
        return $this->hasMany(FinancialRequest::class, 'financial_type_id', 'id');
    }
}
