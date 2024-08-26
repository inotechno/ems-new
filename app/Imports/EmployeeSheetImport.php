<?php
namespace App\Imports;

use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\PersistRelations;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithValidation;
use Spatie\Permission\Models\Role;

class EmployeeSheetImport implements ToCollection, WithHeadingRow, SkipsEmptyRows, PersistRelations
{
    use Importable;
    protected $employees;
    protected $positions;
    protected $roles;

    public function __construct()
    {
        $this->employees = Employee::with('positions', 'user', 'user.roles')->get();
        $this->positions = Position::all()->keyBy('id');
        $this->roles = Role::all()->keyBy('name');
    }

    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $id = $row['id'];
            $username = $row['username'];
            $name = $row['name'];
            $email = $row['email'];
            $password = $row['password'];
            $citizen_id = $row['citizen_id'];

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
                $roles = array_map('trim', explode(',', $role));
            }

            // dd($username, $name, $email, $password, $citizen_id, $join_date, $birth_date, $place_of_birth, $gender, $marital_status, $religion, $leave_remaining, $role, $position_id, $roles);

            // Fetch roles by name
            $foundRoles = $this->roles->whereIn('name', $roles);

            if ($foundRoles->count() !== count($roles)) {
                throw new \Exception("Roles with names " . implode(',', $roles) . " do not exist.");
            }

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
                    'citizen_id' => $citizen_id,
                    'join_date' => $join_date,
                    'birth_date' => $birth_date,
                    'place_of_birth' => $place_of_birth,
                    'gender' => $gender,
                    'marital_status' => $marital_status,
                    'religion' => $religion,
                    'leave_remaining' => $leave_remaining,
                ]);

                if ($position_id != null) {
                    $positionIds = is_array($position_id) ? $position_id : [$position_id];
                    $positions = $this->positions->whereIn('id', $positionIds);
                    $employee->positions()->sync($positions->pluck('id')->toArray());
                }

                if (!empty($roleIds)) {
                    $user->roles()->sync($roleIds);
                }
            } else {
                $user = User::create([
                    'username' => $username,
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'password_string' => $password,
                ]);

                \Log::info('User created:', $user->toArray());

                if (!empty($roleIds)) {
                    $user->assignRole($roleIds);
                }

                $employee = $user->employee()->create([
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

                if ($position_id != null) {
                    $positionIds = is_array($position_id) ? $position_id : [$position_id];
                    $positions = $this->positions->whereIn('id', $positionIds);
                    $employee->positions()->sync($positions->pluck('id')->toArray());
                }
            }
        }
    }

    private function excelDateToCarbon($serialDate)
    {
        if (empty($serialDate)) {
            return null;
        }

        if (Carbon::hasFormat($serialDate, 'Y-m-d')) {
            return $serialDate;
        }

        if (is_numeric($serialDate) && $serialDate > 0) {
            $unixDate = ($serialDate - 25569) * 86400;
            return Carbon::createFromTimestamp($unixDate)->format('Y-m-d');
        }

        return null;
    }
}
