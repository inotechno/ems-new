<div>
    <div class="mb-3" wire:ignore data-tg-group="visit-create" data-tg-title="Step Create Visit" data-tg-tour="Tampilan map otomatis mendeteksi lokasi">
        <label for="map" class="form-label">{{ __('Location') }}</label>
        <p>Jika koordinat kurang akurat, silahkan klik tombol Refresh Koordinat pada map</p>
        <i wire:loading class="spinner-border" wire:target="updateCoordinates"></i>
        <div id="map"></div>
    </div>

    @assets
        <style>
            #map {
                height: 400px;
            }
        </style>
    @endassets

    @push('js')
        <script async src="https://maps.googleapis.com/maps/api/js?key={{ config('setting.maps_api_key') }}&libraries=geometry">
        </script>
        <script>
            document.addEventListener('livewire:init', function() {
                refreshCoordinates();

                function refreshCoordinates() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            var userLat = position.coords.latitude;
                            var userLng = position.coords.longitude;

                            Livewire.dispatch('update-coordinates', {
                                latitude: userLat,
                                longitude: userLng
                            });
                        }, function(error) {
                            Swal.fire("Error mendapatkan lokasi: " + error.message);
                            console.error("Error mendapatkan lokasi: " + error.message);
                        });
                    } else {
                        Swal.fire("Geolocation tidak didukung oleh browser ini.");
                        console.error("Geolocation tidak didukung oleh browser ini.");
                    }
                }
                // Mengambil koordinat lokasi pengguna saat halaman pertama kali diakses

                Livewire.on('refresh-map', (data) => {
                    // console.log(data);
                    let initialLat = parseFloat(data.latitude);
                    let initialLng = parseFloat(data.longitude);
                    let site_latitude = parseFloat(data.site_latitude);
                    let site_longitude = parseFloat(data.site_longitude);
                    let site_name = data.site_name;

                    initMap(initialLat, initialLng, site_latitude, site_longitude, site_name);
                });

                function addRefreshButton(map) {
                    const controlDiv = document.createElement("div");

                    controlDiv.style.backgroundColor = "#fff";
                    controlDiv.style.border = "2px solid #fff";
                    controlDiv.style.borderRadius = "5px";
                    controlDiv.style.boxShadow = "0 2px 6px rgba(0,0,0,.2)";
                    controlDiv.style.cursor = "pointer";
                    controlDiv.style.marginTop = "10px";
                    controlDiv.style.marginLeft = "10px";
                    controlDiv.style.textAlign = "center";
                    controlDiv.title = "Klik untuk refresh koordinat";

                    const controlText = document.createElement("div");
                    controlText.style.fontSize = "16px";
                    controlText.style.padding = "8px";
                    controlText.innerHTML = "<i class='mdi mdi-refresh'></i>";
                    controlDiv.appendChild(controlText);

                    controlDiv.addEventListener("click", function() {
                        refreshCoordinates();
                    });

                    return controlDiv;
                }

                function initMap(initialLat = 0, initialLng = 0, site_latitude = 0, site_longitude = 0, site_name =
                    "") {
                    console.log(site_longitude, site_latitude);
                    var mapOptions = {
                        zoom: 20, // Adjust zoom level as needed
                        center: {
                            lat: initialLat,
                            lng: initialLng
                        },
                    };

                    var map = new google.maps.Map(document.getElementById('map'), mapOptions);

                    // Tambahkan marker untuk lokasi fallback
                    var fallbackMarker = new google.maps.Marker({
                        position: {
                            lat: site_latitude,
                            lng: site_longitude
                        },
                        map: map,
                        title: site_name,
                    });

                    var marker = new google.maps.Marker({
                        position: {
                            lat: initialLat,
                            lng: initialLng
                        },
                        map: map,
                        draggable: true,
                    });

                    // Tambahkan garis jarak antara lokasi pengguna dan fallback location
                    var lineCoordinates = [{
                            lat: site_latitude,
                            lng: site_longitude
                        },
                        {
                            lat: initialLat,
                            lng: initialLng
                        }
                    ];

                    var polyline = new google.maps.Polyline({
                        path: lineCoordinates,
                        geodesic: true,
                        strokeColor: '#FF0000',
                        strokeOpacity: 1.0,
                        strokeWeight: 2
                    });

                    polyline.setMap(map);

                    // Pastikan pustaka geometry tersedia sebelum menghitung jarak
                    if (google.maps.geometry) {
                        // Menghitung jarak antara dua titik
                        var distance = google.maps.geometry.spherical.computeDistanceBetween(
                            new google.maps.LatLng(site_latitude, site_longitude),
                            new google.maps.LatLng(initialLat, initialLng)
                        );

                        // Konversi jarak ke kilometer
                        var distanceInKm = (distance / 1000).toFixed(2);

                        Livewire.dispatch('update-distance', {
                            distance: distanceInKm
                        });

                        // Tambahkan InfoWindow untuk menampilkan jarak
                        var infoWindow = new google.maps.InfoWindow({
                            content: 'Jarak ke Lokasi Kantor: ' + distanceInKm + ' km'
                        });

                        infoWindow.open(map, marker);
                    } else {
                        console.error("Pustaka geometry Google Maps tidak tersedia.");
                    }

                    if (!isNaN(initialLat) && !isNaN(initialLng)) {
                        marker.setPosition(new google.maps.LatLng(initialLat, initialLng));
                        map.setCenter(new google.maps.LatLng(initialLat, initialLng));
                    }

                    // Create the DIV to hold the control.
                    const centerControlDiv = document.createElement("div");
                    // Create the control.
                    const centerControl = addRefreshButton(map);

                    // Append the control to the DIV.
                    centerControlDiv.appendChild(centerControl);
                    map.controls[google.maps.ControlPosition.TOP_LEFT].push(centerControlDiv);
                }
            });
        </script>
    @endpush
    {{-- @script
        <script async
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAIAst2Zattt8a673x8hHQ6J5KV6nISGOk&libraries=geometry">
        </script>

        <script>
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var userLat = position.coords.latitude;
                    var userLng = position.coords.longitude;

                    $wire.dispatch('update-coordinates', {
                        latitude: userLat,
                        longitude: userLng
                    });
                }, function(error) {
                    Swal.fire("Error mendapatkan lokasi: " + error.message);
                    console.error("Error mendapatkan lokasi: " + error.message);
                });
            } else {
                Swal.fire("Geolocation tidak didukung oleh browser ini.");
                console.error("Geolocation tidak didukung oleh browser ini.");
            }

            $wire.on('refresh-map', (data) => {
                let initialLat = parseFloat(data.latitude);
                let initialLng = parseFloat(data.longitude);
                let site_latitude = parseFloat(data.site_latitude);
                let site_longitude = parseFloat(data.site_longitude);
                let site_name = data.site_name;

                initMap(initialLat, initialLng, site_latitude, site_longitude, site_name);
            });

            function addRefreshButton(map) {
                const controlDiv = document.createElement("div");

                controlDiv.style.backgroundColor = "#fff";
                controlDiv.style.border = "2px solid #fff";
                controlDiv.style.borderRadius = "5px";
                controlDiv.style.boxShadow = "0 2px 6px rgba(0,0,0,.2)";
                controlDiv.style.cursor = "pointer";
                controlDiv.style.marginTop = "10px";
                controlDiv.style.marginLeft = "10px";
                controlDiv.style.textAlign = "center";
                controlDiv.title = "Klik untuk refresh koordinat";

                const controlText = document.createElement("div");
                controlText.style.fontSize = "16px";
                controlText.style.padding = "8px";
                controlText.innerHTML = "<i class='mdi mdi-refresh'></i>";
                controlDiv.appendChild(controlText);

                controlDiv.addEventListener("click", function() {
                    refreshCoordinates();
                });

                return controlDiv;
            }

            function initMap(initialLat = 0, initialLng = 0, site_latitude = 0, site_longitude = 0, site_name = "") {
                console.log(site_longitude, site_latitude);
                var mapOptions = {
                    zoom: 20,
                    center: {
                        lat: initialLat,
                        lng: initialLng
                    },
                };

                var map = new google.maps.Map(document.getElementById('map'), mapOptions);

                var fallbackMarker = new google.maps.Marker({
                    position: {
                        lat: site_latitude,
                        lng: site_longitude
                    },
                    map: map,
                    title: site_name,
                });

                var marker = new google.maps.Marker({
                    position: {
                        lat: initialLat,
                        lng: initialLng
                    },
                    map: map,
                    draggable: true,
                });

                var lineCoordinates = [{
                        lat: site_latitude,
                        lng: site_longitude
                    },
                    {
                        lat: initialLat,
                        lng: initialLng
                    }
                ];

                var polyline = new google.maps.Polyline({
                    path: lineCoordinates,
                    geodesic: true,
                    strokeColor: '#FF0000',
                    strokeOpacity: 1.0,
                    strokeWeight: 2
                });

                polyline.setMap(map);

                if (google.maps.geometry) {
                    var distance = google.maps.geometry.spherical.computeDistanceBetween(
                        new google.maps.LatLng(site_latitude, site_longitude),
                        new google.maps.LatLng(initialLat, initialLng)
                    );

                    var distanceInKm = (distance / 1000).toFixed(2);

                    $wire.dispatch('update-distance', {
                        distance: distanceInKm
                    });
                    var infoWindow = new google.maps.InfoWindow({
                        content: 'Jarak ke Lokasi Kantor: ' + distanceInKm + ' km'
                    });

                    infoWindow.open(map, marker);
                } else {
                    console.error("Pustaka geometry Google Maps tidak tersedia.");
                }

                if (!isNaN(initialLat) && !isNaN(initialLng)) {
                    marker.setPosition(new google.maps.LatLng(initialLat, initialLng));
                    map.setCenter(new google.maps.LatLng(initialLat, initialLng));
                }

                const centerControlDiv = document.createElement("div");
                const centerControl = addRefreshButton(map);

                centerControlDiv.appendChild(centerControl);
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(centerControlDiv);
            }
        </script>
    @endscript --}}
</div>
