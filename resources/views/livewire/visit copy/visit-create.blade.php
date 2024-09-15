<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Visit', 'url' => route('attendance.index')], ['name' => 'Create Visit ']]], key('breadcrumb'))

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Visit</h4>
                    <form wire:submit.prevent="submit" class="needs-validation form-horizontal">

                        <div class="mb-3">
                            <label for="visit_category_id" class="form-label">Visit Category</label>

                            <div class="btn-group d-grid gap-2 d-md-flex" role="group"
                                aria-label="Basic radio toggle button group">
                                @foreach ($visit_categories as $category)
                                    <input type="radio" class="btn-check" name="visit_category_id"
                                        id="{{ $category->name }}{{ $category->id }}" value="{{ $category->id }}"
                                        autocomplete="off" wire:model.live="visit_category_id">
                                    <label
                                        class="btn btn-outline-primary  @error('visit_category_id') btn-outline-danger @enderror"
                                        for="{{ $category->name }}{{ $category->id }}">
                                        {{ $category->name }}
                                        @error('visit_category_id')
                                            (<strong>{{ $message }}</strong>)
                                        @enderror
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3 text-center">
                            @if ($content)
                                <div class="alert alert-success" role="alert">
                                    <h3 class="alert-heading">{{ $site_name }}</h3>
                                    <h4>{{ $site_latitude }}, {{ $site_longitude }}</h4>
                                    <button type="button" class="btn btn-primary" wire:click="retryScanner"><i
                                            class="mdi mdi-qrcode-scan"></i> Retry Scan</button>
                                </div>
                            @endif
                            @if ($isScanError)
                                <button type="button" class="btn btn-primary" wire:click="retryScanner"><i
                                        class="mdi mdi-qrcode-scan"></i> Retry Scan</button>
                            @endif
                        </div>

                        <div class="mb-3" wire:ignore>
                            <label for="qr-scanner" class="form-label d-block mb-2">{{ __('QR Code Scanner') }}</label>
                            <div id="qr-scanner-container">
                                <video id="preview"></video>
                                <div class="qr-camera-controls">
                                    <button type="button" id="switchQRScannerCamera"
                                        class="bx bx-transfer-alt bx-sm btn text-white"></button>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" wire:model="notes">
                            </textarea>

                            @error('notes')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3" wire:ignore>
                            <label for="map" class="form-label">{{ __('Location') }}</label>
                            <p>Jika koordinat kurang akurat, silahkan klik tombol Refresh Koordinat pada map</p>
                            <i wire:loading class="spinner-border" wire:target="updateCoordinates"></i>
                            <div id="map"></div>
                        </div>

                        <div class="mb-3" wire:ignore>
                            <label for="camera" class="form-label">Capture Photo</label>
                            <p>Izinkan akses kamera untuk mengambil gambar</p>
                            <div class="camera-container">
                                <video id="cameraFeed" autoplay></video>
                                <canvas id="cameraCanvas" style="display: none;"></canvas>
                                <div class="camera-controls">
                                    <button type="button" id="switchCamera"
                                        class="bx bx-transfer-alt bx-sm btn text-white"></button>
                                    <button type="button" id="capturePhoto"
                                        class="bx bx-camera bx-sm btn text-white"></button>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 d-flex justify-content-end gap-2">
                            <button id="submit" type="submit" class="btn btn-primary w-md col-md"
                                wire:submit.prevent="submit" wire:loading.attr="disabled" wire:target="submit">
                                <i wire:loading.class="spinner-border spinner-border-sm" wire:target="submit"></i>
                                {{ __('Save') }}
                            </button>

                            <button id="cancel" type="button" class="btn btn-light w-md col-md"
                                wire:click="$dispatch('close-modal')" wire:loading.attr="disabled"
                                wire:target="submit">{{ __('Cancel') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            #map {
                height: 400px;
            }

            .camera-container {
                position: relative;
                width: 100%;
                max-width: 100%;
                /* Adjust based on your layout */
            }

            #qr-scanner-container {
                position: relative;
                width: 100%;
                max-width: 100%;
                /* Adjust based on your layout */
            }

            #cameraFeed {
                width: 100%;
                height: auto;
            }

            #preview {
                width: 100%;
                height: auto;
            }

            .qr-camera-controls {
                position: absolute;
                bottom: 10px;
                left: 50%;
                transform: translateX(-50%);
                display: flex;
                gap: 10px;
                background: rgba(0, 0, 0, 0.5);
                padding: 5px;
                border-radius: 10px;
            }

            .qr-camera-controls button {
                color: white;
            }

            .camera-controls {
                position: absolute;
                bottom: 10px;
                left: 50%;
                transform: translateX(-50%);
                display: flex;
                gap: 10px;
                background: rgba(0, 0, 0, 0.5);
                padding: 5px;
                border-radius: 10px;
            }

            .camera-controls button {
                color: white;
            }
        </style>
    @endpush

    @push('js')
        <script async
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAIAst2Zattt8a673x8hHQ6J5KV6nISGOk&libraries=geometry">
        </script>
        <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

        <script>
            document.addEventListener('livewire:init', function() {
                refreshCoordinates();
                cameraStart();
                qrScannerStart();

                function qrScannerStart() {
                    let scanner = null;
                    let currentCameraIndex = 0;
                    let cameras = [];

                    Livewire.on('initQRScanner', () => {
                        console.log('initQRScanner event received');
                        const video = document.getElementById('preview');
                        const switchButton = document.getElementById('switchQRScannerCamera');

                        function startScanner(cameraIndex) {
                            if (scanner) {
                                scanner.stop();
                            }

                            Instascan.Camera.getCameras().then(function(availableCameras) {
                                cameras = availableCameras;
                                if (cameras.length > 0) {
                                    scanner = new Instascan.Scanner({
                                        video: video
                                    });
                                    scanner.addListener('scan', function(content) {
                                        console.log('QR Code terdeteksi:', content);
                                        Livewire.dispatch('qr-code-scanned', {
                                            content: content
                                        });
                                    });
                                    scanner.start(cameras[cameraIndex]).catch(function(e) {
                                        console.error('Failed to start scanner:', e);
                                    });
                                } else {
                                    console.error('Tidak ada kamera yang ditemukan.');
                                }
                            }).catch(function(e) {
                                console.error('Error accessing cameras:', e);
                            });
                        }

                        startScanner(currentCameraIndex);

                        switchButton.addEventListener('click', function() {
                            currentCameraIndex = (currentCameraIndex + 1) % cameras.length;
                            startScanner(currentCameraIndex);
                        });
                    });
                }

                function cameraStart() {
                    const video = document.getElementById('cameraFeed');
                    const canvas = document.getElementById('cameraCanvas');
                    const captureButton = document.getElementById('capturePhoto');
                    const switchButton = document.getElementById('switchCamera');
                    const context = canvas.getContext('2d');
                    let currentStream = null;
                    let videoDevices = [];
                    let currentDeviceIndex = 0;

                    function startCamera(deviceId) {
                        if (currentStream) {
                            currentStream.getTracks().forEach(track => track.stop());
                        }

                        const constraints = {
                            video: deviceId ? {
                                deviceId: {
                                    exact: deviceId
                                }
                            } : true
                        };

                        navigator.mediaDevices.getUserMedia(constraints)
                            .then(function(stream) {
                                currentStream = stream;
                                video.srcObject = stream;
                                return video.play();
                            })
                            .catch(function(err) {
                                console.error("Error accessing camera:", err);
                            });
                    }

                    function getVideoDevices() {
                        navigator.mediaDevices.enumerateDevices()
                            .then(function(devices) {
                                videoDevices = devices.filter(device => device.kind === 'videoinput');
                                if (videoDevices.length > 0) {
                                    startCamera(videoDevices[currentDeviceIndex].deviceId);
                                } else {
                                    console.error('No video input devices found.');
                                }
                            })
                            .catch(function(err) {
                                console.error("Error getting devices:", err);
                            });
                    }

                    captureButton.addEventListener('click', function() {
                        if (video.srcObject) {
                            const MAX_WIDTH = 800;
                            const MAX_HEIGHT = 600;
                            let width = video.videoWidth;
                            let height = video.videoHeight;

                            if (width > height) {
                                if (width > MAX_WIDTH) {
                                    height *= MAX_WIDTH / width;
                                    width = MAX_WIDTH;
                                }
                            } else {
                                if (height > MAX_HEIGHT) {
                                    width *= MAX_HEIGHT / height;
                                    height = MAX_HEIGHT;
                                }
                            }

                            canvas.width = width;
                            canvas.height = height;
                            context.drawImage(video, 0, 0, width, height);
                            const dataURL = canvas.toDataURL('image/jpeg');
                            Livewire.dispatch('image-captured', {
                                url: dataURL
                            });

                            video.pause();
                        } else {
                            console.error("Tidak ada stream video yang aktif.");
                        }
                    });

                    switchButton.addEventListener('click', function() {
                        if (videoDevices.length > 1) {
                            currentDeviceIndex = (currentDeviceIndex + 1) % videoDevices.length;
                            startCamera(videoDevices[currentDeviceIndex].deviceId);
                        } else {
                            console.log("Hanya ada satu kamera yang tersedia.");
                        }
                    });

                    getVideoDevices();
                }

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
</div>
