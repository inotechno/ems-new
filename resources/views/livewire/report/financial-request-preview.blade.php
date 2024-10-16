<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-3">Financial Request Reports</h4>
        @if ($reports)
            <div class="table-responsive mt-4">
                <table class="table table-bordered table-sm">
                    <thead class="table-light text-center fw-bold text-uppercase align-middle">
                        <tr>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Type</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $financialRequest)
                            <th><small>{{ $financialRequest->employee_id }}</small></th>
                            <th><small>{{ $financialRequest->employee->user->name }}</small></th>
                            <th class="text-center"><small>{{ $financialRequest->amount }}</small></th>
                            <th class="text-center"><small>{{ $financialRequest->financialType->name }}</small></th>
                            <th><small>{{ $financialRequest->notes }}</small></th>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
