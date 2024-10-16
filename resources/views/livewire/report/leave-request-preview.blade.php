<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-3">Leave Request Reports</h4>
        @if ($reports)
            <div class="table-responsive mt-4">
                <table class="table table-bordered table-sm">
                    <thead class="table-light text-center fw-bold text-uppercase align-middle">
                        <tr>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Date Range</th>
                            <th>Total Leave</th>
                            <th>Current Leave</th>
                            <th>Remaining Leave</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $leaveRequest)
                            <th><small>{{ $leaveRequest->employee_id }}</small></th>
                            <th><small>{{ $leaveRequest->employee->user->name }}</small></th>
                            <th class="text-center"><small>{{ $leaveRequest->start_date->format('d/m') }} -
                                    {{ $leaveRequest->end_date->format('d/m') }}</small></th>
                            <th class="text-center"><small>{{ $leaveRequest->total_days }}</small></th>
                            <th class="text-center"><small>{{ $leaveRequest->current_total_leave }}</small></th>
                            <th class="text-center"><small>{{ $leaveRequest->total_leave_after_request }}</small></th>
                            <th><small>{{ $leaveRequest->notes }}</small></th>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
