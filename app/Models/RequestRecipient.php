<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestRecipient extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipientable_type',
        'recipientable_id',
        'employee_id',
    ];

    public function recipientable()
    {
        return $this->morphTo();
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
