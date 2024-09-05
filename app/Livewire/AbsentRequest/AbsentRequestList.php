<?php

namespace App\Livewire\AbsentRequest;

use App\Models\AbsentRequest;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class AbsentRequestList extends Component
{
    #[Reactive('absent_requests')]
    public $absent_requests;

    public function render()
    {
        return view('livewire.absent-request.absent-request-list');
    }
}
