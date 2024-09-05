<div>
    <div class="row">
        @foreach ($absent_requests as $absent_request)
            @livewire('absent-request.absent-request-item', ['absent_request' => $absent_request], key($absent_request->id))
        @endforeach
    </div>
</div>
