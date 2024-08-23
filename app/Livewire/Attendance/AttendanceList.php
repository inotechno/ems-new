<?php

namespace App\Livewire\Attendance;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class AttendanceList extends Component
{
    #[Reactive]
    public $attendances;

    public function render()
    {
        return view('livewire.attendance.attendance-list');
    }
}
