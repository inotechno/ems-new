<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info">
                    <strong>Keterangan:</strong><br>
                    L = Leave<br>
                    A = Absent<br>
                    - = Tidak ada data attendance
                </div>
            </div>
        </div>
        <h4 class="card-title mb-3">Attendance Reports</h4>
        @if ($reports)
            <div class="table-responsive mt-4">
                <table class="table table-bordered table-sm">
                    <thead class="table-light text-center fw-bold text-uppercase align-middle">
                        <tr>
                            <th rowspan="2">Employee ID</th>
                            <th rowspan="2">Name</th>
                            <th colspan="{{ $countDays }}">Date/Time</th>
                        </tr>
                        <tr>
                            @foreach ($dateRange as $date)
                                <th><small>{{ $date->format('d/m') }}</small></th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $report)
                            <tr class="align-middle">
                                <td class="text-center">{{ $report['employee_id'] }}</td>
                                <td>{{ $report['name'] }}</td>
                                @foreach ($report['attendance_data'] as $timeRange)
                                    <td class="text-center"><small>{{ $timeRange }}</small></td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
