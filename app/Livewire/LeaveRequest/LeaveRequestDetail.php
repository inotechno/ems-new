<?php

namespace App\Livewire\LeaveRequest;

use App\Models\LeaveRequest;
use Livewire\Component;

class LeaveRequestDetail extends Component
{
    public $leave_request, $notes, $start_date, $end_date, $employee_id, $recipients, $isApproved, $current_total_leave, $total_days, $total_leave_after_request, $recipientsWithStatus;

    public $leave_remaining = 0, $leave_taken = 0, $leave_period = 0;

    public function mount($id)
    {
        $this->leave_request = LeaveRequest::with('employee.user', 'recipients.employee.user')->find($id);

        if (!$this->leave_request) {
            return redirect()->route('leave-request.index');
        }

        $this->notes = $this->leave_request->notes;
        $this->isApproved = $this->leave_request->is_approved;
        $this->start_date = $this->leave_request->start_date->format('Y-m-d');
        $this->end_date = $this->leave_request->end_date->format('Y-m-d');
        $this->employee_id = $this->leave_request->employee_id;
        $this->current_total_leave = $this->leave_request->current_total_leave;
        $this->total_days = $this->leave_request->total_days;
        $this->total_leave_after_request = $this->leave_request->total_leave_after_request;
        $this->recipients = $this->leave_request->recipients;
        $this->leave_remaining = $this->leave_request->current_total_leave;
        $this->leave_period = $this->leave_request->total_days;
        $this->getAlreadyTaken();

        $this->recipientsWithStatus = $this->recipients->map(function ($recipient) {
            $data = $this->leave_request->validates()
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

        $this->dispatch('change-default');
    }

    public function getAlreadyTaken()
    {
        $this->leave_taken = LeaveRequest::where('employee_id', $this->employee_id)->where('is_approved', true)->get()->sum('total_leave_after_request');
        return $this->leave_taken;
    }

    public function render()
    {
        return view('livewire.leave-request.leave-request-detail')->layout('layouts.app', ['title' => 'Leave Request Detail']);
    }
}
