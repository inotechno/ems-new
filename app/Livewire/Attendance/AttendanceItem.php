<?php

namespace App\Livewire\Attendance;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class AttendanceItem extends Component
{
    #[Reactive]
    public $attendance;
    public $employee;
    public $checkIn;
    public $checkOut;
    public $duration;
    public $duration_string;
    public $badge_color;

    public function mount()
    {
        $this->employee = $this->attendance['employee'];
        $this->checkIn = $this->attendance['check_in'];
        $this->checkOut = $this->attendance['check_out'];
        $this->duration_string = $this->attendance['duration_string'];
        $this->duration = $this->attendance['duration'];
        $this->badge_color = $this->statusDuration();
    }

    public function statusDuration()
    {
        if ($this->duration < 8.00) {
            return 'badge-soft-danger';
        } else {
            return 'badge-soft-success';
        }
    }

    public function render()
    {
        return view('livewire.attendance.attendance-item');
    }
}
