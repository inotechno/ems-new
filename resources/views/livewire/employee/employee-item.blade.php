    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                {{-- <div class="d-flex align-start mb-3">
                    <div class="flex-grow-1">
                        <span class="badge badge-soft-success">Full Time</span>
                    </div>
                    <button type="button" class="btn btn-light btn-sm like-btn" data-bs-toggle="button"><i
                            class="bx bx-heart"></i></button>
                </div> --}}
                <div class="text-center mb-3">
                    {{-- <img src="assets/images/users/avatar-1.jpg" alt="" class="avatar-sm rounded-circle" /> --}}
                    @if ($user->avatar)
                        <a href="javascript: void(0);" class="d-inline-block" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="{{ $user->name }}">
                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}"
                                class="rounded-circle avatar-sm">
                        </a>
                    @else
                        <a href="javascript: void(0);" class="d-inline-block" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="{{ $user->name }}">
                            <div class="avatar-sm">
                                <span class="avatar-title rounded-circle bg-success text-white font-size-16">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                            </div>
                        </a>
                    @endif
                    <h6 class="font-size-15 mt-3 mb-1">{{ $user->name }}</h6>
                    @foreach ($positions as $position)
                        <p class="mb-0 text-muted">{{ $position->name }}</p>
                    @endforeach
                </div>
                <div class="d-flex mb-3 justify-content-center gap-2 text-muted">
                    <div>
                        <i class='bx bx-envelope align-middle text-primary'></i> {{$user->email}}
                    </div>
                    {{-- <p class="mb-0 text-center"><i class='bx bx-money align-middle text-primary'></i> $38 / hrs</p> --}}
                </div>
                {{-- <div class="hstack gap-2 justify-content-center">
                    <span class="badge badge-soft-secondary">Bootstrap</span>
                    <span class="badge badge-soft-secondary">HTML</span>
                    <span class="badge badge-soft-secondary">CSS</span>
                </div> --}}

                <div class="mt-4 pt-1">
                    <a href="{{ route('employee.detail', ['id' => $employee->id]) }}" class="btn btn-soft-primary d-block">View
                        Profile</a>
                </div>
            </div>
        </div>
    </div>
