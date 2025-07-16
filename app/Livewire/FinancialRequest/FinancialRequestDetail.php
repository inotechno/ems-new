<?php

namespace App\Livewire\FinancialRequest;

use Livewire\Component;

class FinancialRequestDetail extends Component
{
    public $financial_request;
    public $employee_id, $financial_type_id, $title, $amount, $notes, $receipt_image_path, $receipt_image_url, $isApproved, $recipients, $recipientsWithStatus, $financialType;

    public function mount($id)
    {
        $this->financial_request = \App\Models\FinancialRequest::find($id);

        if(!$this->financial_request) {
            return redirect()->route('financial-request.index');
        }

        $this->isApproved = $this->financial_request->is_approved;
        $this->employee_id = $this->financial_request->employee_id;
        $this->financial_type_id = $this->financial_request->financial_type_id;
        $this->title = $this->financial_request->title;
        $this->amount = $this->financial_request->amount;
        $this->financialType = $this->financial_request->financialType;
        $this->notes = $this->financial_request->notes;
        $this->receipt_image_path = $this->financial_request->receipt_image_path;
        $this->receipt_image_url = $this->financial_request->receipt_image_url;
        $this->recipients = $this->financial_request->recipients;

        $this->recipientsWithStatus = $this->recipients->map(function ($recipient) {
            $data = $this->financial_request->validates()
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
    }

    public function render()
    {
        return view('livewire.financial-request.financial-request-detail')->layout('layouts.app', ['title' => 'financial Request Detail']);
    }
}
