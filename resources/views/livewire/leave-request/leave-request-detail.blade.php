<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Absent Request', 'url' => route('absent-request.index')], ['name' => 'Detail Absent Request ']]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Recipients</h4>
                    @foreach ($recipientsWithStatus as $item)
                        <p class="{{ $item['bgClass'] }} text-white p-2">
                            {{ $item['recipient']->employee->user->name }} : {{ ucfirst($item['status']) }} at
                            {{ $item['created_at'] ?? '-' }}
                        </p>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Date</h4>
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Notes</h4>
                    <p>{{ $leave_request->notes }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Detail</h4>
                    <div class="row">
                        <div class="col-lg">
                            <label for="type_leave" class="mb-3">Leave Period</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" value="{{ $leave_period }}">
                                <span class="input-group-text bg-primary text-white" id="option-date">Hari</span>
                            </div>
                        </div>

                        <div class="col-lg">
                            <label for="type_leave" class="mb-3">Already Taken</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" wire:model="leave_taken" readonly>
                                <span class="input-group-text bg-primary text-white" id="option-date">Hari</span>
                            </div>
                        </div>

                        <div class="col-lg">
                            <label for="type_leave" class="mb-3">Remaining</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" wire:model="leave_remaining" readonly>
                                <span class="input-group-text bg-primary text-white" id="option-date">Hari</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('styles')
        <link href="{{ asset('libs/%40fullcalendar/core/main.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('libs/%40fullcalendar/daygrid/main.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('libs/%40fullcalendar/bootstrap/main.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('libs/%40fullcalendar/timegrid/main.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    @push('js')
        <script src="{{ asset('libs/jquery-ui-dist/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('libs/%40fullcalendar/core/main.min.js') }}"></script>
        <script src="{{ asset('libs/%40fullcalendar/bootstrap/main.min.js') }}"></script>
        <script src="{{ asset('libs/%40fullcalendar/daygrid/main.min.js') }}"></script>
        <script src="{{ asset('libs/%40fullcalendar/timegrid/main.min.js') }}"></script>
        <script src="{{ asset('libs/%40fullcalendar/interaction/main.min.js') }}"></script>

        <script>
            document.addEventListener('livewire:init', function() {
                var startDate = @json($start_date); // Format: 'YYYY-MM-DD'
                var endDate = @json($end_date); // Format: 'YYYY-MM-DD'

                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    defaultView: 'dayGridMonth',
                    plugins: ["bootstrap", "interaction", "dayGrid", "timeGrid"],
                    header: false,
                    editable: false, // Nonaktifkan interaksi
                    selectable: false, // Nonaktifkan pemilihan tanggal
                    selectMirror: false, // Nonaktifkan pemilihan tanggal
                    displayEventTime: false, // Nonaktifkan menampilkan waktu
                    displayEventEnd: false, // Nonaktifkan menampilkan Waktu
                    events: [{
                        start: startDate,
                        end: endDate,
                        display: 'background', // Tampilkan rentang sebagai latar belakang
                        backgroundColor: '#007bff', // Warna latar belakang rentang
                        borderColor: '#007bff'
                    }],
                    themeSystem: 'bootstrap',
                });
                calendar.render();
            });
        </script>
    @endpush
</div>
