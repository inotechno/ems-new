<div>
    {{-- Breadcrumb --}}
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Master Data', 'url' => '/'], ['name' => 'Department', 'url' => route('department.index')], ['name' => 'Department Detail ' . $department->name, 'url' => route('department.detail', $department->id)]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-md mx-auto">
                                        <span
                                            class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-24">
                                            {{ substr($department->name, 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1 align-self-center">
                                    <div class="text-muted">
                                        <h5 class="mb-1">{{ $department->name }}</h5>
                                        <p class="mb-0">{{ $site->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 align-self-center">
                            <div class="text-lg-center mt-4 mt-lg-0">
                                <div class="row">
                                    <div class="col-9">
                                        <div>
                                            <p class="text-muted text-truncate mb-2">Supervisor</p>
                                            <h5 class="mb-0">{{ $supervisor->user->name }}</h5>
                                        </div>
                                    </div>

                                    <div class="col-3">
                                        <div>
                                            <p class="text-muted text-truncate mb-2">Total Employee</p>
                                            <h5 class="mb-0">{{ $employees->count() }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-2 d-none d-lg-block align-self-center text-end">
                            <button class="btn btn-primary" type="button">
                                <i class="bx bx-save align-middle me-1"></i> Update
                            </button>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
            </div>
        </div>
    </div>
</div>
