<?php

namespace App\Livewire\FinancialRequest;

use App\Livewire\BaseComponent;
use App\Models\Employee;
use App\Models\FinancialRequest;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class FinancialRequestIndex extends BaseComponent
{
    use LivewireAlert, WithPagination;

    public $employee_id = [];
    public $perPage = 10;
    public $start_date;
    public $end_date;

    #[Url(except: '')]
    public $search = '';

    public $employees;

    protected $listeners = ['refreshIndex' => '$refresh'];

    public function mount()
    {
        $this->employees = Employee::with('user')->get();
    }

    public function render()
    {
        $financial_requests = FinancialRequest::with('employee.user', 'recipients.employee.user')->when($this->search, function ($query) {
            $query->whereHas('employee.user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })->orWhere('notes', 'like', '%' . $this->search . '%');
        })->when($this->employee_id, function ($query) {
            $query->whereIn('employee_id', $this->employee_id);
        })->when($this->start_date, function ($query) {
            $query->whereDate('start_date', '>=', $this->start_date);
        })->when($this->end_date, function ($query) {
            $query->orWhereDate('end_date', '<=', $this->end_date);
        });

        $financial_requests->where('employee_id', $this->authUser->employee->id);
        $financial_requests = $financial_requests->paginate($this->perPage);

        return view('livewire.financial-request.financial-request-index', compact('financial_requests'))->layout('layouts.app', ['title' => 'Financial Request']);
    }
}
