<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineLog extends Model
{
    use HasFactory;

    protected $table = 'machine_logs';

    protected $fillable = [
        'machine_id',
        'log',
    ];

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }
}
