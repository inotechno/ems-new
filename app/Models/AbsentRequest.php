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
        'date',
        'notes',
        'file_path',
        'file_url',
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
