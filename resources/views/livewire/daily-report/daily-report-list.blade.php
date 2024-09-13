<div>
    <div class="table-responsive">
        <table class="table project-list-table table-nowrap align-middle table-borderless">
            <thead>
                <tr>
                    <th scope="col" style="width: 100px">#</th>
                    <th scope="col">NAME</th>
                    <th scope="col">DATE</th>
                    <th scope="col">RECIPIENTS</th>
                    <th scope="col">CREATED AT</th>
                    <th scope="col">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @if ($daily_reports)
                    @foreach ($daily_reports as $daily_report)
                        @livewire('daily-report.daily-report-item', ['daily_report' => $daily_report], key($daily_report->id))
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-center fw-bold">NO DATA</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
