<?php

namespace App\Livewire\Component;

use App\Livewire\Visit\VisitCreate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class Map extends Component
{
    use LivewireAlert;

    #[Reactive]
    public $site_name, $site_longitude, $site_latitude, $latitude, $longitude, $distance;

    // public function updatedSiteName()
    // {
    //     $this->dispatch('refresh-map', latitude: $this->latitude, longitude: $this->longitude, site_latitude: $this->site_latitude, site_longitude: $this->site_longitude, site_name: $this->site_name);
    // }

    // #[On('update-distance')]
    // public function updateDistance($distance)
    // {
    //     $this->distance = $distance;
    // }

    // #[On('update-coordinates')]
    // public function updateCoordinates($latitude, $longitude)
    // {
    //     $this->latitude = $latitude;
    //     $this->longitude = $longitude;

    //     $this->alert('success', 'Coordinates updated successfully');
    //     $this->dispatch('coordinate-retrieved', latitude: $this->latitude, longitude: $this->longitude)->to(VisitCreate::class);
    //     $this->dispatch('refresh-map', latitude: $this->latitude, longitude: $this->longitude, site_latitude: $this->site_latitude, site_longitude: $this->site_longitude, site_name: $this->site_name);
    // }

    public function render()
    {
        return view('livewire.component.map');
    }
}
