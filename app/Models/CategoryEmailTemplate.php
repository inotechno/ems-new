<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryEmailTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'description'
    ];

    public function template()
    {
        return $this->hasOne(EmailTemplate::class, 'category_id', 'id');
    }
}
