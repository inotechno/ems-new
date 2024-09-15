<?php

namespace App\Livewire\Component;

use App\Livewire\Visit\VisitCreate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class QRCamera extends Component
{
    use LivewireAlert;
    public $content;
    public $isScanError = false;

    public function retryScan()
    {
        $this->isScanError = false;
        $this->dispatch('initQRScanner');
    }

    public function render()
    {
        return view('livewire.component.qr-camera');
    }
}
