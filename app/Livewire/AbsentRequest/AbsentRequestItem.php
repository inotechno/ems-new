<?php

namespace App\Livewire\AbsentRequest;

use App\Jobs\SendEmailJob;
use App\Livewire\BaseComponent;
use App\Models\AbsentRequest;
use App\Models\RequestValidate;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class AbsentRequestItem extends BaseComponent
{
    use LivewireAlert;
    public $absent_request;
    public $isApproved = false;
    public $isRejected = false;
    public $totalDays = 0;
    public $disableUpdate = false;
    public $disableUpdateApprove = false;
    public $recipientStatus = false;
    public $isApprovedRecipient = false;

    public function mount(AbsentRequest $absent_request)
    {
        $this->absent_request = $absent_request;
        // dd($this->authUser->employee->id);
        if ($this->authUser->employee->id != $this->absent_request->employee_id) {
            $this->disableUpdate = true;
        }

        $this->totalDays = $this->absent_request->end_date->diffInDays($this->absent_request->start_date) + 1;
        $this->isApproved = $this->absent_request->is_approved;
        $this->isRejected = $this->absent_request->isRejectedByRecipients();
    }

    public function deleteConfirm()
    {
        $this->alert('warning', 'Are you sure you want to delete this absent request?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,

            'showConfirmButton' => true,
            'confirmButtonColor' => '#DD6B55',
            'confirmButtonText' => 'Yes, Delete',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'delete-absent-request',
            'showCancelButton' => true,

            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => false,
            'stopKeydownPropagation' => false,
        ]);
    }

    public function approveConfirm()
    {
        $this->alert('info', 'Are you sure you want to approve this absent request?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,

            'showConfirmButton' => true,
            'confirmButtonColor' => '#00a8ff',
            'confirmButtonText' => 'Yes, Approve',
            'cancelButtonText' => 'Cancel',
            'onConfirmed' => 'approve-absent-request',
            'showCancelButton' => true,

            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => false,
            'stopKeydownPropagation' => false,
        ]);
    }

    public function rejectConfirm()
    {
        $this->alert('info', 'Are you sure you want to reject this absent request?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,

            'showConfirmButton' => true,
            'confirmButtonColor' => '#A90C0C',
            'confirmButtonText' => 'Yes, Reject',
            'cancelButtonText' => 'Cancel',
            'onConfirmed' => 'reject-absent-request',
            'showCancelButton' => true,

            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => false,
            'stopKeydownPropagation' => false,
        ]);
    }

    #[On('approve-absent-request')]
    public function approve()
    {
        $employeeId = $this->authUser->employee->id;

        // Tambahkan validasi untuk recipient
        RequestValidate::updateOrCreate(
            [
                'validatable_id' => $this->absent_request->id,
                'validatable_type' => AbsentRequest::class,
                'employee_id' => $employeeId,
            ],
            ['status' => 'approved']
        );

        SendEmailJob::dispatch($this->absent_request->employee->user, 'approved-absent-request', ['absent_request' => $this->absent_request], $this->authUser);

        // Periksa dan perbarui status isApproved pada AbsentRequest
        $this->absent_request->checkAndUpdateApprovalStatus();

        createNotification(
            $this->absent_request->employee->user->id,
            'Approved Absent Request',
            'approved-absent-request',
            'Absent Request',
            'Absent Request has been approved',
            route('absent-request.detail', $this->absent_request->id)
        );

        activity()
            ->causedBy($this->authUser) // Pengguna yang melakukan login
            ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
            ->event('approve')
            ->log("{$this->authUser->name} telah approve Absent Request");

        $this->alert('success', 'Absent Request approved successfully');
        $this->dispatch('refreshIndex');
    }

    #[On('reject-absent-request')]
    public function reject()
    {
        $employeeId = $this->authUser->employee->id;

        // Tambahkan validasi untuk recipient
        RequestValidate::updateOrCreate(
            [
                'validatable_id' => $this->absent_request->id,
                'validatable_type' => AbsentRequest::class,
                'employee_id' => $employeeId,
            ],
            ['status' => 'rejected']
        );

        SendEmailJob::dispatch($this->absent_request->employee->user, 'rejected-absent-request', ['absent_request' => $this->absent_request], $this->authUser);

        // Periksa dan perbarui status isApproved pada AbsentRequest
        $this->absent_request->checkAndUpdateApprovalStatus();
        createNotification(
            $this->absent_request->employee->user->id,
            'Rejected Absent Request',
            'rejected-absent-request',
            'Absent Request',
            'Absent Request has been rejected',
            route('absent-request.detail', $this->absent_request->id)
        );

        activity()
            ->causedBy($this->authUser) // Pengguna yang melakukan login
            ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
            ->event('reject absent request')
            ->log("{$this->authUser->name} telah reject Absent Request");

        $this->alert('success', 'Absent Request rejected successfully');
        $this->dispatch('refreshIndex');
    }

    #[On('delete-absent-request')]
    public function delete()
    {
        // dd($this->absent_request);
        $this->absent_request->delete();
        $this->alert('success', 'Absent Request deleted successfully');

        activity()
            ->causedBy($this->authUser) // Pengguna yang melakukan login
            ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
            ->event('delete')
            ->log("{$this->authUser->name} telah menghapus Absent Request");

        return redirect()->route('absent-request.index');
    }

    public function render()
    {
        $employee = $this->absent_request->employee;
        $user = $employee->user;
        $recipients = $this->absent_request->recipients;

        $employeeRecipient = $this->authUser->employee->id;
        $this->recipientStatus = $this->absent_request->hasRecipient($employeeRecipient);
        $this->isApprovedRecipient = $this->absent_request->isApprovedByRecipient($employeeRecipient);

        $this->disableUpdateApprove = $this->isApprovedRecipient;
        // Buat array dengan status validasi untuk setiap recipient
        $recipientsWithStatus = $recipients->map(function ($recipient) {
            $status = $this->absent_request->validates()
                ->where('employee_id', $recipient->employee_id)
                ->first()
                ->status ?? 'pending'; // Default to 'pending' if no status found

            if ($status == 'approved') {
                $this->disableUpdate = true;
            }

            $badgeClass = match ($status) {
                'approved' => 'badge-soft-info',
                'rejected' => 'badge-soft-danger',
                default => 'badge-soft-warning', // For 'pending'
            };

            return [
                'recipient' => $recipient,
                'status' => $status,
                'badgeClass' => $badgeClass,
            ];
        });

        // dd($this->recipientStatus);

        return view('livewire.absent-request.absent-request-item', [
            'absent_request' => $this->absent_request,
            'employee' => $employee,
            'user' => $user,
            'recipientsWithStatus' => $recipientsWithStatus,
        ]);
    }
}
