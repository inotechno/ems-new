<?php

namespace App\Livewire\Setting;

use App\Livewire\BaseComponent;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Storage;
use Illuminate\Support\Str;

class SettingForm extends BaseComponent
{
    use WithFileUploads, LivewireAlert;

    public $settings = [];
    public $uploaded_app_logo_full_dark;
    public $uploaded_app_logo_full_light;
    public $uploaded_app_logo_small_dark;
    public $uploaded_app_logo_small_light;

    public function mount()
    {
        // Mengambil pengaturan dari database
        $settingsFromDB = Setting::all();

        // Mengisi pengaturan ke dalam array
        foreach ($settingsFromDB as $setting) {
            $this->settings[$setting->key] = $setting->value;
        }
    }

    public function save()
    {
        // dd($this);
        // Validasi pengaturan
        $this->validate([
            'settings.app_title' => 'required|string|max:255',
            'settings.app_name' => 'required|string|max:255',
            'settings.app_description' => 'required|string|max:1000',
            'settings.app_version' => 'required|regex:/^\d+\.\d+\.\d+$/',
            'settings.app_author' => 'required|string|max:255',
            'settings.app_author_url' => 'required|url',
            'settings.app_license' => 'required|string|max:255',
            'settings.app_license_url' => 'required|url',
            'settings.app_copyright' => 'required|string|max:255',
            'settings.app_currency' => 'required|string|max:3',
            'settings.app_currency_symbol' => 'required|string|max:5',
            'settings.contact_email' => 'required|email|max:255',
            'settings.contact_phone' => 'required|string|max:15',
            'settings.contact_address' => 'required|string|max:255',
            'settings.contact_city' => 'required|string|max:255',
            'settings.contact_country' => 'required|string|max:255',
            'settings.contact_zip' => 'required|string|max:10',
            'settings.contact_map' => 'required|url',
            'uploaded_app_logo_full_dark' => 'nullable|image|max:1024', // 1MB max
            'uploaded_app_logo_full_light' => 'nullable|image|max:1024',
            'uploaded_app_logo_small_dark' => 'nullable|image|max:512', // 512KB max
            'uploaded_app_logo_small_light' => 'nullable|image|max:512',
        ], [
            'settings.app_title.required' => 'The application title is required.',
            'settings.app_name.required' => 'The application name is required.',
            'settings.app_description.required' => 'The application description is required.',
            'settings.app_version.required' => 'The application version is required.',
            'settings.app_version.regex' => 'The application version must be in the format X.X.X (e.g., 1.0.0).',
            'settings.app_author.required' => 'The author name is required.',
            'settings.app_author_url.required' => 'The author URL is required.',
            'settings.app_license.required' => 'The application license is required.',
            'settings.app_license_url.required' => 'The license URL is required.',
            'settings.app_copyright.required' => 'Copyright information is required.',
            'settings.app_currency.required' => 'The currency is required.',
            'settings.app_currency_symbol.required' => 'The currency symbol is required.',
            'settings.contact_email.required' => 'The contact email is required.',
            'settings.contact_email.email' => 'The email format is invalid.',
            'settings.contact_phone.required' => 'The contact phone number is required.',
            'settings.contact_address.required' => 'The contact address is required.',
            'settings.contact_city.required' => 'The contact city is required.',
            'settings.contact_country.required' => 'The contact country is required.',
            'settings.contact_zip.required' => 'The zip code is required.',
            'settings.contact_map.required' => 'The map URL is required.',
            'uploaded_app_logo_full_dark.image' => 'The logo must be an image.',
            'uploaded_app_logo_full_dark.max' => 'The logo must not exceed 1MB.',
            'uploaded_app_logo_full_light.image' => 'The logo must be an image.',
            'uploaded_app_logo_full_light.max' => 'The logo must not exceed 1MB.',
            'uploaded_app_logo_small_dark.image' => 'The logo must be an image.',
            'uploaded_app_logo_small_dark.max' => 'The logo must not exceed 512KB.',
            'uploaded_app_logo_small_light.image' => 'The logo must be an image.',
            'uploaded_app_logo_small_light.max' => 'The logo must not exceed 512KB.',
        ]);

        $uid = Str::uuid();
        $disk = Storage::disk('gcs');

        // Helper function to handle file upload and removal
        $this->handleFileUpload('uploaded_app_logo_full_dark', 'app_logo_full_dark', 1024);
        $this->handleFileUpload('uploaded_app_logo_full_light', 'app_logo_full_light', 1024);
        $this->handleFileUpload('uploaded_app_logo_small_dark', 'app_logo_small_dark', 512);
        $this->handleFileUpload('uploaded_app_logo_small_light', 'app_logo_small_light', 512);

        try {
            // Simpan pengaturan ke database
            foreach ($this->settings as $key => $value) {
                Setting::set($key, $value);
            }

            // Hapus cache global agar pengaturan diperbarui
            Cache::forget('settings');
            $this->alert('success', 'Setting saved successfully!');

            activity()
                ->causedBy($this->authUser) // Pengguna yang melakukan login
                ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
                ->event('update')
                ->log("{$this->authUser->name} telah mengubah setting");

            return redirect()->route('setting.edit');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
            return;
        }
    }

    /**
     * Handle file upload and old file deletion.
     *
     * @param string $uploadField Name of the uploaded field.
     * @param string $settingKey Key for the setting to store the file URL.
     * @param int $maxSize Maximum size of the file in kilobytes.
     */
    private function handleFileUpload($uploadField, $settingKey, $maxSize)
    {
        if ($this->$uploadField) {
            $disk = Storage::disk('gcs');
            $uid = Str::uuid();

            // Hapus file lama dari GCS
            if ($this->settings[$settingKey]) {
                $oldFileName = basename($this->settings[$settingKey]);
                $disk->delete('images/' . $oldFileName);
            }

            // Simpan file baru
            $imageName = $uid . '.' . $this->$uploadField->getClientOriginalExtension();
            $path = $disk->putFileAs('images', $this->$uploadField, $imageName);

            // Update setting dengan URL file baru
            $this->settings[$settingKey] = $disk->url($path);
        }
    }

    public function render()
    {
        return view('livewire.setting.setting-form')->layout('layouts.app', ['title' => 'Setting']);
    }
}
