<div>
    <div class="row">
        @if ($leave_requests->count() > 0)
        @foreach ($leave_requests as $leave_request)
            @livewire('leave-request.leave-request-item', ['leave_request' => $leave_request], key($leave_request->id))
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
