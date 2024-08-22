<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
}
