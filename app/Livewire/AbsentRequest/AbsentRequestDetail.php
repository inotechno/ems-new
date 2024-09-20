<?php

namespace App\Livewire\AbsentRequest;

use App\Livewire\BaseComponent;
use App\Models\AbsentRequest;
use Livewire\Component;

class AbsentRequestDetail extends BaseComponent
{
    public $absent_request, $notes, $start_date, $end_date, $employee_id, $recipients, $recipientsWithStatus, $isApproved;

    public function mount($id)
    {
        $this->absent_request = AbsentRequest::with('employee.user', 'recipients.employee.user')->find($id);
        $this->notes = $this->absent_request->notes;
        $this->isApproved = $this->absent_request->is_approved;
        $this->start_date = $this->absent_request->start_date->format('Y-m-d');
        $this->end_date = $this->absent_request->end_date->format('Y-m-d');
        $this->employee_id = $this->absent_request->employee_id;
        $this->recipients = $this->absent_request->recipients;

        $this->recipientsWithStatus = $this->recipients->map(function ($recipient) {
            $data = $this->absent_request->validates()
                ->where('employee_id', $recipient->employee_id)
                ->first(); // Default to 'pending' if no status found

            $bgClass = match ($data->status ?? 'pending') {
                'approved' => 'bg-info',
                'rejected' => 'bg-danger',
                default => 'bg-warning', // For 'pending'
            };

            return [
                'recipient' => $recipient,
                'status' => $data->status ?? 'pending',
                'bgClass' => $bgClass,
                'created_at' => $data->created_at ?? null,
            ];
        });

        // dd($this->recipientsWithStatus);
    }

    public function render()
    {
        return view('livewire.absent-request.absent-request-detail')->layout('layouts.app', ['title' => 'Absent Request Detail']);
    }
}
