<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Absent Request', 'url' => route('absent-request.index')], ['name' => $mode == 'Create' ? 'Create' : 'Edit Absent Request ']]], key('breadcrumb'))


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">{{ $mode == 'Create' ? 'Create Absent Request' : 'Edit Absent Request' }}
                    </h4>

                    <form action="" wire:submit.prevent="save" wire:ignore class="needs-validation"
                        id="absent-request-form">
                        <div class="row">
                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="notes" class="mb-3">Note</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" wire:model="notes"
                                        rows="3"></textarea>

                                    @error('notes')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="type_absent" class="mb-3">Type Absent</label>

                                    <div class="d-flex gap-3">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="type_absent"
                                                id="type_absent1" checked="" wire:model="type_absent"
                                                value="sakit">
                                            <label class="form-check-label" for="type_absent1">
                                                Sakit
                                            </label>
                                        </div>

                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="type_absent"
                                                id="type_absent2" wire:model="type_absent" value="izin">
                                            <label class="form-check-label" for="type_absent2">
                                                Izin
                                            </label>
                                        </div>

                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="type_absent"
                                                id="type_absent3" wire:model="type_absent" value="lainnya">
                                            <label class="form-check-label" for="type_absent3">
                                                Lainnya
                                            </label>
                                        </div>
                                    </div>

                                    @error('type_absent')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="recipients" class="form-label">To Recipients</label>
                                    <select name="recipients" wire:model="recipients"
                                        class="form-select select2-multiple" id="" multiple
                                        data-placeholder="Select recipients">
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->user->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('recipients')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md">
                                        <div class="mb-3">
                                            <label for="start_date" class="form-label">Start Date</label>
                                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" wire:model="start_date" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md">
                                        <div class="mb-3">
                                            <label for="end_date" class="form-label">End Date</label>
                                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" wire:model="end_date" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md">
                                        <div class="mb-3">
                                            <label for="total_days" class="form-label">Total Day</label>
                                            <input type="number" class="form-control @error('total_days') is-invalid @enderror" id="total_days" wire:model="total_days" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="mb-3">Date Range</label>
                                        <small class="text-warning mb-3">* Jika hanya 1 tanggal, pilih tanggal tersebut saja</small>
                                        <div id="date-range-picker" class="bootstrap-datepicker-inline"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                                    wire:target="save">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link href="{{ asset('libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
            type="text/css">
        <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

        <style>
            .bootstrap-datepicker-inline .datepicker-inline {
                width: 100% !important;
                display: inline-block !important;
            }

            .datepicker table {
                width: 100%;
            }

            /* CSS untuk tanggal rentang */
            .range-highlight {
                background-color: #bce8f1;
                /* Warna latar belakang biru lembut */
                color: #6379db;
                /* Warna teks biru gelap */
                border-radius: 0% !important;
            }

            /* CSS untuk tanggal aktif dalam rentang */
            .range-highlight.active {
                background-color: #31708f;
                /* Warna latar belakang biru gelap untuk tanggal aktif */
                color: #fff;
                /* Warna teks putih untuk tanggal aktif */
                border-radius: 0%;
            }
        </style>
    @endpush

    @push('js')
        <script src="{{ asset('libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>

        <script>
            document.addEventListener('livewire:init', function() {
                let selectElement = $('.select2-multiple');
                var today = new Date();
                today.setHours(0, 0, 0, 0); // Menetapkan waktu ke 00:00:00 untuk perbandingan yang akurat

                // Initialize the date range picker
                $('#date-range-picker').datepicker({
                    format: 'yyyy-mm-dd', // Format tanggal
                    multidate: 2, // Memungkinkan pengguna untuk memilih dua tanggal
                    todayHighlight: true, // Menyoroti tanggal hari ini
                    todayColor: 'red', // Warna untuk menyoroti tanggal hari ini
                    autoclose: false, // Tidak menutup otomatis setelah pemilihan
                    clearBtn: true, // Tombol untuk menghapus pilihan tanggal
                }).on('changeDate', function(e) {
                    var dates = $(this).datepicker('getDates');
                    if (dates.length > 0) {
                        var date1 = new Date(dates[0].getTime() - dates[0].getTimezoneOffset() * 60000);
                        var date2 = dates[1] ? new Date(dates[1].getTime() - dates[1].getTimezoneOffset() *
                            60000) : date1;

                        if (date2 && date2 < date1) {
                            [date1, date2] = [date2, date1];
                        }

                        var start_date = date1 ? date1.toISOString().substring(0, 10) : '';
                        var end_date = date2 ? date2.toISOString().substring(0, 10) : '';

                        Livewire.dispatch('change-input-form', ['start_date', start_date]);
                        Livewire.dispatch('change-input-form', ['end_date', end_date]);

                        // Highligh date range
                        $('.datepicker-days tbody td').each(function() {
                            var cellDate = new Date($(this).data('date'));
                            if (cellDate >= date1 && cellDate <= date2) {
                                $(this).addClass('range-highlight');
                            } else {
                                $(this).removeClass('range-highlight');
                            }
                        });
                    }
                });

                selectElement.select2({
                    width: '100%',
                }).on('change', function() {
                    let selectedValues = $(this).val();
                    Livewire.dispatch('change-input-form', ['recipients', selectedValues]);
                });

                Livewire.on('set-default-form', () => {
                    var start = new Date(@json($start_date));
                    var end = new Date(@json($end_date));

                    // Set default dates
                    $('#date-range-picker').datepicker('setDates', [start, end]);

                    // Highlight the default range
                    $('.datepicker-days tbody td').each(function() {
                        var cellDate = new Date($(this).data('date'));
                        if (cellDate >= start && cellDate <= end) {
                            $(this).addClass('range-highlight');
                        }
                    });

                    var recipients = @json($recipients);
                    selectElement.val(recipients).trigger('change');
                })
            });
        </script>
    @endpush
</div>
