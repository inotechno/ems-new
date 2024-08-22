<div>
    <div class="row">
        @foreach ($positions as $position)
            @livewire('position.position-item', ['position' => $position], key($position->id))
        @endforeach
    </div>
</div>
