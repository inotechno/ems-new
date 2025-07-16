<?php

namespace App\Livewire\Visit;

use App\Models\Site;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use App\Models\VisitCategory;
use App\Livewire\BaseComponent;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class VisitCreate extends BaseComponent
{
    use LivewireAlert;

    public $employee_id, $site_id, $visit_category_id, $notes, $distance, $longitude, $latitude, $file_path, $file_url, $image, $content;
    public $visit_categories;
    public $site_name, $site_longitude, $site_latitude;
    public $isScanError = false;
    public $activeCamera = 'qr';

    protected $rules = [
        'employee_id' => 'required',
        'site_id' => 'required',
        'visit_category_id' => 'required',
        'notes' => 'required|max:255',
        'longitude' => 'required',
        'latitude' => 'required',
        'image' => 'required',
    ];

    public function mount()
    {
        $this->visit_categories = VisitCategory::all();
        $this->employee_id = $this->authUser->employee->id;

        $site = \App\Models\Site::first();
        $this->site_name = $site->name;
        $this->site_longitude = $site->longitude;
        $this->site_latitude = $site->latitude;
    }

    #[On('qr-code-scanned')]
    public function qrCodeScanned($content)
    {
        try {
            $this->content = $content;

            $site = \App\Models\Site::where('uid', $content)->first();

            $this->site_id = $site->id;
            $this->site_name = $site->name;
            $this->site_latitude = $site->latitude;
            $this->site_longitude = $site->longitude;

            $this->alert('info', 'QR Code Scanned', [
                'position' => 'center',
                'showCancelButton' => true,
                'cancelButtonText' => 'Close',
                'toast' => false,
                'timer' => null,
                'html' => '<h3><strong>' . $site->name . '</strong></h3>' .
                    '<h4><strong>' . $site->longitude . ', ' . $site->latitude . '</strong></h4>',
            ]);

            $this->dispatch('refresh-map', latitude: $this->latitude, longitude: $this->longitude, site_latitude: $this->site_latitude, site_longitude: $this->site_longitude, site_name: $this->site_name);
        } catch (\Throwable $th) {
            $this->alert('error', 'Invalid QR Code');
            $this->content = null;
            $this->isScanError = true;
        }
    }

    #[On('update-distance')]
    public function updateDistance($distance)
    {
        $this->distance = $distance;
    }

    #[On('update-coordinates')]
    public function updateCoordinates($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;

        $this->alert('success', 'Coordinates updated successfully');
        $this->dispatch('refresh-map', latitude: $this->latitude, longitude: $this->longitude, site_latitude: $this->site_latitude, site_longitude: $this->site_longitude, site_name: $this->site_name);
    }

    #[On('image-captured')]
    public function imageCaptured($url)
    {
        $this->image = $url;
        if ($this->image) {
            $this->alert('success', 'Image captured successfully');
        }
    }

    public function resetSite()
    {
        $this->site_name = null;
        $this->site_longitude = null;
        $this->site_latitude = null;
        $this->site_id = null;
    }

    public function submit()
    {
        try {
            $this->validate();
            $uid = Str::uuid();

            if ($this->image) {
                $imageData = $this->convertDataUrlToImage($this->image);
                // Store avatar in GCS using Laravel Storage
                $disk = Storage::disk('gcs');
                // Create ImageManager instance with GD driver
                $manager = new ImageManager(new Driver());

                // Read image from file system
                $image = $manager->read($imageData);

                // Resize image to create thumbnail
                $image->scale(250, 250); // Resize to fit thumbnail dimensions

                // Save the thumbnail to GCS
                $this->file_path = 'images/' . $uid . '.png';
                $disk->put($this->file_path, (string) $image->toPng());

                // Get the URL of the thumbnail
                $this->file_url = $disk->url($this->file_path);
            }

            $this->visit = \App\Models\Visit::create([
                'employee_id' => $this->employee_id,
                'site_id' => $this->site_id,
                'visit_category_id' => $this->visit_category_id,
                'notes' => $this->notes,
                'longitude' => $this->longitude,
                'latitude' => $this->latitude,
                'file_path' => $this->file_path,
                'file_url' => $this->file_url,
                'distance' => $this->distance,
                'is_approved' => 1,
            ]);

            activity()
                ->causedBy($this->authUser) // Pengguna yang melakukan login
                ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
                ->event('create')
                ->log("{$this->authUser->name} telah membuat visit");

            $this->alert('success', 'Visit created successfully');

            $this->reset();
            return redirect()->route('visit.index');
        } catch (\Throwable $th) {
            $this->alert('error', $th->getMessage());
        }
    }

    private function convertDataUrlToImage($dataUrl)
    {
        $image_parts = explode(";base64,", $dataUrl);
        $image_base64 = base64_decode($image_parts[1]);

        return $image_base64;
    }

    public function activateQRScanner()
    {
        $this->dispatch('selfie-camera-stop')->to('component.camera');
        $this->dispatch('qr-scanner-start')->to('component.qr-camera');
        $this->activeCamera = 'qr';
    }


    public function activateSelfieCamera()
    {
        $this->dispatch('qr-scanner-stop')->to('component.qr-camera');
        $this->dispatch('selfie-camera-start')->to('component.camera');
        $this->activeCamera = 'selfie';
    }

    public function render()
    {
        return view('livewire.visit.visit-create')->layout('layouts.app', ['title' => 'Create Visit']);
    }
}
