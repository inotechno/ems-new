<?php

namespace App\Livewire\Employee;

use App\Livewire\BaseComponent;
use Hash;
use App\Models\User;
use Livewire\Component;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EmployeeForm extends BaseComponent
{
    use LivewireAlert, WithFileUploads;
    public $employee;
    public $roles;
    public $positions;

    public $name,
        $username,
        $email,
        $password,
        $role,
        $position_id,
        $citizen_id,
        $leave_remaining,
        $join_date,
        $birth_date,
        $place_of_birth,
        $gender,
        $marital_status,
        $religion,
        $avatar,
        $previewAvatar = "https://cdn.vectorstock.com/i/500p/65/30/default-image-icon-missing-picture-page-vector-40546530.jpg",
        $avatar_url,
        $avatar_path;

    public $user;
    public $type = 'create';

    public function mount($id = null)
    {
        $this->positions = Position::with('department.site')->get();
        $this->roles = Role::all();
        if ($id) {
            $this->employee = Employee::find($id);
            $this->user = $this->employee->user;

            $this->name = $this->user->name;
            $this->username = $this->user->username;
            $this->email = $this->user->email;
            $this->role = $this->user->getRoleNames()->first(); // Mengembalikan nama role pertama yang ditemukan
            // dd($this->role);
            $this->type = 'update';

            $this->citizen_id = $this->employee->citizen_id;
            $this->leave_remaining = $this->employee->leave_remaining;
            $this->join_date = $this->employee->join_date;
            $this->birth_date = $this->employee->birth_date;
            $this->place_of_birth = $this->employee->place_of_birth;
            $this->gender = $this->employee->gender;
            $this->marital_status = $this->employee->marital_status;
            $this->religion = $this->employee->religion;
            $this->position_id = $this->employee->position_id;
            $this->avatar_url = $this->employee->user->avatar_url;
            $this->avatar_path = $this->employee->user->avatar_path;

            // dd($this->avatar_url);
            // dd($this->position_id);
            $this->dispatch('change-select-form');
        }
    }

    public function save()
    {
        try {
            $this->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username,' . ($this->user->id ?? 'NULL'),
                'email' => 'required|email|max:255|unique:users,email,' . ($this->user->id ?? 'NULL'),
                'role' => 'required|exists:roles,name',
                'position_id' => 'required|exists:positions,id',
                'citizen_id' => 'required|string|max:255',
                'join_date' => 'nullable|date',
                'birth_date' => 'nullable|date',
                'place_of_birth' => 'nullable|string|max:255',
                'gender' => 'nullable|in:male,female',
                'marital_status' => 'nullable|string|max:255',
                'religion' => 'nullable|string|max:255',
                'avatar' => 'nullable|image|max:2048',
            ]);

            $uid = (string) Str::uuid();
            $avatarPath = null;
            $avatarUrl = null;
            $thumbnailUrl = null;
            $thumbnailPath = null;

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

            if ($this->type == 'create') {
                $this->password = Str::random(8);
                $this->user = User::create([
                    'username' => $this->username,
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                    'password_string' => $this->password,
                    'avatar_url' => $avatarUrl,
                    'avatar_path' => $avatarPath,
                    'avatar_thumbnail_url' => $thumbnailUrl,
                    'avatar_thumbnail_path' => $thumbnailPath,
                ]);

                $this->user->employee()->create([
                    'id' => date('YmdH') . $this->user->id,
                    'leave_remaining' => $this->leave_remaining,
                    'citizen_id' => $this->citizen_id,
                    'join_date' => $this->join_date,
                    'birth_date' => $this->birth_date,
                    'place_of_birth' => $this->place_of_birth,
                    'gender' => $this->gender,
                    'marital_status' => $this->marital_status,
                    'religion' => $this->religion,
                    'position_id' => $this->position_id,
                ]);

                $this->user->assignRole($this->role);

                activity()
                    ->causedBy($this->authUser) // Pengguna yang melakukan login
                    ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP pengguna
                    ->event('create employee')
                    ->log("$this->authUser->name telah membuat employee");

            } else {
                $this->user->update([
                    'username' => $this->username,
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => $this->password ? Hash::make($this->password) : $this->employee->user->password,
                    'password_string' => $this->password ? $this->password : $this->employee->user->password_string,
                    'avatar_url' => $avatarUrl,
                    'avatar_path' => $avatarPath,
                    'avatar_thumbnail_url' => $thumbnailUrl,
                    'avatar_thumbnail_path' => $thumbnailPath,
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
                    'position_id' => $this->position_id,
                ]);

                $this->user->assignRole($this->role);

                activity()
                    ->causedBy($this->authUser) // Pengguna yang melakukan login
                    ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP pengguna
                    ->event('update employee')
                    ->log("$this->authUser->name telah mengupdate employee");
            }

            $this->alert('success', 'Employee ' . $this->type . ' successfully');
            return redirect()->route('employee.index');
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
        return view('livewire.employee.employee-form')->layout('layouts.app', ['title' => 'Employee']);
    }
}
