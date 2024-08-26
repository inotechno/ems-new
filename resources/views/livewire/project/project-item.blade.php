<tr>
    <td>
        <div class="avatar-sm mx-auto align-self-center d-xl-block d-none">
            <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-16">
                {{ substr($project->name, 0, 1) }}
            </span>
        </div>
    </td>
    <td>
        <h5 class="text-truncate font-size-14"><a href="javascript: void(0);" class="text-dark">{{ $project->name }}</a>
        </h5>
        <p class="text-muted mb-0">{{ $projectManager->name }}</p>
    </td>
    <td>{{ $start_date }}</td>
    <td>{{ $end_date }}</td>
    <td><span class="badge bg-{!! $status['color'] !!}">{{ $status['text'] }}</span></td>
    <td>
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
                                <span class="avatar-title rounded-circle bg-success text-white font-size-16">
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
        </div>
    </td>

    @can('update:project')
    <td>
        <a href="{{ route('project.edit', ['id' => $project->id]) }}" class="btn btn-primary btn-sm waves-effect waves-light"><i class="bx bx-pencil me-1"></i> Edit</a>
    </td>
    @endcan
</tr>
