<div>
    <div class="table-responsive">
        <table class="table project-list-table table-nowrap align-middle table-borderless">
            <thead>
                <tr>
                    <th scope="col" style="width: 100px">#</th>
                    <th scope="col">NAME</th>
                    <th scope="col">CHECK IN</th>
                    <th scope="col">CHECK OUT</th>
                    <th scope="col">WORKING DURATION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $attendance)
                    @livewire('attendance.attendance-item', ['attendance' => $attendance], key($attendance['id']))
                @endforeach
            </tbody>
        </table>
    </div>
</div>
