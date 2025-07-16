<div>
    <div class="table-responsive">
        <table class="table project-list-table table-nowrap align-middle table-borderless">
            <thead>
                <tr>
                    <th scope="col" style="width: 100px">#</th>
                    <th scope="col">USER</th>
                    <th scope="col">TIMESTAMP</th>
                    <th scope="col">DESCRIPTION</th>
                </tr>
            </thead>
            <tbody>
                @if ($activities)
                    @foreach ($activities as $activity)
                        @livewire('activity.activity-item', ['activity' => $activity, 'iteration' => $loop->iteration], key($activity->id))
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center fw-bold">NO DATA</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
