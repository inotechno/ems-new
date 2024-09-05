<tr class="align-middle">
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
        <span>{{ $daily_report->date->format('d M, Y') }}</span>
    </td>
    <td>
        <span class="text-info" id="recipients-tooltip-{{ $daily_report->id }}" data-bs-toggle="tooltip"
            data-bs-placement="top"
            data-recipients="
                @foreach ($users as $user)
                    {{ $user->name }}<br> @endforeach">
            {{ $recipients->count() }} Recipients
        </span>
    </td>
    <td>
        <span>{{ $daily_report->created_at->format('d M, Y h:i A') }}</span>
    </td>
    <td>
        <div class="d-flex flex-row gap-2">
            @can('view:daily-report')
                <a href="{{ route('daily-report.detail', ['id' => $daily_report->id]) }}" class="btn btn-sm btn-primary"><i
                        class="mdi mdi-eye me-1"></i> View</a>
            @endcan

            @if (!$disableUpdate)
                @can('update:daily-report')
                    <a href="{{ route('daily-report.edit', ['id' => $daily_report->id]) }}"
                        class="btn btn-sm btn-primary"><i class="mdi mdi-pencil me-1"></i> Edit</a>
                @endcan

                @can('delete:daily-report')
                    <button class="btn btn-sm btn-danger" wire:click="deleteConfirm({{ $daily_report->id }})"><i
                            class="mdi mdi-delete me-1"></i> Delete</button>
                @endcan
            @endif
        </div>
    </td>

    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Inisialisasi tooltip Bootstrap
                var tooltipElements = document.querySelectorAll('[data-bs-toggle="tooltip"]');

                tooltipElements.forEach(function(element) {
                    var tooltip = new bootstrap.Tooltip(element, {
                        html: true,
                        title: function() {
                            return element.getAttribute('data-recipients');
                        }
                    });
                });
            });
        </script>
    @endpush
</tr>
