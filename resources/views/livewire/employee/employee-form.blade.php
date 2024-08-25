<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Employee', 'url' => route('employee.index')], ['name' => $type == 'create' ? 'Create' : 'Edit employee ' . $employee->user->name]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">
                        {{ $type == 'create' ? 'Create Employee' : 'Edit Employee ' . $employee->name }}</h4>
                    <form wire:submit.prevent="save" class="needs-validation" wire:ignore.self>
                        <div class="row mb-4">
                            <label for="citizen_id" class="col-form-label col-lg-2"> Citizen ID</label>
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
                            <label for="name" class="col-form-label col-lg-2"> Name</label>
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
                            <label for="email" class="col-form-label col-lg-2"> Email</label>
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
                            <label for="gender" class="col-form-label col-lg-2">Select Gender</label>
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

                        {{-- select-role --}}
                        <div class="row mb-4" wire:ignore>
                            <label for="role" class="col-form-label col-lg-2">Select Role</label>
                            <div class="col-lg-10">
                                <select class="form-control select2 @error('role') is-invalid @enderror select-role"
                                    id="role" wire:model="role" data-placeholder="Select Role">
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $rl)
                                        <option value="{{ $rl->name }}">{{ $rl->name }}</option>
                                    @endforeach
                                </select>

                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- select-position --}}
                        <div class="row mb-4" wire:ignore>
                            <label for="position_id" class="col-form-label col-lg-2">Select Position</label>
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

                        <div class="row justify-content-end">
                            <div class="col-lg-10">
                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                                    wire:target="save">{{ ucfirst($type) }} Employee</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

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
                    Livewire.dispatch('changeSelectForm', ['role', this.value]);
                });

                $('.select-gender').on('change', function() {
                    Livewire.dispatch('changeSelectForm', ['gender', this.value]);
                });

                Livewire.on('change-select-form', () => {
                    var position_id = @json($position_id);
                    var religion = @json($religion);
                    var marital_status = @json($marital_status);
                    var role = @json($role);
                    var gender = @json($gender);

                    console.log(@json($role));

                    // console.log(@this.position_id); // Debugging output
                    $('.select-position_id').val(position_id).trigger('change');
                    $('.select-religion').val(religion).trigger('change');
                    $('.select-marital-status').val(marital_status).trigger('change');
                    $('.select-role').val(role).trigger('change');
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
