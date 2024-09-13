<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'subject',
        'body',
    ];

    public function category()
    {
        return $this->belongsTo(CategoryEmailTemplate::class, 'category_id');
    }

}
