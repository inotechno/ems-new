<div>
    <div class="row">
        @foreach ($machines as $machine)
            @livewire('machine.machine-item', ['machine' => $machine], key($machine->id))
        @endforeach
    </div>
</div>
