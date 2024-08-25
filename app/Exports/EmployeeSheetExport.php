<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class EmployeeSheetExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Employee::with(['user.roles', 'positions' => function ($query) {
            $query->limit(1);
        }])->get();
    }

    public function map($employee): array
    {
        $position = $employee->positions->first();

        return [
            $employee->id,
            $employee->user->username,
            $employee->user->name,
            $employee->user->email,
            $employee->user->password_string,
            $employee->citizen_id,
            $employee->join_date,
            $employee->birth_date,
            $employee->place_of_birth,
            $employee->gender,
            $employee->marital_status,
            $employee->religion,
            $employee->leave_remaining,
            $employee->user->roles->pluck('name'),
            optional($position)->id, // Mengambil ID posisi pertama dengan eager loading
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Username',
            'Name',
            'Email',
            'Password',
            'Citizen ID',
            'Join Date',
            'Birth Date',
            'Place of Birth',
            'Gender',
            'Marital Status',
            'Religion',
            'Leave Remaining',
            'Role',
            'Position ID'
        ];
    }

    public function title(): string
    {
        return 'Employees';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->getStyle('G2:G1000')->getNumberFormat()->setFormatCode('yyyy-mm-dd');
                $sheet->getStyle('H2:H1000')->getNumberFormat()->setFormatCode('yyyy-mm-dd');

                // Menambahkan catatan pada kolom Email (misalnya di sel C1)
                $sheet->getComment('D1')->getText()->createTextRun('Masukkan email karyawan yang valid.');

                // Menambahkan catatan pada kolom Gender (misalnya di sel I1)
                $sheet->getComment('J1')->getText()->createTextRun('Pilih gender yang sesuai dari dropdown.');

                // Menambahkan catatan pada kolom Role (misalnya di sel M1)
                $sheet->getComment('N1')->getText()->createTextRun('Masukkan peran yang sesuai, bisa lebih dari satu.');
                $sheet->getComment('O1')->getText()->createTextRun('Masukkan posisi ID yang sesuai, lihat pada sheet "Positions".');

                // Validasi data untuk kolom "Gender" (misalnya di kolom I)
                $validation = $sheet->getCell('J2')->getDataValidation();
                $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
                $validation->setAllowBlank(false);
                $validation->setShowDropDown(true);
                $validation->setFormula1('"male,female"'); // Opsi validasi

                // Terapkan validasi ke seluruh baris di kolom I (gender)
                $sheet->setDataValidation(
                    'J2:J1000', // Rentang sel, I2 sampai I1000
                    $validation
                );

                // Validasi data untuk kolom "Marital Status" (misalnya di kolom J)
                $validation = $sheet->getCell('K2')->getDataValidation();
                $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
                $validation->setAllowBlank(false);
                $validation->setShowDropDown(true);
                $validation->setFormula1('"single,married"'); // Opsi validasi

                // Terapkan validasi ke seluruh baris di kolom J (marital status)
                $sheet->setDataValidation(
                    'K2:K1000', // Rentang sel, J2 sampai J1000
                    $validation
                );

                // Validasi data untuk kolom "Religion" (misalnya di kolom K)
                $validation = $sheet->getCell('L2')->getDataValidation();
                $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
                $validation->setAllowBlank(false);
                $validation->setShowDropDown(true);
                $validation->setFormula1('"islam,kristen,katholik,hindu,budha,konghucu"'); // Opsi validasi

                // Terapkan validasi ke seluruh baris di kolom K (religion)
                $sheet->setDataValidation(
                    'L2:L1000', // Rentang sel, K2 sampai K1000
                    $validation
                );
            },
        ];
    }
}
