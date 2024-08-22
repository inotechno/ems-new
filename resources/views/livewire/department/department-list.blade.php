<div>
    <div class="row">
        @foreach ($departments as $department)
            @livewire('department.department-item', ['department' => $department], key($department->id))
        @endforeach
    </div>
</div>
