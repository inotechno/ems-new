<div>
    <div class="row">
        @foreach ($employees as $employee)
            @livewire('employee.employee-item', ['employee' => $employee], key($employee->id))
        @endforeach
    </div>
</div>
