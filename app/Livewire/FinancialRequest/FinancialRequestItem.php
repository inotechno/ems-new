<?php

namespace App\Livewire\FinancialRequest;

use App\Jobs\SendEmailJob;
use App\Livewire\BaseComponent;
use App\Models\FinancialRequest;
use App\Models\RequestValidate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;

class FinancialRequestItem extends BaseComponent
{
    use LivewireAlert;

    public $financial_request;
    public $isApproved = false;
    public $isRejected = false;
    public $disableUpdate = false;
    public $disableUpdateApprove = false;
    public $recipientStatus = false;
    public $isApprovedRecipient = false;

    public function mount(FinancialRequest $financial_request)
    {
        $this->financial_request = $financial_request;

        if($this->authUser->employee->id != $this->financial_request->employee_id){
            $this->disableUpdate = true;
        }

        $this->isApproved = $this->financial_request->is_approved;
        $this->isRejected = $this->financial_request->isRejectedByRecipients();
    }

    public function deleteConfirm()
    {
        $this->alert('warning', 'Are you sure you want to delete this financial request?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,

            'showConfirmButton' => true,
            'confirmButtonColor' => '#DD6B55',
            'confirmButtonText' => 'Yes, Delete',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'delete-financial-request',
            'showCancelButton' => true,

            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => false,
            'stopKeydownPropagation' => false,
        ]);
    }

    public function approveConfirm()
    {
        $this->alert('info', 'Are you sure you want to approve this financial request?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,

            'showConfirmButton' => true,
            'confirmButtonColor' => '#00a8ff',
            'confirmButtonText' => 'Yes, Approve',
            'cancelButtonText' => 'Cancel',
            'onConfirmed' => 'approve-financial-request',
            'showCancelButton' => true,

            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => false,
            'stopKeydownPropagation' => false,
        ]);
    }

    public function rejectConfirm()
    {
        $this->alert('info', 'Are you sure you want to reject this financial request?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,

            'showConfirmButton' => true,
            'confirmButtonColor' => '#A90C0C',
            'confirmButtonText' => 'Yes, Reject',
            'cancelButtonText' => 'Cancel',
            'onConfirmed' => 'reject-financial-request',
            'showCancelButton' => true,

            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => false,
            'stopKeydownPropagation' => false,
        ]);
    }

    #[On('approve-financial-request')]
    public function approve()
    {
        $employeeId = $this->authUser->employee->id;

        // Tambahkan validasi untuk recipient
        RequestValidate::updateOrCreate(
            [
                'validatable_id' => $this->financial_request->id,
                'validatable_type' => FinancialRequest::class,
                'employee_id' => $employeeId,
            ],
            ['status' => 'approved']
        );

        SendEmailJob::dispatch($this->financial_request->employee->user, 'approved-financial-request', ['financial_request' => $this->financial_request], $this->authUser);

        // Periksa dan perbarui status isApproved pada AbsentRequest
        $this->financial_request->checkAndUpdateApprovalStatus();

        createNotification(
            $this->financial_request->employee->user->id,
            'Approved Financial Request',
            'approve-financial-request',
            'Financial Request',
            'Financial Request has been approve',
            route('financial-request.detail', $this->financial_request->id)
        );

        activity()
            ->causedBy($this->authUser) // Pengguna yang melakukan login
            ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
            ->event('approve')
            ->log("{$this->authUser->name} telah approve Financial Request");

        $this->alert('success', 'Financial Request approved successfully');
        $this->dispatch('refreshIndex');
    }

    #[On('reject-financial-request')]
    public function reject()
    {
        $employeeId = $this->authUser->employee->id;

        // Tambahkan validasi untuk recipient
        RequestValidate::updateOrCreate(
            [
                'validatable_id' => $this->financial_request->id,
                'validatable_type' => FinancialRequest::class,
                'employee_id' => $employeeId,
            ],
            ['status' => 'rejected']
        );

        SendEmailJob::dispatch($this->financial_request->employee->user, 'rejected-financial-request', ['financial_request' => $this->financial_request], $this->authUser);

        // Periksa dan perbarui status isApproved pada AbsentRequest
        $this->financial_request->checkAndUpdateApprovalStatus();
        createNotification(
            $this->financial_request->employee->user->id,
            'Rejected Financial Request',
            'rejected-financial-request',
            'Financial Request',
            'Financial Request has been rejected',
            route('financial-request.detail', $this->financial_request->id)
        );

        activity()
            ->causedBy($this->authUser) // Pengguna yang melakukan login
            ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
            ->event('reject financial request')
            ->log("{$this->authUser->name} telah reject Financial Request");

        $this->alert('success', 'Financial Request rejected successfully');
        $this->dispatch('refreshIndex');
    }

    #[On('delete-financial-request')]
    public function delete()
    {
        // dd($this->financial_request);
        $this->financial_request->delete();
        $this->alert('success', 'Financial Request deleted successfully');

        activity()
            ->causedBy($this->authUser) // Pengguna yang melakukan login
            ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
            ->event('delete')->subject('delete financial request')
            ->log("{$this->authUser->name} telah delete Financial Request");

        return redirect()->route('financial-request.index');
    }


    public function render()
    {
        $employee = $this->financial_request->employee;
        $user = $employee->user;
        $recipients = $this->financial_request->recipients;

        $employeeRecipient = $this->authUser->employee->id;
        $this->recipientStatus = $this->financial_request->hasRecipient($employeeRecipient);
        $this->isApprovedRecipient = $this->financial_request->isApprovedByRecipient($employeeRecipient);

        $this->disableUpdateApprove = $this->isApprovedRecipient;
         // Buat array dengan status validasi untuk setiap recipient
        $recipientsWithStatus = $recipients->map(function ($recipient) {
            $status = $this->financial_request->validates()
                ->where('employee_id', $recipient->employee_id)
                ->first()
                ->status ?? 'pending'; // Default to 'pending' if no status found

            if($status == 'approved') {
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

        return view('livewire.financial-request.financial-request-item', [
            'financial_request' => $this->financial_request,
            'employee' => $employee,
            'user' => $user,
            'recipientsWithStatus' => $recipientsWithStatus,
        ]);
    }
}
