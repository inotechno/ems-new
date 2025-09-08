<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Employee', 'url' => route('employee.index')], ['name' => $type == 'create' ? 'Create' : 'Edit employee ' . $employee->user->name]]], key('breadcrumb'))

    <form wire:submit.prevent="save" class="needs-validation" wire:ignore.self>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">
                            {{ $type == 'create' ? 'Create Employee' : 'Edit Employee ' . $employee->name }}</h4>
                        <div class="row mb-4">
                            <label for="avatar" class="col-form-label col-lg-2">Avatar</label>
                            <div class="col-lg-10">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <!-- Loading indicator -->
                                        <div wire:loading wire:target="avatar" class="spinner-border text-primary"
                                            role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>

                                        @if ($avatar)
                                            <img class="rounded avatar-sm w-100" src="{{ $avatar->temporaryUrl() }}"
                                                alt="New Avatar">
                                        @elseif($avatar_path)
                                            <!-- Image preview (only show when not loading) -->
                                            <img wire:loading.remove wire:target="avatar"
                                                class="rounded avatar-sm w-100" src="{{ $avatar_url }}"
                                                alt="Current Avatar">
                                        @else
                                            <img wire:loading.remove wire:target="avatar"
                                                class="rounded avatar-sm w-100" src="{{ $previewAvatar }}"
                                                alt="Current Avatar">
                                        @endif
                                    </div>

                                    <div class="flex-grow-1">
                                        <input type="file" class="form-control" wire:model.live="avatar">

                                        @error('uploaded_avatar')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="citizen_id" class="col-form-label col-lg-2"> Citizen ID <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input id="citizen_id" name="citizen_id" wire:model="citizen_id" type="text"
                                    class="form-control @error('citizen_id') is-invalid @enderror"
                                    placeholder="Enter Citizen ID ...">
                                @error('citizen_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="name" class="col-form-label col-lg-2"> Name <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input id="name" name="name" wire:model="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Enter Employee Name...">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="username" class="col-form-label col-lg-2"> User Name</label>
                            <div class="col-lg-10">
                                <input id="username" name="username" wire:model="username" type="text"
                                    class="form-control @error('username') is-invalid @enderror"
                                    placeholder="Enter Employee Username...">
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="email" class="col-form-label col-lg-2"> Email <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input id="email" name="email" wire:model="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Enter Employee Email...">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="join_date" class="col-form-label col-lg-2"> Join Date, Leave Remaining</label>
                            <div class="col-lg-4">
                                <input id="join_date" name="join_date" wire:model="join_date" type="date"
                                    class="form-control @error('join_date') is-invalid @enderror"
                                    placeholder="Enter Employee Join Date...">
                                @error('join_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-6">
                                <input type="text" inputmode="numeric" pattern="[0-9\s]{1,3}" maxlength="3"
                                    wire:model="leave_remaining" class="form-control"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">

                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="join_date" class="col-form-label col-lg-2"> Place, Birth Date</label>
                            <div class="col-lg-4 mb-3">
                                <input id="place_of_birth" name="place_of_birth" wire:model="place_of_birth"
                                    type="text" class="form-control @error('place_of_birth') is-invalid @enderror"
                                    placeholder="Enter Place Of Birth...">
                                @error('place_of_birth')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <input id="birth_date" name="birth_date" wire:model="birth_date" type="date"
                                    class="form-control @error('birth_date') is-invalid @enderror"
                                    placeholder="Enter Employee Birth Date...">
                                @error('birth_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- select-gender --}}
                        <div class="row mb-4" wire:ignore>
                            <label for="gender" class="col-form-label col-lg-2">Select Gender <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select
                                    class="form-control select2 @error('gender') is-invalid @enderror select-gender"
                                    id="gender" wire:model="gender" data-placeholder="Select Gender">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>

                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- select-religion --}}
                        <div class="row mb-4" wire:ignore>
                            <label for="religion" class="col-form-label col-lg-2">Select Religion</label>
                            <div class="col-lg-10">
                                <select
                                    class="form-control select2 @error('religion') is-invalid @enderror select-religion"
                                    id="religion" wire:model="religion" data-placeholder="Select Religion">
                                    <option value="">Select Religion</option>
                                    <option value="islam">Islam</option>
                                    <option value="kristen">Kristen</option>
                                    <option value="katholik">Katholik</option>
                                    <option value="hindu">Hindu</option>
                                    <option value="budha">Budha</option>
                                    <option value="konghucu">Konghucu</option>
                                </select>

                                @error('religion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- select-marital-status --}}
                        <div class="row mb-4" wire:ignore>
                            <label for="marital_status" class="col-form-label col-lg-2">Select Marital Status</label>
                            <div class="col-lg-10">
                                <select
                                    class="form-control select2 @error('marital_status') is-invalid @enderror select-marital-status"
                                    id="marital_status" wire:model="marital_status"
                                    data-placeholder="Select Marital Status">
                                    <option value="">Select Marital Status</option>
                                    <option value="single">Single</option>
                                    <option value="married">Married</option>
                                </select>

                                @error('marital_status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="whatsapp_number" class="col-form-label col-lg-2">Whatsapp Number</label>
                            <div class="col-lg-10">
                                <input id="whatsapp_number" name="whatsapp_number" wire:model="whatsapp_number"
                                    type="text" class="form-control @error('whatsapp_number') is-invalid @enderror"
                                    placeholder="Enter Whatsapp Number... Ex: 6289676490...">
                                @error('whatsapp_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @can('update:employee')
                            {{-- select-role --}}
                            <div class="row mb-4" wire:ignore>
                                <label for="selectedRoles" class="col-form-label col-lg-2">Select Roles <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select
                                        class="form-control select2 @error('selectedRoles') is-invalid @enderror select-role"
                                        multiple id="selectedRoles" wire:model="selectedRoles"
                                        data-placeholder="Select Roles">
                                        <option value="">Select Roles</option>
                                        @foreach ($roles as $rl)
                                            <option value="{{ $rl->name }}">{{ $rl->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('selectedRoles')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- select-position --}}
                            <div class="row mb-4" wire:ignore>
                                <label for="position_id" class="col-form-label col-lg-2">Select Position <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select
                                        class="form-control select2 @error('position_id') is-invalid @enderror select-position_id"
                                        id="position_id" wire:model="position_id" data-placeholder="Select Position">
                                        <option value="">Select Position</option>
                                        @foreach ($positions as $position)
                                            <option value="{{ $position->id }}">{{ $position->name }} |
                                                {{ $position->department->name }} |
                                                {{ $position->department->site->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('position_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @endcan

                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Sallary Component</h4>
                        <div class="row mb-4">
                            <label for="basic_salary" class="col-form-label col-lg-4">Basic Salary</label>
                            <div class="col-lg-8">
                                <input id="basic_salary" name="basic_salary" wire:model="basic_salary"
                                    type="number" class="form-control @error('basic_salary') is-invalid @enderror"
                                    placeholder="Enter Basic Salary...">
                                @error('basic_salary')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="allowance_transport" class="col-form-label col-lg-4">Transportation
                                Allowance</label>
                            <div class="col-lg-8">
                                <input id="allowance_transport" name="allowance_transport"
                                    wire:model="allowance_transport" type="number"
                                    class="form-control @error('allowance_transport') is-invalid @enderror"
                                    placeholder="Enter Transportation Allowance...">
                                @error('allowance_transport')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="allowance_meal" class="col-form-label col-lg-4">Meal Allowance</label>
                            <div class="col-lg-8">
                                <input id="allowance_meal" name="allowance_meal" wire:model="allowance_meal"
                                    type="number" class="form-control @error('allowance_meal') is-invalid @enderror"
                                    placeholder="Enter Meal Allowance...">
                                @error('allowance_meal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="allowance_position" class="col-form-label col-lg-4">Position Allowance</label>
                            <div class="col-lg-8">
                                <input id="allowance_position" name="allowance_position"
                                    wire:model="allowance_position" type="number"
                                    class="form-control @error('allowance_position') is-invalid @enderror"
                                    placeholder="Enter Other Allowance...">
                                @error('allowance_position')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="allowance_overtime" class="col-form-label col-lg-4">Overtime Allowance</label>
                            <div class="col-lg-8">
                                <input id="allowance_overtime" name="allowance_overtime"
                                    wire:model="allowance_overtime" type="number"
                                    class="form-control @error('allowance_overtime') is-invalid @enderror"
                                    placeholder="Enter Overtime Allowance...">
                                @error('allowance_overtime')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="allowance_other" class="col-form-label col-lg-4">Other Allowance</label>
                            <div class="col-lg-8">
                                <input id="allowance_other" name="allowance_other" wire:model="allowance_other"
                                    type="number"
                                    class="form-control @error('allowance_other') is-invalid @enderror"
                                    placeholder="Enter Other Allowance...">
                                @error('allowance_other')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="salary_per_day" class="col-form-label col-lg-4">Salary Per Day</label>
                            <div class="col-lg-8">
                                <input id="salary_per_day" name="salary_per_day" wire:model="salary_per_day"
                                    type="number" class="form-control @error('salary_per_day') is-invalid @enderror"
                                    placeholder="Enter Salary Per Day...">
                                @error('salary_per_day')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="row justify-content-end mb-3">
            <div class="col-lg-12">
                @can(['create:employee', 'update:employee'])
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                        wire:target="save">{{ ucfirst($type) }} Employee</button>
                @endcan
            </div>
        </div>

    </form>

    @push('styles')
        <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    @push('js')
        <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>

        <script>
            document.addEventListener('livewire:init', function() {
                $('.select2').select2();

                $('.select-position_id').on('change', function() {
                    Livewire.dispatch('changeSelectForm', ['position_id', this.value]);
                });

                $('.select-religion').on('change', function() {
                    Livewire.dispatch('changeSelectForm', ['religion', this.value]);
                });

                $('.select-marital-status').on('change', function() {
                    Livewire.dispatch('changeSelectForm', ['marital_status', this.value]);
                });

                $('.select-role').on('change', function() {
                    const selected = $(this).val(); // Ambil array dari multiple select
                    Livewire.dispatch('changeSelectForm', {
                        param: 'selectedRoles',
                        value: selected
                    });
                });

                $('.select-gender').on('change', function() {
                    Livewire.dispatch('changeSelectForm', ['gender', this.value]);
                });

                Livewire.on('change-select-form', () => {
                    var position_id = @json($position_id);
                    var religion = @json($religion);
                    var marital_status = @json($marital_status);
                    var selectedRoles = @json($selectedRoles);
                    var gender = @json($gender);

                    console.log(@json($selectedRoles));

                    // console.log(@this.position_id); // Debugging output
                    $('.select-position_id').val(position_id).trigger('change');
                    $('.select-religion').val(religion).trigger('change');
                    $('.select-marital-status').val(marital_status).trigger('change');
                    $('.select-role').val(selectedRoles).trigger('change');
                    $('.select-gender').val(gender).trigger('change');
                });

                Livewire.on('reset-select2', () => {
                    $('.select-position_id').val(null).trigger('change');
                    $('.select-religion').val(null).trigger('change');
                    $('.select-marital-status').val(null).trigger('change');
                    $('.select-role').val(null).trigger('change');
                    $('.select-gender').val(null).trigger('change');
                })
            });
        </script>
    @endpush
</div>
