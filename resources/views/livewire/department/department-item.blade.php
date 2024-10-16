<div class="col-xl-3 col-sm-6">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="flex-grow-1 overflow-hidden">
                    <h5 class="text-truncate font-size-15">
                        <a href="{{ route('department.detail', ['id' => $department->id]) }}"
                            class="text-dark">{{ $department->name }}</a>
                    </h5>
                    <p class="text-muted mb-0">{{ $department->supervisor?->user->name }}</p>
                    <p class="text-muted mb-2">{{ $site->name }}</p>
                    <div class="avatar-group">
                        @foreach ($employees->take($limitDisplay) as $employee)
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

                        @if ($employees->count() > $limitDisplay)
                            <div class="avatar-group-item" wire:key="avatar-item-more">
                                <a href="javascript: void(0);" class="d-inline-block">
                                    <div class="avatar-xs">
                                        <span class="avatar-title rounded-circle bg-secondary text-white font-size-16">
                                            +{{ $employees->count() - $limitDisplay }}
                                        </span>
                                    </div>
                                </a>
                            </div>
                        @endif

                        {{-- <div class="avatar-group-item" wire:key="avatar-item-add">
                            <a href="javascript: void(0);" class="d-inline-block"
                                wire:click="$dispatch('show-modal-add-employee', {department_id: {{ $department->id }}})"
                                data-bs-toggle="tooltip" data-bs-placement="right" title="Add Employee">
                                <div class="avatar-xs">
                                    <span class="avatar-title rounded-circle bg-primary text-white font-size-16">
                                        <i class="bx bx-plus"></i>
                                    </span>
                                </div>
                            </a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="px-3 py-2 border-top">
            <ul class="list-inline mb-0 d-flex gap-1 flex-wrap">
                @can('update:department')
                    <li class="list-inline-item">
                        <button type="button"
                            wire:click="$dispatch('set-department', {department_id: {{ $department->id }}})"
                            class="btn btn-primary btn-sm waves-effect waves-light">
                            <i class="mdi mdi-pencil me-1"></i> Edit
                        </button>
                    </li>
                @endcan

                @can('delete:department')
                    <li class="list-inline-item">
                        <button type="button" wire:click="deleteConfirm()"
                            class="btn btn-danger btn-sm waves-effect waves-light">
                            <i class="mdi mdi-delete me-1"></i> Delete
                        </button>
                    </li>
                @endcan

                <li class="list-inline-item ms-auto align-self-center">
                    <a class="text-muted" href="{{ route('department.detail', ['id' => $department->id]) }}">
                        <i class= "bx bx-group me-1"></i> {{ $employees->count() }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
