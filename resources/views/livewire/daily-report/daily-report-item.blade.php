<tr>
    <td>
        @if ($user->avatar_url)
            <a href="javascript: void(0);" class="d-inline-block" data-bs-toggle="tooltip" data-bs-placement="top"
                title="{{ $user->name }}">
                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="rounded-circle avatar-sm">
            </a>
        @else
            <div class="avatar-sm">
                <span class="avatar-title rounded-circle bg-success text-white font-size-16">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </span>
            </div>
        @endif
    </td>
    <td>
        <h5 class="text-truncate font-size-14">
            <a href="javascript: void(0);" class="text-dark">{{ $user->name }}</a>
        </h5>
        <p class="text-muted mb-0">{{ $user->email }}</p>
    </td>
    <td>
        <div class="d-flex flex-column">
            <span class="p-2">{{ $daily_report->date }}</span>
        </div>
    </td>
    <td>
        <div class="d-flex flex-column">
            <p>{{ $daily_report->short_description }}</p>
        </div>
    </td>
    <td>
        <div class="d-flex flex-column">
            <p>{{ $daily_report->created_at->format('d M, Y') }}</p>
        </div>
    </td>
</tr>
