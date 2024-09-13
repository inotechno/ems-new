<?php

namespace App\Livewire\FinancialRequest;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class FinancialRequestList extends Component
{
    #[Reactive]
    public $financial_requests;

    public function render()
    {
        return view('livewire.financial-request.financial-request-list');
    }
}
