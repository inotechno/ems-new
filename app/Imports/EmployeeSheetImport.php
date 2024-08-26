<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeeSheetImport implements ToModel, WithHeadingRow
{
    use Importable;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // dd($row);
        $id = $row['id'];
        $username = $row['username'];
        $name = $row['name'];
        $email = $row['email'];
        $password = $row['password'];
        $citizen_id = $row['citizen_id'];
        $join_date = $row['join_date'];
        $birth_date = $row['birth_date'];
        $place_of_birth = $row['place_of_birth'];
        $gender = $row['gender'];
        $marital_status = $row['marital_status'];
        $religion = $row['religion'];
        $leave_remaining = $row['leave_remaining'];
        $role = $row['role'];
        $position_id = $row['position_id'];

        // Menyimpan data user
        $user = User::updateOrCreate(
            [
                'email' => $email,
                'username' => $username,
            ],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'password_string' => $password,
            ]
        );

        $employee = Employee::updateOrCreate(
            ['id' => $id],
            [
                'citizen_id' => $citizen_id,
                'join_date' => $join_date,
                'birth_date' => $birth_date,
                'place_of_birth' => $place_of_birth,
                'gender' => $gender,
                'marital_status' => $marital_status,
                'religion' => $religion,
                'leave_remaining' => $leave_remaining,
                'user_id' => $user->id,
            ]
        );

        // Menambahkan role ke user
        if (!empty($role)) {
            $roles = explode(',', $role);
            $user->syncRoles($roles);
        }

        // Menambahkan posisi ke employee
        if (!empty($position_id)) {
            $employee->positions()->sync([$position_id]);
        }

        return $employee;
    }

    public function headingRow(): int
    {
        return 1;
    }
}
