<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Dashboard', 'url' => '/']]])

    <div class="row">
        <div class="col-md-12">
            @livewire('component.widget.dashboard-profile')
        </div>
    </div>

    @unlessrole('Director')
        <div class="row">
            <div class="col-md-3">
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

            <div class="col-md-3">
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

            <div class="col-md-3">
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

            <div class="col-md-3">
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
    @else
        <div class="row">
            <div class="col-md-2">
                @livewire(
                    'component.card-mini',
                    [
                        'title' => 'Total Daily Report',
                        'value' => $totalDailyReportYesterday,
                        'badge' => 'Yesterday',
                    ],
                    'total-daily-report-yesterday'
                )
            </div>

            <div class="col-md-2">
                @livewire(
                    'component.card-mini',
                    [
                        'title' => 'Total Leave',
                        'value' => $totalLeaveRequestYesterday,
                        'badge' => 'Yesterday',
                    ],
                    'total-day-leave-request-yesterday'
                )
            </div>

            <div class="col-md-2">
                @livewire(
                    'component.card-mini',
                    [
                        'title' => 'Total Present',
                        'value' => $totalPresentYesterday,
                        'badge' => 'Yesterday',
                    ],
                    'total-day-present-yesterday'
                )
            </div>

            <div class="col-md-2">
                @livewire(
                    'component.card-mini',
                    [
                        'title' => 'Total Absent',
                        'value' => $totalAbsentRequestYesterday,
                        'badge' => 'Yesterday',
                    ],
                    'total-day-absent-request-yesterday'
                )
            </div>
             <div class="col-md-2">
                @livewire(
                    'component.card-mini',
                    [
                        'title' => 'Total Sick',
                        'value' => $totalSickAsbentRequestYesterday,
                        'badge' => 'Yesterday',
                    ],
                    'total-day-absent-request-yesterday'
                )
            </div>
            <div class="col-md-2">
                @livewire(
                    'component.card-mini',
                    [
                        'title' => 'Total Visit',
                        'value' => $totalVisitYesterday,
                        'badge' => 'Yesterday',
                    ],
                    'total-visit-yesterday'
                )
            </div>
        </div>
    @endunlessrole

    @hasrole('Employee')
        <div class="row">
            <div class="col-md-12">
                @livewire('component.widget.working-hours-analytic', ['user' => $authUser])
            </div>
        </div>

        <div class="row">
            <div class="col-md">
                @livewire('component.widget.working-day-analytic')
            </div>

            <div class="col-md">
                @livewire('component.widget.activity-card')
            </div>
        </div>
    @endhasrole

    @can('view:attendance-all')
        <div class="row">
            <div class="col-xl-6">
                @livewire('component.widget.table.working-hours-analytics')
            </div>
        </div>
    @endcan

    {{-- <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Social Source</h4>
                    <div class="text-center">
                        <div class="avatar-sm mx-auto mb-4">
                            <span class="avatar-title rounded-circle bg-primary bg-soft font-size-24">
                                <i class="mdi mdi-facebook text-primary"></i>
                            </span>
                        </div>
                        <p class="font-16 text-muted mb-2"></p>
                        <h5><a href="javascript: void(0);" class="text-dark">Facebook - <span
                                    class="text-muted font-16">125 sales</span> </a></h5>
                        <p class="text-muted">Maecenas nec odio et ante tincidunt tempus. Donec vitae
                            sapien ut libero venenatis faucibus tincidunt.</p>
                        <a href="javascript: void(0);" class="text-primary font-16">Learn more <i
                                class="mdi mdi-chevron-right"></i></a>
                    </div>
                    <div class="row mt-4">
                        <div class="col-4">
                            <div class="social-source text-center mt-3">
                                <div class="avatar-xs mx-auto mb-3">
                                    <span class="avatar-title rounded-circle bg-primary font-size-16">
                                        <i class="mdi mdi-facebook text-white"></i>
                                    </span>
                                </div>
                                <h5 class="font-size-15">Facebook</h5>
                                <p class="text-muted mb-0">125 sales</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="social-source text-center mt-3">
                                <div class="avatar-xs mx-auto mb-3">
                                    <span class="avatar-title rounded-circle bg-info font-size-16">
                                        <i class="mdi mdi-twitter text-white"></i>
                                    </span>
                                </div>
                                <h5 class="font-size-15">Twitter</h5>
                                <p class="text-muted mb-0">112 sales</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="social-source text-center mt-3">
                                <div class="avatar-xs mx-auto mb-3">
                                    <span class="avatar-title rounded-circle bg-pink font-size-16">
                                        <i class="mdi mdi-instagram text-white"></i>
                                    </span>
                                </div>
                                <h5 class="font-size-15">Instagram</h5>
                                <p class="text-muted mb-0">104 sales</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Activity</h4>
                    <ul class="verti-timeline list-unstyled">
                        <li class="event-list">
                            <div class="event-timeline-dot">
                                <i class="bx bx-right-arrow-circle font-size-18"></i>
                            </div>
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <h5 class="font-size-14">22 Nov <i
                                            class="bx bx-right-arrow-alt font-size-16 text-primary align-middle ms-2"></i>
                                    </h5>
                                </div>
                                <div class="flex-grow-1">
                                    <div>
                                        Responded to need “Volunteer Activities
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="event-list">
                            <div class="event-timeline-dot">
                                <i class="bx bx-right-arrow-circle font-size-18"></i>
                            </div>
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <h5 class="font-size-14">17 Nov <i
                                            class="bx bx-right-arrow-alt font-size-16 text-primary align-middle ms-2"></i>
                                    </h5>
                                </div>
                                <div class="flex-grow-1">
                                    <div>
                                        Everyone realizes why a new common language would be
                                        desirable... <a href="javascript: void(0);">Read more</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="event-list active">
                            <div class="event-timeline-dot">
                                <i class="bx bxs-right-arrow-circle font-size-18 bx-fade-right"></i>
                            </div>
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <h5 class="font-size-14">15 Nov <i
                                            class="bx bx-right-arrow-alt font-size-16 text-primary align-middle ms-2"></i>
                                    </h5>
                                </div>
                                <div class="flex-grow-1">
                                    <div>
                                        Joined the group “Boardsmanship Forum”
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="event-list">
                            <div class="event-timeline-dot">
                                <i class="bx bx-right-arrow-circle font-size-18"></i>
                            </div>
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <h5 class="font-size-14">12 Nov <i
                                            class="bx bx-right-arrow-alt font-size-16 text-primary align-middle ms-2"></i>
                                    </h5>
                                </div>
                                <div class="flex-grow-1">
                                    <div>
                                        Responded to need “In-Kind Opportunity”
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="text-center mt-4"><a href="javascript: void(0);"
                            class="btn btn-primary waves-effect waves-light btn-sm">View More <i
                                class="mdi mdi-arrow-right ms-1"></i></a></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Top Cities Selling Product</h4>

                    <div class="text-center">
                        <div class="mb-4">
                            <i class="bx bx-map-pin text-primary display-4"></i>
                        </div>
                        <h3>1,456</h3>
                        <p>San Francisco</p>
                    </div>

                    <div class="table-responsive mt-4">
                        <table class="table align-middle table-nowrap">
                            <tbody>
                                <tr>
                                    <td style="width: 30%">
                                        <p class="mb-0">San Francisco</p>
                                    </td>
                                    <td style="width: 25%">
                                        <h5 class="mb-0">1,456</h5>
                                    </td>
                                    <td>
                                        <div class="progress bg-transparent progress-sm">
                                            <div class="progress-bar bg-primary rounded" role="progressbar"
                                                style="width: 94%" aria-valuenow="94" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="mb-0">Los Angeles</p>
                                    </td>
                                    <td>
                                        <h5 class="mb-0">1,123</h5>
                                    </td>
                                    <td>
                                        <div class="progress bg-transparent progress-sm">
                                            <div class="progress-bar bg-success rounded" role="progressbar"
                                                style="width: 82%" aria-valuenow="82" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="mb-0">San Diego</p>
                                    </td>
                                    <td>
                                        <h5 class="mb-0">1,026</h5>
                                    </td>
                                    <td>
                                        <div class="progress bg-transparent progress-sm">
                                            <div class="progress-bar bg-warning rounded" role="progressbar"
                                                style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- end row -->

    @push('styles')
        <!-- apexcharts -->
        <script src="{{ asset('libs/apexcharts/apexcharts.min.js') }}"></script>
        <link href="{{ asset('libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
        <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- dashboard init -->
        {{-- <script src="{{ asset('js/pages/dashboard.init.js') }}"></script> --}}
    @endpush

    @push('js')
        <script src="{{ asset('libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    @endpush
</div>
