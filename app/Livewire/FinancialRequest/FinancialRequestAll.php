<?php

namespace App\Livewire\FinancialRequest;

use Livewire\Component;

class FinancialRequestAll extends Component
{


    public function render()
    {
        return view('livewire.financial-request.financial-request-all')->layout('layouts.app', ['title' => 'Financial Request']);
    }
}
