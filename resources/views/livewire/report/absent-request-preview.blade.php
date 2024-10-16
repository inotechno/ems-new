<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-3">Absent Request Reports</h4>
        @if ($reports)
            <div class="table-responsive mt-4">
                <table class="table table-bordered table-sm">
                    <thead class="table-light text-center fw-bold text-uppercase align-middle">
                        <tr>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Date Range</th>
                            <th>Type</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $absentRequest)
                            <th><small>{{ $absentRequest->employee_id }}</small></th>
                            <th><small>{{ $absentRequest->employee->user->name }}</small></th>
                            <th class="text-center"><small>{{ $absentRequest->start_date->format('d/m') }} -
                                    {{ $absentRequest->end_date->format('d/m') }}</small></th>
                            <th class="text-center"><small>{{ $absentRequest->type_absent }}</small></th>
                            <th><small>{{ $absentRequest->notes }}</small></th>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
