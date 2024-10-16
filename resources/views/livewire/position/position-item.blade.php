<div class="col-xl-3 col-sm-6">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="flex-grow-1 overflow-hidden">
                    <h5 class="text-truncate font-size-15">
                        <a href="{{ route('position.detail', ['id' => $position->id]) }}"
                            class="text-dark">{{ $position->name }}</a>
                    </h5>
                    <p class="text-muted mb-2">{{ $position->department->name }}</p>
                    <div class="avatar-group">
                        @foreach ($employeesLimit as $employee)
                            @if ($employee->user->avatar)
                                <div class="avatar-group-item" wire:key="avatar-item-{{ $employee->id }}">
                                    <a href="javascript: void(0);" class="d-inline-block" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="{{ $employee->user->name }}">
                                        <img src="{{ $employee->user->avatar }}" alt="{{ $employee->user->name }}"
                                            class="rounded-circle avatar-xs">
                                    </a>
                                </div>
                            @else
                                <div class="avatar-group-item" wire:key="avatar-item-{{ $employee->id }}">
                                    <a href="javascript: void(0);" class="d-inline-block" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="{{ $employee->user->name }}">
                                        <div class="avatar-xs">
                                            <span
                                                class="avatar-title rounded-circle bg-success text-white font-size-16">
                                                {{ strtoupper(substr($employee->user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach

                        @if ($moreCount > $limitDisplay)
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

                        @can('update:position')
                            <div class="avatar-group-item" wire:key="avatar-item-add">
                                <a href="javascript: void(0);" class="d-inline-block"
                                    wire:click="$dispatch('show-modal-add-employee', {position_id: {{ $position->id }}})"
                                    data-bs-toggle="tooltip" data-bs-placement="right" title="Add Employee">
                                    <div class="avatar-xs">
                                        <span class="avatar-title rounded-circle bg-primary text-white font-size-16">
                                            <i class="bx bx-plus"></i>
                                        </span>
                                    </div>
                                </a>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        <div class="px-3 py-2 border-top">
            <ul class="list-inline mb-0 d-flex gap-1 flex-wrap">
                @can('update:position')
                    <li class="list-inline-item">
                        <button type="button" wire:click="$dispatch('set-position', {position_id: {{ $position->id }}})"
                            class="btn btn-primary btn-sm waves-effect waves-light">
                            <i class="mdi mdi-pencil me-1"></i> Edit
                        </button>
                    </li>
                @endcan

                @can('delete:position')
                    <li class="list-inline-item">
                        <button type="button" wire:click="deleteConfirm()"
                            class="btn btn-danger btn-sm waves-effect waves-light">
                            <i class="mdi mdi-delete me-1"></i> Delete
                        </button>
                    </li>
                @endcan

                <li class="list-inline-item ms-auto align-self-center">
                    <a class="text-muted" href="{{ route('position.detail', ['id' => $position->id]) }}">
                        <i class= "bx bx-group me-1"></i> {{ $employees->count() }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
