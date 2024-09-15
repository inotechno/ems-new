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
            <tbody id="visit-lists">
                @if ($visits)
                    @foreach ($visits as $visit)
                        @livewire('visit.visit-item', ['visit' => $visit], key($visit['id']))
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center fw-bold">NO DATA</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    @push('js')
        <script>
            document.addEventListener('livewire:init', function() {
                $('#visit-lists').on('click', '.read-more-in', function(e) {
                    var notes = $(this).data('notes');
                    var id = $(this).data('id');

                    $('#notes-in-' + id).html(notes);
                    $(this).html('Show Less');
                    $(this).removeClass('read-more-in');
                    $(this).addClass('show-less-in');
                })

                $('#visit-lists').on('click', '.read-more-out', function(e) {
                    var notes = $(this).data('notes');
                    var id = $(this).data('id');

                    $('#notes-out-' + id).html(notes);
                    $(this).html('Show Less');
                    $(this).removeClass('read-more-out');
                    $(this).addClass('show-less-out');
                })

                $('#visit-lists').on('click', '.show-less-in', function(e) {
                    var notes = $(this).data('excerpt');
                    var id = $(this).data('id');

                    $('#notes-in-' + id).html(notes);

                    $(this).html('Show More');
                    $(this).removeClass('show-less-in');
                    $(this).addClass('read-more-in');
                })

                $('#visit-lists').on('click', '.show-less-out', function(e) {
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
