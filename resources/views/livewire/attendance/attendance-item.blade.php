<tr>
    <td>
        {{-- @if ($employee['avatar_url'])
            <a href="javascript: void(0);" class="d-inline-block" data-bs-toggle="tooltip" data-bs-placement="top"
                title="{{ $employee['name'] }}">
                <img src="{{ $employee['avatar_url'] }}" alt="{{ $employee['name'] }}" class="rounded-circle avatar-sm">
            </a>
        @else --}}
            <div class="avatar-sm">
                <span class="avatar-title bg-success text-white rounded">
                    {{ $day }}
                </span>
            </div>
        {{-- @endif --}}
    </td>
    <td>
        <h5 class="text-truncate font-size-14">
            <a href="javascript: void(0);" class="text-dark">{{ $employee['name'] }}</a>
        </h5>
        <p class="text-muted mb-0">{{ $employee['email'] }}</p>
    </td>
    <td>
        @if ($checkIn != null)
            <div class="d-flex">
                <div class="flex-shrink-0 me-3 align-self-center">
                    <img class="rounded avatar-md" src="{{ $checkIn['image_url'] ?? asset('images/time.png') }}" alt="{{ $checkIn['image_url'] ?? asset('images/time.png') }}">
                </div>
                <div class="flex-grow-1">
                    @if ($checkIn['attendance_method']['id'] == 3)
                        <span class="d-block">
                            <strong>
                                {{ $checkIn['site']['name'] }} -
                                <a href="https://www.google.com/maps?q={{ $checkIn['site']['latitude'] }},{{ $checkIn['site']['longitude'] }}"
                                    target="_blank">{{ $checkIn['site']['longitude'] }},{{ $checkIn['site']['latitude'] }}</a>
                            </strong>
                        </span>
                    @endif
                    <span class="d-block">Timestamp: <strong>{{ $checkIn['timestamp'] }}</strong></span>
                    {{-- <span class="d-block">Machine: {{ $checkIn['machine']['name'] }}</span> --}}
                    <span class="d-block">Attendance Method:
                        <strong>{{ $checkIn['attendance_method']['name'] }}</strong></span>
                    <span class="d-block">Location:
                        <strong>
                            <a href="https://www.google.com/maps?q={{ $checkIn['latitude'] }},{{ $checkIn['longitude'] }}"
                                target="_blank">{{ $checkIn['longitude'] }}, {{ $checkIn['latitude'] }}</a>
                            - {!! $distanceInFormatted !!}
                        </strong>
                    </span>
                    <span class="text-wrap">
                        {!! $noteInExcerpt !!}
                    </span>
                </div>
            </div>
        @else
            <span class="text-muted">No check in</span>
        @endif
    </td>
    <td>
        @if ($checkOut != null)
            <div class="d-flex">
                <div class="flex-shrink-0 me-3 align-self-center">
                    <img class="rounded avatar-md" src="{{ $checkOut['image_url'] ?? asset('images/time.png') }}"
                        alt="{{ $checkOut['image_url'] ?? asset('images/time.png') }}">
                </div>
                <div class="flex-grow-1">
                    @if ($checkOut['attendance_method']['id'] == 3)
                        <span class="d-block">
                            <strong>
                                {{ $checkIn['site']['name'] }} -
                                <a href="https://www.google.com/maps?q={{ $checkIn['site']['latitude'] }},{{ $checkIn['site']['longitude'] }}"
                                    target="_blank">{{ $checkIn['site']['longitude'] }},{{ $checkIn['site']['latitude'] }}</a>
                            </strong>
                        </span>
                    @endif
                    <span class="d-block">Timestamp: <strong>{{ $checkOut['timestamp'] }}</strong></span>
                    {{-- <span class="d-block">Machine: {{ $checkOut['machine']['name'] }}</span> --}}
                    <span class="d-block">Attendance Method:
                        <strong>{{ $checkOut['attendance_method']['name'] }}</strong></span>
                    <span class="d-block">Location:
                        <strong>
                            <a href="https://www.google.com/maps?q={{ $checkOut['latitude'] }},{{ $checkOut['longitude'] }}"
                                target="_blank">{{ $checkOut['longitude'] }}, {{ $checkOut['latitude'] }}</a>
                            - {!! $distanceOutFormatted !!}
                        </strong>
                    </span>
                    <span class="text-wrap">
                        {!! $noteOutExcerpt !!}
                    </span>
                </div>
            </div>
        @else
            <span class="text-muted">No check out</span>
        @endif
    </td>
    <td><span class="badge rounded-pill {{ $badge_color }} font-size-12">{{ $duration_string }}</span></td>
</tr>
