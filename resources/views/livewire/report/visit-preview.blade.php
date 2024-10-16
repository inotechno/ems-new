<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-3">Visit Reports</h4>
        @if ($reports)
            <div class="table-responsive mt-4">
                <table class="table table-bordered table-sm">
                    <thead class="table-light text-center fw-bold text-uppercase align-middle">
                        <tr>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Site Name</th>
                            <th>Category</th>
                            <th>Location</th>
                            <th>Distance</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $visit)
                            <th><small>{{ $visit->employee_id }}</small></th>
                            <th><small>{{ $visit->employee->user->name }}</small></th>
                            <th><small>{{ $visit->site->name }}</small></th>
                            <th class="text-center"><small>{{ $visit->visitCategory->name }}</small></th>
                            <th class="text-center"><small>{{ $visit->longitude }}, {{ $visit->latitude }}</small></th>
                            <th class="text-center"><small>{{ $visit->distance }} Km</small></th>
                            <th><small>{{ $visit->notes }}</small></th>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
