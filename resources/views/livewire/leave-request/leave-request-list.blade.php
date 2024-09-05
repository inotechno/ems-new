<div>
    <div class="row">
        @foreach ($leave_requests as $leave_request)
            @livewire('leave-request.leave-request-item', ['leave_request' => $leave_request], key($leave_request->id))
        @endforeach
    </div>
</div>
