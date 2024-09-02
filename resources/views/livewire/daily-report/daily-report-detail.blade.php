<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Daily Report', 'url' => route('daily-report.index')], ['name' => 'Daily Report Detail ' . $employee->user->name . ' ' . $date, 'url' => route('daily-report.detail', $daily_report->id)]]], key('breadcrumb'))

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4>Date</h4>
                    <p class="mb-0">{{ $date }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4>Recipients</h4>
                    @foreach ($recipients as $recipient)
                        <p class="mb-0">{{ $recipient->employee->user->name }}</p>
                    @endforeach
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4>Read By</h4>
                    @if ($reads->count() > 0)
                        @foreach ($reads as $read)
                            <p class="mb-0">{{ $read->employee->user->name }}</p>
                        @endforeach
                    @else
                        <p class="mb-0">No one</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Description</h4>
                    {!! $daily_report->description !!}
                </div>
            </div>
        </div>
    </div>
</div>
