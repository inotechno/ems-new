<?php

namespace App\Livewire\Attendance;

use Livewire\Component;

class AttendanceIndex extends Component
{
    public function render()
    {
        return view('livewire.attendance.attendance-index')->layout('layouts.app', ['title' => 'Attendance List']);
    }
}
