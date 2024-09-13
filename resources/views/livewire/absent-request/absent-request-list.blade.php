<div>
    <div class="row">
        @if ($absent_requests->count() > 0)
            @foreach ($absent_requests as $absent_request)
                @livewire('absent-request.absent-request-item', ['absent_request' => $absent_request], key($absent_request->id))
            @endforeach
        @else
            <div class="col-md">
                <div class="card">
                    <div class="card-body text-center">
                        <h4 class="card-title">NO DATA</h4>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
