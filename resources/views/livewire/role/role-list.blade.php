<div>
    <div class="row">
        @foreach ($roles as $role)
            @livewire('role.role-item', ['role' => $role], key($role->id))
        @endforeach
    </div>
</div>
