<?php

namespace App\Livewire\AttendanceTemp;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class AttendanceTempList extends Component
{
    #[Reactive]
    public $attendances;

    public function render()
    {
        return view('livewire.attendance-temp.attendance-temp-list');
    }
}
