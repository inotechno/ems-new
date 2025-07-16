<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-5">Activities</h4>
        <ul class="verti-timeline list-unstyled">
            @forelse ($activities as $activity)
                <li class="event-list">
                    <div class="event-timeline-dot">
                        <i class="{{ $activity->icon }} font-size-18"></i>
                    </div>
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            <h5 class="font-size-14">{{ $activity->created_at->format('d M') }} <i
                                    class="bx bx-right-arrow-alt font-size-16 text-primary align-middle ms-2"></i>
                            </h5>
                        </div>
                        <div class="flex-grow-1">
                            <div>
                                {{ $activity->description }}
                            </div>
                        </div>
                    </div>
                </li>
            @empty
                <li class="event-list">
                    <div class="event-timeline-dot">
                        <i class="bx bx-x font-size-18 text-primary"></i>
                    </div>
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            <h5 class="font-size-14">{{ now()->format('d M') }} <i
                                    class="bx bx-right-arrow-alt font-size-16 text-primary align-middle ms-2"></i>
                            </h5>
                        </div>
                        <div class="flex-grow-1">
                            <div>
                                No activity found
                            </div>
                        </div>
                    </div>
                </li>
            @endforelse
        </ul>
        <div class="text-center mt-4"><a href="{{ route('activity.index') }}" class="btn btn-primary waves-effect waves-light btn-sm">View More <i class="mdi mdi-arrow-right ms-1"></i></a></div>
    </div>
</div>
