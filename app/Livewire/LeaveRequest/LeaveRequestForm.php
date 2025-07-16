<?php

namespace App\Livewire\LeaveRequest;

use App\Jobs\SendEmailJob;
use App\Livewire\BaseComponent;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;

class LeaveRequestForm extends BaseComponent
{
    use LivewireAlert;

    public $mode = 'Create';
    public $leave_request;
    public $notes, $employee_id, $start_date, $current_total_leave, $total_leave_after_request, $end_date, $recipients;
    public $employee;
    public $leave_remaining = 0, $leave_taken = 0, $leave_period = 0;
    public $employees;

    public function mount($id = null)
    {
        if ($id) {
            $this->mode = 'Edit';
            $this->leave_request = LeaveRequest::find($id);
            $this->employee = $this->leave_request->employee;
            $this->notes = $this->leave_request->notes;
            $this->employee_id = $this->leave_request->employee_id;
            $this->start_date = $this->leave_request->start_date->format('Y-m-d');
            $this->end_date = $this->leave_request->end_date->format('Y-m-d');
            $this->recipients = $this->leave_request->recipients->pluck('employee_id')->toArray();

            $this->dispatch('set-default-form', param: 'recipients', value: $this->recipients);
        } else {
            $this->employee = $this->authUser->employee;

            $this->mode = 'Create';
            $this->notes = '';
            $this->employee_id = $this->employee->id;
            $this->start_date = '';
            $this->end_date = '';
            $this->recipients = [];
            $this->leave_remaining = $this->employee->leave_remaining;
        }

        $this->current_total_leave = $this->employee->leave_remaining;
        $this->employees = Employee::with('user')->whereNot('user_id', Auth::id())->get();
        $this->getAlreadyTaken();
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
        // dd($this->type_leave);
        try {
            $this->validate([
                'notes' => 'required',
                'employee_id' => 'required',
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|after_or_equal:start_date|date|after_or_equal:today',
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
            $leave_request = LeaveRequest::create([
                'notes' => $this->notes,
                'employee_id' => $this->employee_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'total_days' => $period,
                'current_total_leave' => $this->current_total_leave,
                'total_leave_after_request' => $this->current_total_leave - $period,
            ]);

            // Buat recipients menggunakan relasi yang ada
            $leave_request->recipients()->createMany(
                collect($this->recipients)->map(fn($recipient) => ['employee_id' => $recipient])->toArray()
            );

            // Akses relasi employee setelah AbsentRequest berhasil disimpan
            $employee = $leave_request->employee;

            // Akses relasi recipients setelah AbsentRequest berhasil disimpan
            $recipients = $leave_request->recipients;

            // Kirim email ke recipients
            foreach ($recipients as $recipient) {
                $employee = $recipient->employee;
                createNotification(
                    $employee->user_id,
                    $this->authUser->name . ' make Leave Request',
                    $this->authUser->name . 'make-leave-request',
                    'Leave Request',
                    $this->authUser->name . ' telah membuat pengajuan cuti dari tanggal ' . $this->start_date . ' sampai ' . $this->end_date . ', jumlah hari ' . $period . ', catatan ' . $this->notes,
                    route('leave-request.detail', $leave_request->id)
                );

                SendEmailJob::dispatch($recipient->employee->user, 'recipient-leave-request', ['leave_request' => $leave_request], $employee->user);
            }

            // Kirim email menggunakan job
            SendEmailJob::dispatch($employee->user, 'sender-leave-request', ['leave_request' => $leave_request]);

            $this->alert('success', 'Absent Request created successfully');

            createNotification(
                $this->authUser->id,
                'You have Created Leave Request',
                'you-have-create-leave-request',
                'Leave Request',
                'Anda telah membuat pengajuan cuti dari tanggal ' . $this->start_date . ' sampai ' . $this->end_date . ', jumlah hari ' . $period . ', catatan ' . $this->notes,
                route('leave-request.detail', $leave_request->id)
            );

            activity()
                ->causedBy($this->authUser) // Pengguna yang melakukan login
                ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
                ->event('create')
                ->log("{$this->authUser->name} telah membuat Absent Request");

            return redirect()->route('leave-request.index');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function update()
    {
        try {
            $period = $this->getTotalPeriod();

            $this->leave_request->update([
                'notes' => $this->notes,
                'employee_id' => $this->employee_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'total_days' => $period,
                'total_leave_after_request' => $this->current_total_leave - $period,
                'current_total_leave' => $this->current_total_leave,
            ]);

            // Hapus semua recipients yang ada
            $this->leave_request->recipients()->delete();

            // Tambahkan recipients yang baru
            $this->leave_request->recipients()->createMany(
                collect($this->recipients)->map(fn($recipient) => ['employee_id' => $recipient])->toArray()
            );

            activity()
                ->causedBy($this->authUser) // Pengguna yang melakukan login
                ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
                ->event('update')
                ->log("{$this->authUser->name} telah mengubah Absent Request");

            $this->alert('success', 'Absent Request updated successfully');

            return redirect()->route('leave-request.index');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function getTotalPeriod()
    {
        $this->leave_period = Carbon::parse($this->start_date)->diffInDays(Carbon::parse($this->end_date)) + 1;
        return $this->leave_period;
    }

    public function getAlreadyTaken()
    {
        $this->leave_taken = LeaveRequest::where('employee_id', $this->employee_id)->where('is_approved', true)->get()->sum('total_leave_after_request');
        return $this->leave_taken;
    }

    public function render()
    {
        return view('livewire.leave-request.leave-request-form')->layout('layouts.app', ['title' => 'Leave Request ' . $this->mode]);
    }
}
