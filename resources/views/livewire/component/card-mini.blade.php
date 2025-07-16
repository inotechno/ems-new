<div class="card mini-stats-wid">
    <div class="card-body">

        <div class="d-flex flex-wrap">
            <div class="me-3">
                <p class="text-muted mb-2">{{ $title }}</p>
                <h5 class="mb-0">{{ $value }}</h5>
            </div>

            @if ($badge)
                <div class="ms-auto">
                    <span class="badge badge-soft-success font-size-11">{{ $badge }}</span>
                </div>
            @endif
            {{-- <div class="avatar-sm ms-auto">
                <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                    {!! $icon !!}
                </div>
            </div> --}}
        </div>

    </div>
</div>
