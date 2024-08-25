<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class EmployeeSheetImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $id = $row[0];
        $username = $row[1];
        $name = $row[2];
        $email = $row[3];
        $password = $row[4];
        $citizen_id = $row[5];
        $join_date = $row[6];
        $birth_date = $row[7];
        $place_of_birth = $row[8];
        $gender = $row[9];
        $marital_status = $row[10];
        $religion = $row[11];
        $leave_remaining = $row[12];
        $role = $row[13];
        $position_id = $row[14];

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
}
