<?php

namespace App\Livewire\AbsentRequest;

use App\Jobs\SendEmailJob;
use App\Livewire\BaseComponent;
use App\Models\AbsentRequest;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class AbsentRequestForm extends BaseComponent
{
    use LivewireAlert;

    public $mode = 'Create';
    public $absent_request;
    public $notes, $employee_id, $start_date, $end_date, $type_absent, $total_days, $recipients = [];
    public $employee;
    public $employees;

    public function mount($id = null)
    {
        $this->employees = Employee::with('user')->whereNot('user_id', $this->authUser->id)->get();

        if ($id) {
            $this->mode = 'Edit';
            $this->absent_request = AbsentRequest::find($id);
            $this->employee = $this->absent_request->employee;
            $this->notes = $this->absent_request->notes;
            $this->employee_id = $this->absent_request->employee_id;
            $this->start_date = $this->absent_request->start_date->format('Y-m-d');
            $this->end_date = $this->absent_request->end_date->format('Y-m-d');
            $this->type_absent = $this->absent_request->type_absent;
            $this->recipients = $this->absent_request->recipients->pluck('employee_id')->toArray();

            $this->dispatch('set-default-form', param: 'recipients', value: $this->recipients);
        } else {
            $this->employee = $this->authUser->employee;

            $this->mode = 'Create';
            $this->notes = '';
            $this->employee_id = $this->employee->id;
            $this->start_date = '';
            $this->end_date = '';
            $this->type_absent = '';
        }
    }

    #[On('change-input-form')]
    public function changeInputForm($param, $value)
    {
        $this->$param = $value;
        if ($param != 'recipients') {
            $this->getTotalPeriod();
        }
    }

    public function save()
    {
        // dd($this->type_absent);
        try {
            $this->validate([
                'notes' => 'required',
                'employee_id' => 'required',
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|after_or_equal:start_date|date|after_or_equal:today',
                'type_absent' => 'required',
                'recipients' => 'required',
            ]);

            if ($this->mode == 'Create') {
                $this->store();
            } else {
                $this->update();
            }
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function store()
    {
        try {
            $period = $this->getTotalPeriod();
            // Simpan AbsentRequest terlebih dahulu
            $absentRequest = AbsentRequest::create([
                'notes' => $this->notes,
                'employee_id' => $this->employee_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'type_absent' => $this->type_absent,
                'total_days' => $period
            ]);

            // Buat recipients menggunakan relasi yang ada
            $absentRequest->recipients()->createMany(
                collect($this->recipients)->map(fn($recipient) => ['employee_id' => $recipient])->toArray()
            );

            // Akses relasi employee setelah AbsentRequest berhasil disimpan
            $employee = $absentRequest->employee;

            // Akses relasi recipients setelah AbsentRequest berhasil disimpan
            $recipients = $absentRequest->recipients;

            // Kirim email ke recipients
            foreach ($recipients as $recipient) {
                $employee = $recipient->employee;
                createNotification(
                    $employee->user_id,
                    $this->authUser->name . ' make Absent Request',
                    $this->authUser->name . 'make-absent-request',
                    'Absent Request',
                    $this->authUser->name . ' telah membuat pengajuan ketidakhadiran dari tanggal ' . $this->start_date . ' sampai ' . $this->end_date . ' dengan catatan ' . $this->notes,
                    route('absent-request.detail', $absentRequest->id)
                );

                SendEmailJob::dispatch($recipient->employee->user, 'recipient-absent-request', ['absent_request' => $absentRequest], $employee->user);
            }

            // Kirim email menggunakan job
            SendEmailJob::dispatch($employee->user, 'sender-absent-request', ['absent_request' => $absentRequest]);

            $this->alert('success', 'Absent Request created successfully');

            createNotification(
                $this->authUser->id,
                'You Have Created Absent Request',
                'you-have-absent-request',
                'Absent Request',
                'Anda telah membuat pengajuan ketidakhadiran dari tanggal ' . $this->start_date . ' sampai ' . $this->end_date . ' dengan catatan ' . $this->notes,
                route('absent-request.detail', $absentRequest->id)
            );

            activity()
                ->causedBy($this->authUser) // Pengguna yang melakukan login
                ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
                ->event('create')
                ->log("{$this->authUser->name} telah membuat Absent Request");

            return redirect()->route('absent-request.index');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function update()
    {
        try {
            $period = $this->getTotalPeriod();
            $this->absent_request->update([
                'notes' => $this->notes,
                'employee_id' => $this->employee_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'type_absent' => $this->type_absent,
                'total_days' => $period
            ]);

            // Hapus semua recipients yang ada
            $this->absent_request->recipients()->delete();

            // Tambahkan recipients yang baru
            $this->absent_request->recipients()->createMany(
                collect($this->recipients)->map(fn($recipient) => ['employee_id' => $recipient])->toArray()
            );

            $this->alert('success', 'Absent Request updated successfully');

            activity()
                ->causedBy($this->authUser) // Pengguna yang melakukan login
                ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
                ->event('update')
                ->log("{$this->authUser->name} telah mengubah Absent Request");

            return redirect()->route('absent-request.index');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function getTotalPeriod()
    {
        $this->total_days = Carbon::parse($this->start_date)->diffInDays(Carbon::parse($this->end_date)) + 1;
        return $this->total_days;
    }

    public function render()
    {
        return view('livewire.absent-request.absent-request-form')->layout('layouts.app', ['title' => 'Absent Request ' . $this->mode]);
    }
}
