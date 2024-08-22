<div>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4">Form {{ $title }}</h4>
            <form wire:submit="save" class="needs-validation form-horizontal">

                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('Site Name') }}</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        wire:model="name">

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md mb-3">
                        <label for="longitude" class="form-label">{{ __('Longitude') }}</label>
                        <input type="text" class="form-control @error('longitude') is-invalid @enderror"
                            id="longitude" wire:model="longitude" readonly>

                        @error('longitude')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md mb-3">
                        <label for="latitude" class="form-label">{{ __('Latitude') }}</label>
                        <input type="text" class="form-control @error('latitude') is-invalid @enderror"
                            id="latitude" wire:model="latitude" readonly>

                        @error('latitude')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3" wire:ignore>
                            <label for="map" class="form-label">{{ __('Map') }}</label>
                            <div id="map"></div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="image">{{ __('Image') }}</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                        wire:model="image">
                    @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3" wire:ignore.self>
                    <label for="previewImage" class="form-label">{{ __('Preview Image') }}</label>

                    <span wire:loading wire:target="image" class="spinner-border spinner-border-sm"></span>
                    <div class="text-center">

                        @if ($image)
                            <img src="{{ $image->temporaryUrl() }}" alt="Preview Image" class="img-fluid">
                        @else
                            <img src="{{ $previewImage }}" alt="Preview Image" class="img-fluid">
                        @endif
                    </div>

                </div>

                <div class="mb-3 d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary w-md col-md" wire:click="$set('saveMode', 'save')"
                        wire:click="save" wire:loading.attr="disabled" wire:target="save">
                        <i wire:loading.class="spinner-border spinner-border-sm" wire:target="save"></i>
                        {{ __('Save') }}
                    </button>

                    @if ($type == 'create')
                        <button type="submit" class="btn btn-info w-md col-md"
                            wire:click="$set('saveMode', 'save_add')" wire:click="save" wire:loading.attr="disabled"
                            wire:target="save">
                            <i wire:loading.class="spinner-border spinner-border-sm" wire:target="save"></i>
                            {{ __('Save & Add Another') }}
                        </button>
                    @endif

                    <button type="button" class="btn btn-light w-md col-md" wire:click="$dispatch('close-modal')"
                        wire:loading.attr="disabled" wire:target="save">{{ __('Cancel') }}</button>
                </div>
            </form>
        </div>
    </div>

    @push('js')
        {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAIAst2Zattt8a673x8hHQ6J5KV6nISGOk&callback=initMap" async
            defer></script> --}}

        <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAIAst2Zattt8a673x8hHQ6J5KV6nISGOk"></script>

        <script>
            document.addEventListener('livewire:init', function() {
                initMap();

                function initMap() {
                    var initialLat = parseFloat(@json($latitude));
                    var initialLng = parseFloat(@json($longitude));

                    // Fallback location (e.g., center of a specific city)
                    var fallbackLat = -6.2631219; // Latitude for Jakarta, for example
                    var fallbackLng = 106.7988398; // Longitude for Jakarta

                    // If initialLat or initialLng is null, use fallback location
                    if (isNaN(initialLat) || isNaN(initialLng)) {
                        initialLat = fallbackLat;
                        initialLng = fallbackLng;
                    }

                    var mapOptions = {
                        zoom: 20, // Adjust zoom level as needed
                        center: {
                            lat: initialLat,
                            lng: initialLng
                        },
                    };

                    var map = new google.maps.Map(document.getElementById('map'), mapOptions);

                    var marker = new google.maps.Marker({
                        position: {
                            lat: initialLat,
                            lng: initialLng
                        },
                        map: map,
                        draggable: true,
                    });

                    google.maps.event.addListener(map, 'click', function(event) {
                        var lat = event.latLng.lat();
                        var lng = event.latLng.lng();

                        Livewire.dispatch('update-coordinates', {
                            lat: lat,
                            lng: lng
                        });

                        marker.setPosition(new google.maps.LatLng(lat, lng));
                        geocodeLatLng(lat, lng);
                    });

                    function geocodeLatLng(lat, lng) {
                        var geocoder = new google.maps.Geocoder();
                        var latlng = {
                            lat: parseFloat(lat),
                            lng: parseFloat(lng)
                        };

                        geocoder.geocode({
                            'location': latlng
                        }, function(results, status) {
                            if (status === 'OK') {
                                if (results[0]) {
                                    Livewire.dispatch('update-address', {
                                        address: results[0].formatted_address
                                    });
                                } else {
                                    console.log('No results found');
                                }
                            } else {
                                console.log('Geocoder failed due to: ' + status);
                            }
                        });
                    }

                    if (!isNaN(initialLat) && !isNaN(initialLng)) {
                        marker.setPosition(new google.maps.LatLng(initialLat, initialLng));
                        map.setCenter(new google.maps.LatLng(initialLat, initialLng));
                    }
                }
            });
        </script>

        <style>
            #map {
                height: 400px;
            }
        </style>
    @endpush
</div>
