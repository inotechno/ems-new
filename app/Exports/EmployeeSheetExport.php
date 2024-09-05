<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeeSheetExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithEvents, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Employee::with('user.roles', 'position')->get();
    }

    public function map($employee): array
    {
        $position = $employee->position;

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
            $employee->user->roles->pluck('name')->implode(','),
            $position ? $position->id : '', // Mengambil ID posisi pertama jika ada, jika tidak kosong
            $position ? $position->name : '', // Mengambil nama posisi pertama jika ada, jika tidak kosong
        ];
    }

    public function headings(): array
    {
        return [
            'ID', // A
            'Username', // B
            'Name', // C
            'Email', // D
            'Password', // E
            'Citizen ID', // F
            'Join Date', // G
            'Birth Date', // H
            'Place of Birth', // I
            'Gender', // J
            'Marital Status', // K
            'Religion', // L
            'Leave Remaining', // M
            'Role', // N
            'Position ID', // O
            'Position Name', // P
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

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            'P'  => ['font' => ['color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '7C7C7C']]],
        ];
    }
}
