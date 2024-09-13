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
        <div class="d-flex">
            <div class="flex-shrink-0 me-3 align-self-center">
                <img class="rounded avatar-md" src="{{ $checkIn['file_url'] }}" alt="{{ $checkIn['file_url'] }}">
            </div>
            <div class="flex-grow-1">
                <span class="d-block">
                    <strong>
                        {{ $checkIn['site']['name'] }} -
                        <a href="https://www.google.com/maps?q={{ $checkIn['site']['latitude'] }},{{ $checkIn['site']['longitude'] }}"
                            target="_blank">{{ $checkIn['site']['longitude'] }},{{ $checkIn['site']['latitude'] }}</a>
                    </strong>
                </span>
                <span class="d-block">Timestamp: <strong>{{ $checkIn['created_at'] }}</strong></span>
                {{-- <span class="d-block">Machine: {{ $checkIn['machine']['name'] }}</span> --}}
                <span class="d-block">Visit Method:
                    <strong>{{ $checkIn['visit_category']['name'] }}</strong></span>
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
    </td>
    <td>
        <div class="d-flex">
            <div class="flex-shrink-0 me-3 align-self-center">
                <img class="rounded avatar-md" src="{{ $checkOut['file_url'] }}" alt="{{ $checkOut['file_url'] }}">
            </div>
            <div class="flex-grow-1">
                <span class="d-block">
                    <strong>
                        {{ $checkIn['site']['name'] }} -
                        <a href="https://www.google.com/maps?q={{ $checkIn['site']['latitude'] }},{{ $checkIn['site']['longitude'] }}"
                            target="_blank">{{ $checkIn['site']['longitude'] }},{{ $checkIn['site']['latitude'] }}</a>
                    </strong>
                </span>
                <span class="d-block">Timestamp: <strong>{{ $checkOut['created_at'] }}</strong></span>
                {{-- <span class="d-block">Machine: {{ $checkOut['machine']['name'] }}</span> --}}
                <span class="d-block">Visit Method:
                    <strong>{{ $checkOut['visit_category']['name'] }}</strong></span>
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
    </td>
    <td><span class="badge rounded-pill {{ $badge_color }} font-size-12">{{ $duration_string }}</span></td>
</tr>
