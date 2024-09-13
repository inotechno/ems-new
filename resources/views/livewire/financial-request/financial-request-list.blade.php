<div>
    <div class="row">
        @if ($financial_requests->count() > 0)
        @foreach ($financial_requests as $financial_request)
            @livewire('financial-request.financial-request-item', ['financial_request' => $financial_request], key($financial_request->id))
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
