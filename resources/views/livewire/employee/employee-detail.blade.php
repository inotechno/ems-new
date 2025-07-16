<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Master Data', 'url' => '/'], ['name' => 'Employee', 'url' => route('employee.index')], ['name' => 'Employee Detail ' . $user->name, 'url' => route('employee.detail', $employee->id)]]], key('breadcrumb'))

    <div class="row">
        <div class="col-xl-5">
            <div class="card overflow-hidden">
                <div class="bg-primary bg-soft">
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary p-3">
                                <h5 class="text-primary">Welcome Back !</h5>
                                <p>It will seem like simplified</p>
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
                            <img src="{{ asset('images/profile-img.png') }}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="avatar-md profile-user-wid mb-4">
                                @if ($user->avatar_url)
                                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
                                        class="img-thumbnail rounded-circle">
                                @else
                                    <span class="avatar-title rounded-circle bg-success text-white font-size-24">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                @endif
                            </div>
                            <h5 class="font-size-15 text-truncate">{{ $user->name }}</h5>
                            <p class="text-muted mb-0 text-truncate">{{ $user->email }}</p>
                        </div>

                        <div class="col-sm-6">
                            <div class="pt-4">

                                <div class="row">
                                    <div class="col-6">
                                        <h5 class="font-size-15">{{ ucfirst($employee->gender) }}</h5>
                                        <p class="text-muted mb-0">Gender</p>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="font-size-15">{{ toIndonesianDate($employee->join_date) }}</h5>
                                        <p class="text-muted mb-0">Join Date</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card -->

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Personal Information</h4>

                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">Full Name :</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Citizen ID :</th>
                                    <td>{{ $employee->citizen_id }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Marital Status :</th>
                                    <td>{{ $employee->marital_status }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Religion :</th>
                                    <td>{{ $employee->religion }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Date of Birth :</th>
                                    <td>{{ toIndonesianDate($employee->date_of_birth) }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Place of Birth :</th>
                                    <td>{{ $employee->place_of_birth }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Leave Remaining :</th>
                                    <td>{{ $employee->leave_remaining }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end card -->

        </div>

        <div class="col-xl">

            <!-- Mini Project Stats-->
            {{-- <div class="row">
                @foreach ($project_status as $key => $value)
                    <div class="col-md-6">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium mb-2">{{ $key }}</p>
                                        <h4 class="mb-0">{{ $value['count'] }}</h4>
                                    </div>

                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                            <span class="avatar-title">
                                                <i class="{{ $value['icon'] }} font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div> --}}
            <!-- end row -->

            <div class="row">
                <div class="col-md-6">
                    @livewire(
                        'component.card-mini',
                        [
                            'title' => 'Total Daily Report',
                            'value' => $totalDailyReport,
                            'badge' => 'Monthly',
                        ],
                        'total-daily-report'
                    )
                </div>

                <div class="col-md-6">
                    @livewire(
                        'component.card-mini',
                        [
                            'title' => 'Total Day Leave',
                            'value' => $totalDayLeaveRequest,
                            'badge' => 'Monthly',
                        ],
                        'total-day-leave-request'
                    )
                </div>

                <div class="col-md-6">
                    @livewire(
                        'component.card-mini',
                        [
                            'title' => 'Total Day Present',
                            'value' => $totalDayPresent,
                            'badge' => 'Monthly',
                        ],
                        'total-day-present'
                    )
                </div>

                <div class="col-md-6">
                    @livewire(
                        'component.card-mini',
                        [
                            'title' => 'Total Amount Financial Request',
                            'value' => $totalAmountFinancialRequest,
                            'badge' => 'Monthly',
                        ],
                        'total-amount-financial-request'
                    )
                </div>
            </div>

            @livewire('component.widget.working-hours-analytic', ['user' => $user])

            {{-- <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">My Projects</h4>
                    <div class="table-responsive">
                        <table class="table table-nowrap table-hover mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">Deadline</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($projects->count() > 0)
                                    @foreach ($projects as $project)
                                        <tr>
                                            <th scope="row">{{ $project->id }}</th>
                                            <td>{{ $project->name }}</td>
                                            <td>{{ $project->start_date }}</td>
                                            <td>{{ $project->end_date }}</td>
                                            <td>{{ $project->status }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">No data</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>

    @push('styles')
        <!-- apexcharts -->
        <script src="{{ asset('libs/apexcharts/apexcharts.min.js') }}"></script>

        <!-- dashboard init -->
        {{-- <script src="{{ asset('js/pages/dashboard.init.js') }}"></script> --}}
    @endpush

    @push('js')
    @endpush
</div>
