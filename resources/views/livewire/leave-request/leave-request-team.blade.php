<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Leave Request', 'url' => route('leave-request.index')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <label for="form-label">Search</label>
                            <input type="text" class="form-control" wire:model.live="search" placeholder="Search ...">
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body" wire:ignore>
                            <label for="employees">Select Employee</label>
                            <select class="form-control select2-multiple" id="employees"
                                data-placeholder="Select Employee" wire:model="employee_id" multiple>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">

                            <label for="form-label">Date</label>
                            <div class="input-daterange input-group" id="leave-request-inputgroup"
                                data-provide="datepicker" data-date-format="yyyy-mm-dd"
                                data-date-container='#leave-request-inputgroup' data-date-autoclose="true">
                                <input type="text" class="form-control @error('start_date') is-invalid @enderror"
                                    wire:model="start_date" placeholder="Start Date" name="start" />
                                @error('start_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input type="text" class="form-control @error('end_date') is-invalid @enderror"
                                    wire:model="end_date" placeholder="End Date" name="end" />
                                @error('end_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-12 text-end mb-3">
                    <button class="btn btn-warning mt-2" wire:click="resetFilter" wire:loading.attr="disabled">Reset
                        Filter</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            @livewire('leave-request.leave-request-list', ['leave_requests' => $leave_requests->getCollection()], key('leave-request-list'))
        </div>

        {{ $leave_requests->links() }}
    </div>

    @push('styles')
        <link href="{{ asset('libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
        <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    @push('js')
        <script src="{{ asset('libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
        <script>
            document.addEventListener('livewire:init', function() {
                initDatePicker();

                let selectElement = $('.select2-multiple');
                initSelect2();

                function initSelect2() {
                    selectElement.select2({
                        width: '100%',
                    }).on('change', function(e) {
                        let selectedValues = $(this).val();
                        @this.set('employee_id', selectedValues);
                    });
                }

                function initDatePicker() {
                    $('#attendance-inputgroup').datepicker({
                        format: 'yyyy-mm-dd',
                        autoclose: true,
                        todayHighlight: true,
                        inputs: $('#attendance-inputgroup').find('input')
                    }).on('changeDate', function(e) {
                        // Update the Livewire property when date is selected
                        let startDate = $('#attendance-inputgroup').find('input[name="start"]').val();
                        let endDate = $('#attendance-inputgroup').find('input[name="end"]').val();

                        @this.set('start_date', startDate);
                        @this.set('end_date', endDate);
                    });
                }

            });
        </script>
    @endpush
</div>
