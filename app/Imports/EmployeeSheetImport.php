<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\PersistRelations;
use Spatie\Permission\Models\Role;

class EmployeeSheetImport implements ToModel, WithHeadingRow, PersistRelations
{
    use Importable;

    protected $employees;
    protected $positions;
    protected $roles;

    public function __construct()
    {
        $this->employees = Employee::with('positions', 'user', 'user.roles')->get();
        $this->positions = Position::all()->keyBy('id');
        $this->roles = Role::all()->keyBy('id');
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $id = $row['id'];
        $username = $row['username'];
        $name = $row['name'];
        $email = $row['email'];
        $password = $row['password'];
        $citizen_id = $row['citizen_id'];

        // Convert Excel serial date to a PHP Carbon date
        $join_date = $this->excelDateToCarbon($row['join_date']);
        $birth_date = $this->excelDateToCarbon($row['birth_date']);

        $place_of_birth = $row['place_of_birth'];
        $gender = $row['gender'];
        $marital_status = $row['marital_status'];
        $religion = $row['religion'];
        $leave_remaining = $row['leave_remaining'] ?? 0;
        $role = $row['role'];
        $position_id = $row['position_id'];

        $roles = [];

        if (!empty($role)) {
            // Split the comma-separated values into an array
            $roles = explode(',', $role);
            // Remove any extra whitespace from roles
            $roles = array_map('trim', $roles);
        }

        // Cari ID berdasarkan nama role
        $foundRoles = $this->roles->whereIn('name', $roles);

        if ($foundRoles->count() !== count($roles)) {
            throw new \Exception("Roles with names " . implode(',', $roles) . " do not exist.");
        }

        // Convert found roles to an array of IDs
        $roleIds = $foundRoles->pluck('id')->toArray();

        $employee = $this->employees->where('id', $id)->first();
        if ($employee) {
            $user = $employee->user;

            $user->update([
                'username' => $username,
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'password_string' => $password,
            ]);

            $employee->update([
                'id' => $id,
                'citizen_id' => $citizen_id,
                'join_date' => $join_date,
                'birth_date' => $birth_date,
                'place_of_birth' => $place_of_birth,
                'gender' => $gender,
                'marital_status' => $marital_status,
                'religion' => $religion,
                'leave_remaining' => $leave_remaining,
            ]);

            if (!empty($roleIds)) {
                $user->roles()->sync($roleIds);
            }

            // Set positions relation
            if ($position_id != null) {
                $position = $this->positions->find($position_id);
                // $employee->positions()->sync([$position->id]);
                $employee->setRelation('positions', $position);
            }
        } else {
            $user = new User([
                'username' => $username,
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'password_string' => $password,
            ]);

            $user->save();

            dd($user);

            if (!empty($roleIds)) {
                $user->assignRole($roleIds);
            }

            $employee = new Employee([
                'id' => $id,
                'user_id' => $user->id,
                'citizen_id' => $citizen_id,
                'join_date' => $join_date,
                'birth_date' => $birth_date,
                'place_of_birth' => $place_of_birth,
                'gender' => $gender,
                'marital_status' => $marital_status,
                'religion' => $religion,
                'leave_remaining' => $leave_remaining,
            ]);

            $employee->save();

            if ($position_id != null) {
                $position = $this->positions->find($position_id);
                // $employee->positions()->attach([$position->id]);
                $employee->setRelation('positions', $position);
            }
        }

        return $employee;
    }

    public function headingRow(): int
    {
        return 1;
    }

    private function excelDateToCarbon($serialDate)
    {
        // Cek apakah nilai kosong atau null
        if (empty($serialDate)) {
            return null;
        }

        // Cek apakah sudah dalam format tanggal yang valid
        if (Carbon::hasFormat($serialDate, 'Y-m-d')) {
            return $serialDate; // Jika sudah dalam format Y-m-d, langsung kembalikan
        }

        // Cek apakah nilai adalah numerik
        if (is_numeric($serialDate) && $serialDate > 0) {
            $unixDate = ($serialDate - 25569) * 86400;
            return Carbon::createFromTimestamp($unixDate)->format('Y-m-d');
        }

        // Jika tidak, kembalikan null atau bisa juga melempar exception
        return null;
    }
}
