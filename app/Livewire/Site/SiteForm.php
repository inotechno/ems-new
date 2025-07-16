<?php

namespace App\Livewire\Site;

use App\Livewire\BaseComponent;
use App\Models\Site;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use App\Jobs\GenerateQRCode;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class SiteForm extends BaseComponent
{
    use LivewireAlert, WithFileUploads;

    public $site, $uid, $name, $longitude, $latitude, $image_path, $image_url, $qrcode_path, $qrcode_url, $address, $image;
    public $previewImage = 'https://cdn.vectorstock.com/i/500p/65/30/default-image-icon-missing-picture-page-vector-40546530.jpg';
    public $type = 'create';
    public $title;
    public $saveMode = 'save';

    public function mount($uid = null)
    {
        $this->title = ucfirst($this->type) . ' Site';

        if ($uid != null) {
            $this->site = Site::where('uid', $uid)->first();
            $this->uid = $this->site->uid;
            $this->name = $this->site->name;
            $this->longitude = $this->site->longitude;
            $this->latitude = $this->site->latitude;
            $this->image_path = $this->site->image_path;
            $this->image_url = $this->site->image_url;
            $this->qrcode_path = $this->site->qrcode_path;
            $this->qrcode_url = $this->site->qrcode_url;
            $this->address = $this->site->address;
            $this->previewImage = $this->site->image_url;

            $this->type = 'edit';
            $this->title = 'Edit ' . $this->name;
        }
    }

    #[On('update-coordinates')]
    public function updateCoordinates($lat, $lng)
    {
        $this->latitude = $lat;
        $this->longitude = $lng;

        $this->dispatch('refresh-map');
    }

    #[On('update-address')]
    public function updateAddress($address)
    {
        // dd($address);
        $this->address = $address;
    }

    public function save()
    {
        // dd($this);
        $this->validate([
            'name' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($this->type == 'create') {
            $this->store();
        } else if ($this->type == 'edit') {
            $this->update();
        }
    }

    public function update()
    {
        try {
            $imagePath = null;
            $imageUrl = null;

            if ($this->image) {
                // Generate nama file random menggunakan UUID
                $imageName = $this->uid . '.' . $this->image->getClientOriginalExtension();

                // Store image in GCS using Laravel Storage
                $disk = Storage::disk('gcs');
                $imagePath = $disk->putFileAs('sites', $this->image, $imageName);

                // Get the full public URL of the uploaded image
                $imageUrl = $disk->url($imagePath);
            } else {
                $imagePath = $this->image_path;
                $imageUrl = $this->image_url;
            }

            $this->site->update([
                'name' => $this->name,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'address' => $this->address,
                'image_path' => $imagePath,
                'image_url' => $imageUrl,
            ]);

            activity()
                ->causedBy($this->authUser)
                ->withProperties(['uid' => $this->uid])
                ->event('update')
                ->log("Site updated successfully with UID: {$this->uid}, name: {$this->name}");

            $this->reset();
            $this->alert('success', 'Site updated successfully');

            return redirect(route('site.index'));
        } catch (\Exception $e) {
            $this->alert('error', 'Failed to update site: ' . $e->getMessage());
        }
    }

    public function store()
    {
        try {
            $this->uid = (string) Str::uuid();
            $imagePath = null;
            $imageUrl = null;

            if ($this->image) {
                // Generate nama file random menggunakan UUID
                $imageName = $this->uid . '.' . $this->image->getClientOriginalExtension();

                // Store image in GCS using Laravel Storage
                $disk = Storage::disk('gcs');
                $imagePath = $disk->putFileAs('sites', $this->image, $imageName);

                // Get the full public URL of the uploaded image
                $imageUrl = $disk->url($imagePath);
            }

            // Simpan data site ke database (misalnya)
            Site::create([
                'uid' => $this->uid,
                'name' => $this->name,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'image_path' => $imagePath,
                'image_url' => $imageUrl,
                'address' => $this->address,
            ]);

            // Generate QR Code
            GenerateQRCode::dispatch($this->uid);

            activity()
                ->causedBy(auth()->user())
                ->withProperties(['uid' => $this->uid])
                ->event('create')
                ->log("Site created successfully with UID: {$this->uid}, name: {$this->name}");

            if ($this->saveMode == 'save') {
                $this->alert('success', 'Site added successfully');
                return redirect(route('site.index'));
            } else if ($this->saveMode == 'save_add') {
                $this->reset();
                $this->alert('success', 'Site added successfully, please add another site');
            }
        } catch (\Exception $e) {
            // Menampilkan pesan error jika terjadi kesalahan
            $this->alert('error', 'Failed to add site: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.site.site-form')->layout('layouts.app', ['title' => $this->title]);
    }
}
