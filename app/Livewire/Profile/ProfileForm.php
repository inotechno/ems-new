<?php

namespace App\Livewire\Profile;

use App\Livewire\BaseComponent;
use App\Models\Employee;
use Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Intervention\Image\Drivers\Gd\Driver;

class ProfileForm extends BaseComponent
{
    use LivewireAlert, WithFileUploads;
    public $employee;

    public $name,
    $username,
    $email,
    $password,
    $citizen_id,
    $leave_remaining,
    $join_date,
    $birth_date,
    $place_of_birth,
    $gender,
    $marital_status,
    $old_password, $new_password, $confirm_password, $password_string,
    $religion,
    $avatar,
    $previewAvatar = "https://cdn.vectorstock.com/i/500p/65/30/default-image-icon-missing-picture-page-vector-40546530.jpg",
    $avatar_url,
    $avatar_path;

    public $user;

    public function mount($id = null)
    {
        if ($id) {
            $this->employee = Employee::find($id);
            $this->user = $this->employee->user;
            $this->name = $this->user->name;
            $this->username = $this->user->username;
            $this->email = $this->user->email;
            $this->citizen_id = $this->employee->citizen_id;
            $this->leave_remaining = $this->employee->leave_remaining;
            $this->join_date = $this->employee->join_date;
            $this->birth_date = $this->employee->birth_date;
            $this->place_of_birth = $this->employee->place_of_birth;
            $this->gender = $this->employee->gender;
            $this->marital_status = $this->employee->marital_status;
            $this->religion = $this->employee->religion;
            $this->avatar_url = $this->employee->user->avatar_url;
            $this->avatar_path = $this->employee->user->avatar_path;

            // dd($this->avatar_url);
            $this->dispatch('change-select-form');
        }

        $this->authorize('view', $this->employee);
    }

    public function save()
    {
        try {
            $this->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username,' . ($this->user->id ?? 'NULL'),
                'email' => 'required|email|max:255|unique:users,email,' . ($this->user->id ?? 'NULL'),
                'citizen_id' => 'required|string|max:255',
                'join_date' => 'nullable|date',
                'birth_date' => 'nullable|date',
                'place_of_birth' => 'nullable|string|max:255',
                'gender' => 'nullable|in:male,female',
                'marital_status' => 'nullable|string|max:255',
                'religion' => 'nullable|string|max:255',
                'avatar' => 'nullable|image|max:2048',
            ]);

            if ($this->new_password || $this->confirm_password || $this->old_password) {
                $this->validate([
                    'old_password' => 'required',
                    'new_password' => 'required|min:8',
                    'confirm_password' => 'required|same:new_password',
                ]);

                // Cek apakah password lama sesuai
                if (!Hash::check($this->old_password, $this->user->password)) {
                    $this->alert('error', 'Old password is incorrect.');
                    return;
                }

                // Jika password lama sesuai, update password

                $this->user->password_string = $this->new_password;
                $this->user->password = Hash::make($this->new_password);
            }

            $uid = (string) Str::uuid();
            $avatarPath = null;
            $avatarUrl = null;
            $thumbnailPath = null;
            $thumbnailUrl = null;

            if ($this->avatar) {
                // Generate nama file random menggunakan UUID
                $imageName = $uid . '.' . $this->avatar->getClientOriginalExtension();
                // Store avatar in GCS using Laravel Storage
                $disk = Storage::disk('gcs');
                $avatarPath = $disk->putFileAs('avatars', $this->avatar, $imageName);

                // Get the full public URL of the uploaded image
                $avatarUrl = $disk->url($avatarPath);

                $manager = new ImageManager(new Driver());

                // Buat thumbnail
                $thumbnailImage = $manager->read($this->avatar->getRealPath())
                    ->scale(150, 150); // ukuran thumbnail

                // Simpan thumbnail ke GCS
                $thumbnailPath = 'avatars/thumbnails/' . $imageName;
                $disk->put($thumbnailPath, (string) $thumbnailImage->toPng());

                // URL untuk thumbnail
                $thumbnailUrl = $disk->url($thumbnailPath);

                if ($this->avatar_path) {
                    $disk->delete($this->avatar_path);
                }
            }

            $this->user->update([
                'username' => $this->username,
                'name' => $this->name,
                'email' => $this->email,
                'password_string' => $this->user->password_string,
                'password' => $this->user->password,
                'avatar_path' => $avatarPath,
                'avatar_url' => $avatarUrl,
                'avatar_thumbnail_path' => $thumbnailPath,
                'avatar_thumbnail_url' => $thumbnailUrl,
            ]);

            $this->employee->update([
                'citizen_id' => $this->citizen_id,
                'join_date' => $this->join_date,
                'birth_date' => $this->birth_date,
                'place_of_birth' => $this->place_of_birth,
                'gender' => $this->gender,
                'marital_status' => $this->marital_status,
                'religion' => $this->religion,
                'leave_remaining' => $this->leave_remaining,
            ]);

            activity()
                ->causedBy($this->authUser) // Pengguna yang melakukan login
                ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
                ->event('update')
                ->log("{$this->authUser->name} telah mengupdate profile");

            $this->alert('success', 'Update Profile successfully');
            return redirect()->route('profile.index');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    #[On('changeSelectForm')]
    public function changeSelectForm($param, $value)
    {
        $this->$param = $value;
    }

    public function render()
    {
        return view('livewire.profile.profile-form')->layout('layouts.app', ['title' => 'Profile']);
    }
}
