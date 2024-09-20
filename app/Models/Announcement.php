<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
    ];

    public function recipients()
    {
        return $this->belongsToMany(User::class, 'announcements_recipients')->withTimestamps();
    }

    public function reads()
    {
        return $this->belongsToMany(User::class, 'announcements_reads')->withTimestamps();
    }
}
