<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'type',
        'description',
        'is_read',
        'url',
        'icon',
        'color',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
