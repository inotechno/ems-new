<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Project', 'url' => route('project.index')], ['name' => $type == 'create' ? 'Create' : 'Edit Project ' . $project->name]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">
                        {{ $type == 'create' ? 'Create Project' : 'Edit Project ' . $project->name }}</h4>
                    <form wire:submit.prevent="save" class="needs-validation" wire:ignore.self>
                        <div class="row mb-4">
                            <label for="projectname" class="col-form-label col-lg-2">Project Name</label>
                            <div class="col-lg-10">
                                <input id="projectname" name="projectname" wire:model="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Enter Project Name...">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="projectdesc" class="col-form-label col-lg-2">Project Description</label>
                            <div class="col-lg-10">
                                <textarea class="form-control @error('description') is-invalid @enderror" wire:model="description" id="projectdesc"
                                    rows="3" placeholder="Enter Project Description..."></textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label class="col-form-label col-lg-2">Project Date</label>
                            <div class="col-lg-10">
                                <div class="input-daterange input-group" id="project-date-inputgroup"
                                    data-provide="datepicker" data-date-format="yyyy-mm-dd"
                                    data-date-container='#project-date-inputgroup' data-date-autoclose="true">
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

                        <div class="row mb-4" wire:ignore>
                            <label for="status" class="col-form-label col-lg-2">Select Project Manager</label>
                            <div class="col-lg-10">
                                <select class="form-control @error('employee_id') is-invalid @enderror" id="employee_id"
                                    wire:model="employee_id" data-placeholder="Select Project Manager">
                                    <option value="">Select Project Manager</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->user->name }}</option>
                                    @endforeach
                                </select>

                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4" wire:ignore>
                            <label for="employees" class="col-form-label col-lg-2">Employees</label>
                            <div class="col-lg-10">
                                <select
                                    class="form-control select2-multiple @error('selectedEmployees') is-invalid @enderror"
                                    id="employees" wire:model="selectedEmployees" multiple
                                    data-placeholder="Select Employee">
                                    <option value="">Select Employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->id }} -
                                            {{ $employee->user->name }}</option>
                                    @endforeach
                                </select>

                                @error('selectedEmployees')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4" wire:ignore>
                            <label for="status" class="col-form-label col-lg-2">Status</label>
                            <div class="col-lg-10">
                                <select class="form-control @error('status') is-invalid @enderror" id="status"
                                    wire:model="status" data-placeholder="Select Status">
                                    <option value="">Select Status</option>
                                    <option value="not_started">Not Started</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="on_hold">On Hold</option>
                                </select>

                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-lg-10">
                                <button type="submit" class="btn btn-primary">Create Project</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
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

                function initDatePicker() {
                    $('#project-date-inputgroup').datepicker({
                        format: 'yyyy-mm-dd',
                        autoclose: true,
                        todayHighlight: true,
                        inputs: $('#project-date-inputgroup').find('input')
                    }).on('changeDate', function(e) {
                        // Update the Livewire property when date is selected
                        let startDate = $('#project-date-inputgroup').find('input[name="start"]').val();
                        let endDate = $('#project-date-inputgroup').find('input[name="end"]').val();

                        @this.set('start_date', startDate);
                        @this.set('end_date', endDate);
                    });
                }

                $('#status').select2({
                    width: '100%',
                }).on('change', function() {
                    Livewire.dispatch('changeSelectForm', ['status', this.value]);
                    // @this.set('status', this.value);
                });

                $('#employee_id').select2({
                    width: '100%',
                }).on('change', function() {
                    Livewire.dispatch('changeSelectForm', ['employee_id', this.value]);
                    // @this.set('employee_id', this.value);
                });

                selectElement.select2({
                    width: '100%',
                }).on('change', function() {
                    let selectedValues = $(this).val();
                    Livewire.dispatch('changeSelectForm', ['selectedEmployees', selectedValues]);

                    // @this.set('selectedEmployees', selectedValues);
                });

                Livewire.on('change-select-form', () => {
                    var status = @json($status);
                    var employee_id = @json($employee_id);
                    var selectedEmployees = @json($selectedEmployees);

                    $('#status').val(status).trigger('change');
                    $('#employee_id').val(employee_id).trigger('change');
                    selectElement.val(selectedEmployees).trigger('change');
                });
            });
        </script>
    @endpush
</div>
