<?php

namespace App\Livewire\LeaveRequest;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class LeaveRequestList extends Component
{
    #[Reactive]
    public $leave_requests;

    public function render()
    {
        return view('livewire.leave-request.leave-request-list');
    }
}
