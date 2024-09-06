<?php

namespace App\Livewire\LeaveRequest;

use App\Livewire\BaseComponent;
use Livewire\Component;
use App\Models\LeaveRequest;
use App\Models\RequestValidate;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;

class LeaveRequestItem extends BaseComponent
{
    use LivewireAlert;
    public $leave_request;
    public $isApproved = false;
    public $totalDays = 0;
    public $disableUpdate = false;
    public $disableUpdateApprove = false;
    public $recipientStatus = false;
    public $isApprovedRecipient = false;

    public function mount(LeaveRequest $leave_request)
    {
        $this->leave_request = $leave_request;

        if($this->authUser->employee->id != $this->leave_request->employee_id){
            $this->disableUpdate = true;
        }

        $this->totalDays = $this->leave_request->end_date->diffInDays($this->leave_request->start_date);
    }

    public function deleteConfirm()
    {
        $this->alert('warning', 'Are you sure you want to delete this leave request?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,

            'showConfirmButton' => true,
            'confirmButtonColor' => '#DD6B55',
            'confirmButtonText' => 'Yes, Delete',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'delete-leave-request',
            'showCancelButton' => true,

            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => false,
            'stopKeydownPropagation' => false,
        ]);
    }

    public function approveConfirm()
    {
        $this->alert('info', 'Are you sure you want to approve this leave request?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,

            'showConfirmButton' => true,
            'confirmButtonColor' => '#00a8ff',
            'confirmButtonText' => 'Yes, Approve',
            'cancelButtonText' => 'Cancel',
            'onConfirmed' => 'approve-leave-request',
            'showCancelButton' => true,

            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => false,
            'stopKeydownPropagation' => false,
        ]);
    }

    #[On('approve-leave-request')]
    public function approve()
    {
        $employeeId = $this->authUser->employee->id;

        // Tambahkan validasi untuk recipient
        RequestValidate::updateOrCreate(
            [
                'validatable_id' => $this->leave_request->id,
                'validatable_type' => LeaveRequest::class,
                'employee_id' => $employeeId,
            ],
            ['status' => 'approved']
        );

        $this->alert('success', 'Leave Request approved successfully');
        $this->dispatch('refreshIndex');
    }

    #[On('reject-absent-request')]
    public function reject()
    {
        $employeeId = $this->authUser->employee->id;

        // Tambahkan validasi untuk recipient
        RequestValidate::updateOrCreate(
            [
                'validatable_id' => $this->leave_request->id,
                'validatable_type' => LeaveRequest::class,
                'employee_id' => $employeeId,
            ],
            ['status' => 'rejected']
        );

        $this->alert('success', 'Absent Request rejected successfully');
        $this->dispatch('refreshIndex');
    }

    #[On('delete-leave-request')]
    public function delete()
    {
        // dd($this->leave_request);
        $this->leave_request->delete();
        $this->alert('success', 'Leave Request deleted successfully');
        $this->dispatch('refreshIndex');
    }

    public function render()
    {
        $employee = $this->leave_request->employee;
        $user = $employee->user;
        $recipients = $this->leave_request->recipients;

        $employeeRecipient = $this->authUser->employee->id;
        $this->recipientStatus = $this->leave_request->hasRecipient($employeeRecipient);
        $this->isApprovedRecipient = $this->leave_request->isApprovedByRecipient($employeeRecipient);

        $this->disableUpdateApprove = $this->isApprovedRecipient;
         // Buat array dengan status validasi untuk setiap recipient
         $recipientsWithStatus = $recipients->map(function ($recipient) {
            $status = $this->leave_request->validates()
                ->where('employee_id', $recipient->employee_id)
                ->first()
                ->status ?? 'pending'; // Default to 'pending' if no status found

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


        return view('livewire.leave-request.leave-request-item', [
            'leave_request' => $this->leave_request,
            'employee' => $employee,
            'user' => $user,
            'recipientsWithStatus' => $recipientsWithStatus,
        ]);
    }
}
