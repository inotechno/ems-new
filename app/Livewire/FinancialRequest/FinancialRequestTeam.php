<?php

namespace App\Livewire\FinancialRequest;

use Livewire\Component;

class FinancialRequestTeam extends Component
{

    public function render()
    {
        return view('livewire.financial-request.financial-request-team')->layout('layouts.app', ['title' => 'Financial Request Team']);
    }
}
