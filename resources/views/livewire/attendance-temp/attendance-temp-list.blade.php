<div>
    <div class="table-responsive">
        <table class="table project-list-table table-nowrap align-middle table-borderless">
            <thead>
                <tr>
                    <th scope="col" style="width: 100px">#</th>
                    <th scope="col">NAME</th>
                    <th scope="col">TIMESTAMP</th>
                    <th scope="col">DISTANCE</th>
                    <th scope="col">LOCATION</th>
                    <th scope="col">NOTES</th>
                    <th scope="col">ACTION</th>
                </tr>
            </thead>
            <tbody id="attendance-lists">
                @if ($attendances)
                    @foreach ($attendances as $attendance)
                        @livewire('attendance-temp.attendance-temp-item', ['attendance' => $attendance], key($attendance['id']))
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center fw-bold">NO DATA</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    @push('js')
        <script>
            document.addEventListener('livewire:init', function() {
                $('#attendance-lists').on('click', '.read-more-in', function(e) {
                    var notes = $(this).data('notes');
                    var id = $(this).data('id');

                    $('#notes-in-' + id).html(notes);
                    $(this).html('Show Less');
                    $(this).removeClass('read-more-in');
                    $(this).addClass('show-less-in');
                })

                $('#attendance-lists').on('click', '.read-more-out', function(e) {
                    var notes = $(this).data('notes');
                    var id = $(this).data('id');

                    $('#notes-out-' + id).html(notes);
                    $(this).html('Show Less');
                    $(this).removeClass('read-more-out');
                    $(this).addClass('show-less-out');
                })

                $('#attendance-lists').on('click', '.show-less-in', function(e) {
                    var notes = $(this).data('excerpt');
                    var id = $(this).data('id');

                    $('#notes-in-' + id).html(notes);

                    $(this).html('Show More');
                    $(this).removeClass('show-less-in');
                    $(this).addClass('read-more-in');
                })

                $('#attendance-lists').on('click', '.show-less-out', function(e) {
                    var notes = $(this).data('excerpt');
                    var id = $(this).data('id');

                    $('#notes-out-' + id).html(notes);

                    $(this).html('Show More');
                    $(this).removeClass('show-less-out');
                    $(this).addClass('read-more-out');
                })
            });
        </script>
    @endpush
</div>
