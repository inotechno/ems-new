<tr>
    <td>
        @if ($employee['avatar_url'])
            <a href="javascript: void(0);" class="d-inline-block" data-bs-toggle="tooltip" data-bs-placement="top"
                title="{{ $employee['name'] }}">
                <img src="{{ $employee['avatar_url'] }}" alt="{{ $employee['name'] }}" class="rounded-circle avatar-sm">
            </a>
        @else
            <div class="avatar-sm">
                <span class="avatar-title rounded-circle bg-success text-white font-size-16">
                    {{ strtoupper(substr($employee['name'], 0, 1)) }}
                </span>
            </div>
        @endif
    </td>
    <td>
        <h5 class="text-truncate font-size-14">
            <a href="javascript: void(0);" class="text-dark">{{ $employee['name'] }}</a>
        </h5>
        <p class="text-muted mb-0">{{ $employee['email'] }}</p>
    </td>
    <td>
        <div class="d-flex flex-column">
            <span class="p-2">Timestamp: {{ $checkIn['timestamp'] }}</span>
            {{-- <span class="p-2">Machine: {{ $checkIn['machine']['name'] }}</span> --}}
            <span class="p-2">Location: {{ $checkIn['longitude'] }}, {{ $checkIn['latitude'] }}</span>
        </div>
    </td>
    <td>
        <div class="d-flex flex-column">
            <span class="p-2">Timestamp: {{ $checkOut['timestamp'] }}</span>
            {{-- <span class="p-2">Machine: {{ $checkOut['machine']['name'] }}</span> --}}
            <span class="p-2">Location: {{ $checkOut['longitude'] }}, {{ $checkOut['latitude'] }}</span>
        </div>
    </td>
    <td><span class="badge rounded-pill {{ $badge_color }} font-size-12">{{ $duration_string }}</span></td>
</tr>
