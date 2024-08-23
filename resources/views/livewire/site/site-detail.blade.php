<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Master Data', 'url' => '/'], ['name' => 'Site', 'url' => route('site.detail', [$site->uid])], ['name' => $site->name]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            <img src="{{ $site->qrcode_url }}{{ $site->qrcode_url }}" alt=""
                                class="avatar-sm rounded-circle img-thumbnail">
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <div class="text-muted">
                                        <h5 class="mb-1">{{ $site->name }}</h5>
                                        <p class="mb-0">{{ $site->address }}</p>
                                    </div>
                                </div>

                                <div class="flex-shrink-0 dropdown ms-2">
                                    <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bxs-cog align-middle me-1"></i> Setting
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else</a>
                                    </div>
                                </div>
                            </div>


                            <hr>

                            <div class="row">
                                <div class="col-4">
                                    <div>
                                        <p class="text-muted text-truncate mb-2">Total Department</p>
                                        <h5 class="mb-0">{{ $departments->count() }}</h5>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div>
                                        <p class="text-muted text-truncate mb-2">Total Position</p>
                                        <h5 class="mb-0">{{ $positions->count() }}</h5>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div>
                                        <p class="text-muted text-truncate mb-2">Total Employee</p>
                                        <h5 class="mb-0">{{ $employees->count() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card jobs-categories">
                <div class="card-body">
                    <h5 class="card-title pb-3">Department</h5>
                    @foreach ($departments as $department)
                        <a href="#!"
                            class="px-3 py-2 rounded bg-light bg-opacity-50 d-block mb-2">{{ $department->name }}<span
                                class="badge text-bg-info font-size-12 float-end bg-opacity-100">Total Position
                                : {{ $department->positions->count() }}</span></a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card jobs-categories">
                <div class="card-body">
                    <h5 class="card-title pb-3">Position</h5>
                    @foreach ($positions as $position)
                        <a href="#!"
                            class="px-3 py-2 rounded bg-light bg-opacity-50 d-block mb-2">{{ $position->name }}<span
                                class="badge text-bg-info font-size-12 float-end bg-opacity-100">Total Employee
                                : {{ $position->employees->count() }}</span></a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card jobs-categories">
                <div class="card-body">
                    <h5 class="card-title pb-3">Employee</h5>
                    @foreach ($employees as $employee)
                        <a href="#!"
                            class="px-3 py-2 rounded bg-light bg-opacity-50 d-block mb-2">{{ $employee->user->name }}<span
                                class="badge text-bg-info font-size-12 float-end bg-opacity-100">
                                {{ $employee->user->username }}</span></a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="mb-3" wire:ignore>
                <label for="map" class="form-label">{{ __('Map') }}</label>
                <div id="map"></div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            #map {
                height: 400px;
            }
        </style>
    @endpush

    @push('js')
        {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAIAst2Zattt8a673x8hHQ6J5KV6nISGOk&callback=initMap" async
            defer></script> --}}
        <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAIAst2Zattt8a673x8hHQ6J5KV6nISGOk&callback=initMap&v=weekly&libraries=marker"
            defer></script>

        <script>
            document.addEventListener('livewire:init', function() {
                initMap();

                function initMap() {
                    var initialLat = parseFloat(@json($site->latitude));
                    var initialLng = parseFloat(@json($site->longitude));

                    console.log(initialLat, initialLng);
                    // The location of Uluru
                    const position = {
                        lat: initialLat,
                        lng: initialLng
                    };

                    const map = new google.maps.Map(document.getElementById("map"), {
                        zoom: 4,
                        center: position,
                        mapId: "b939fdccde4ceced", // Map ID is required for advanced markers.
                    });

                    // The advanced marker, positioned at Uluru
                    const marker = new google.maps.marker.AdvancedMarkerElement({
                        map,
                        position: position,
                        title: "{{ $site->name }}",
                    });
                }
            });
        </script>
    @endpush
</div>
