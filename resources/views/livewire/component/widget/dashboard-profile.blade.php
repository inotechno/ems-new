<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-4">
                <div class="d-flex">
                    <div class="flex-shrink-0 me-2">
                        <img src="{{ $avatar_url ?? asset('images/users/avatar-1.jpg') }}" alt=""
                            class="avatar-md rounded-circle img-thumbnail">
                    </div>
                    <div class="flex-grow-1 align-self-center">
                        <div class="text-muted">
                            <p class="mb-2">Welcome to {{ config('setting.app_name') }}</p>
                            <h5 class="mb-1">{{ $name }}</h5>
                            <p class="mb-0">{{ $position }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg align-self-center">
                <div class="text-lg-center mt-4 mt-lg-0">
                    <div class="row">
                        <div class="col-md-5">
                            <div>
                                <p class="text-muted text-truncate mb-2">Today</p>
                                <h5 class="mb-0">{{ date('l, d F Y') }}</h5>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div>
                                <p class="text-muted text-truncate mb-2">Time</p>
                                <h5 class="mb-0" id="clock">{{ date('H:i:s') }}</h5>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div>
                                <p class="text-muted text-truncate mb-2">Total Employee</p>
                                <h5 class="mb-0">{{ $totalEmployee }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-1 d-none d-lg-block">
                <div class="clearfix mt-4 mt-lg-0">
                    <a href="{{ route('profile.index') }}" class="btn btn-primary btn-sm">
                        <i class="mdi mdi-account-edit-outline"></i> Profile
                    </a>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            const time = now.toLocaleTimeString('id-ID', {
                hour12: false
            });
            document.getElementById('clock').textContent = time;
        }

        setInterval(updateClock, 1000);
        updateClock(); // Initial call
    </script>
</div>
