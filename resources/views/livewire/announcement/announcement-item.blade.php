<div class="col-xl-4 col-sm-6">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="flex-grow-1 overflow-hidden">
                    <h5 class="text-truncate font-size-15">
                        <a href="javascript: void(0);" class="text-dark">
                            {{ $title }}
                        </a>
                    </h5>
                    <p class="text-muted mb-4">
                        {{ $description_excerpt }}
                    </p>
                    <div class="avatar-group">
                        @foreach ($usersLimit as $user)
                            @if ($user->avatar)
                                <div class="avatar-group-item" wire:key="avatar-item-{{ $user->id }}">
                                    <a href="javascript: void(0);" class="d-inline-block" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="{{ $user->name }}">
                                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}"
                                            class="rounded-circle avatar-xs">
                                    </a>
                                </div>
                            @else
                                <div class="avatar-group-item" wire:key="avatar-item-{{ $user->id }}">
                                    <a href="javascript: void(0);" class="d-inline-block" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="{{ $user->name }}">
                                        <div class="avatar-xs">
                                            <span
                                                class="avatar-title rounded-circle bg-success text-white font-size-16">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach

                        @if ($recipients->count() > $limitDisplay)
                            <div class="avatar-group-item" wire:key="avatar-item-more">
                                <a href="javascript: void(0);" class="d-inline-block">
                                    <div class="avatar-xs">
                                        <span class="avatar-title rounded-circle bg-secondary text-white font-size-16">
                                            +{{ $moreCount }}
                                        </span>
                                    </div>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="px-4 py-3 border-top">
            <ul class="list-inline mb-0">
                <li class="list-inline-item me-3">
                    <i class= "bx bx-calendar me-1"></i> {{ $created_at }}
                </li>
                <li class="list-inline-item me-3">
                    <i class= "bx bx-group me-1"></i> {{ $recipients->count() }} Recipients
                </li>
            </ul>
        </div>
        <div class="card-footer bg-transparent border-top">
            <li class="list-inline-item me-3">
                <a href="{{ route('announcement.edit', $slug) }}" class="btn btn-warning btn-sm align-middle"><i
                        class="bx bx-pencil"></i> Edit</a>
                <a href="{{ route('announcement.detail', $slug) }}" class="btn btn-primary btn-sm ms-2 align-middle"><i
                        class="bx bx-show"></i> Detail</a>
                <a href="javascript:void(0)" class="btn btn-danger btn-sm ms-2 align-middle"
                    wire:click="deleteConfirm({{ $slug }})"><i class="bx bx-trash"></i> Delete</a>
                {{-- Resend Button --}}
                <a href="javascript:void(0)" class="btn btn-info btn-sm ms-2 align-middle"
                    wire:click="resend({{ $slug }})"><i class="bx bx-repeat"></i> Resend</a>
            </li>
        </div>
    </div>
</div>
