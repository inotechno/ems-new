<?php

namespace App\Livewire\Employee;

use App\Livewire\BaseComponent;
use Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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
    $selectedRoles = [],
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
    $avatar_path,
    $whatsapp_number;

    // Sallary Component
    public $basic_salary,
    $allowance_pulsa,
    $allowance_position,
    $allowance_transport,
    $allowance_meal,
    $allowance_overtime,
    $allowance_other,
    $salary_per_day,
    $bpjs_kesehatan_rate,
    $bpjs_tk_rate,
    $pension_rate,
    $pph21_rate;

    // Deduction Component
    public $deduction_daily_report,
    $deduction_late;

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
            $this->selectedRoles = $this->user->getRoleNames()->toArray();
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
            $this->whatsapp_number = $this->employee->whatsapp_number;

            if ($this->avatar_url) {
                $this->previewAvatar = $this->avatar_url;
            }

            // Sallary Component
            $this->basic_salary = $this->employee->basic_salary;
            $this->allowance_pulsa = $this->employee->allowance_pulsa;
            $this->allowance_position = $this->employee->allowance_position;
            $this->allowance_transport = $this->employee->allowance_transport;
            $this->allowance_meal = $this->employee->allowance_meal;
            $this->allowance_overtime = $this->employee->allowance_overtime;
            $this->allowance_other = $this->employee->allowance_other;
            $this->salary_per_day = $this->employee->salary_per_day;

            $this->bpjs_kesehatan_rate = $this->employee->bpjs_kesehatan_rate;
            $this->bpjs_tk_rate = $this->employee->bpjs_tk_rate;
            $this->pension_rate = $this->employee->pension_rate;
            $this->pph21_rate = $this->employee->pph21_rate;

            $this->deduction_daily_report = $this->employee->deduction_daily_report;
            $this->deduction_late = $this->employee->deduction_late;

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
                'selectedRoles' => 'required|exists:roles,name',
                'position_id' => 'required|exists:positions,id',
                'citizen_id' => 'required|string|max:255',
                'join_date' => 'nullable|date',
                'birth_date' => 'nullable|date',
                'place_of_birth' => 'nullable|string|max:255',
                'gender' => 'required|in:male,female',
                'marital_status' => 'nullable|string|max:255',
                'religion' => 'nullable|string|max:255',
                'avatar' => 'nullable|image|max:2048',
                'whatsapp_number' => 'nullable|numeric',
            ]);

            $uid = (string) Str::uuid();
            $avatarPath = null;
            $avatarUrl = null;
            $thumbnailUrl = null;
            $thumbnailPath = null;

            DB::beginTransaction();

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

            // Generate password jika create
            if ($this->type === 'create') {
                $this->password = Str::random(8);
            }

            $userData = [
                'username' => $this->username,
                'name' => $this->name,
                'email' => $this->email,
                'avatar_url' => $avatarUrl,
                'avatar_path' => $avatarPath,
                'avatar_thumbnail_url' => $thumbnailUrl,
                'avatar_thumbnail_path' => $thumbnailPath,
            ];

            $employeeData = [
                'citizen_id' => $this->citizen_id,
                'join_date' => $this->join_date,
                'birth_date' => $this->birth_date,
                'place_of_birth' => $this->place_of_birth,
                'gender' => $this->gender,
                'marital_status' => $this->marital_status,
                'religion' => $this->religion,
                'leave_remaining' => $this->leave_remaining,
                'position_id' => $this->position_id,
                'whatsapp_number' => $this->whatsapp_number,
            ];

            if ($this->password || $this->password != null) {
                $userData['password'] = Hash::make($this->password ?? $this->employee->user->password);
                $userData['password_string'] = $this->password ?? $this->employee->user->password_string;
            }

            if ($this->type === 'create') {
                $this->user = User::create($userData);

                $this->user->employee()->create([
                    'id' => date('YmdH') . $this->user->id,
                    ...$employeeData
                ]);

                $event = 'create employee';
                $log = "{$this->authUser->name} telah membuat employee";
            } else {
                $this->user->update($userData);
                $this->employee->update($employeeData);

                $event = 'update employee';
                $log = "{$this->authUser->name} telah mengupdate employee";
            }

            $this->user->syncRoles($this->selectedRoles);

            activity()
                ->causedBy($this->authUser)
                ->withProperties(['ip' => request()->ip()])
                ->event($event)
                ->log($log);

            DB::commit();
            $this->alert('success', 'Employee ' . $this->type . ' successfully');
            return redirect()->route('employee.index');
        } catch (\Exception $e) {
            DB::rollBack();
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
