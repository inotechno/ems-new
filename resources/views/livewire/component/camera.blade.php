<div>
    <div class="mb-3" wire:ignore>
        <label for="camera" class="form-label">Capture Photo</label>
        <p>Izinkan akses kamera untuk mengambil gambar</p>
        <div class="camera-container">
            <video id="cameraFeed" autoplay></video>
            <canvas id="cameraCanvas" style="display: none;"></canvas>
            <div class="camera-controls">
                <button type="button" id="switchCamera" class="bx bx-transfer-alt bx-sm btn text-white"></button>
                <button type="button" id="capturePhoto" class="bx bx-camera bx-sm btn text-white"></button>
            </div>
        </div>
    </div>

    @assets
        <style>
            .camera-container {
                position: relative;
                width: 100%;
                max-width: 100%;
                /* Adjust based on your layout */
            }

            #cameraFeed {
                width: 100%;
                height: auto;
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
    @endassets

    @script
        <script>
            const video = document.getElementById('cameraFeed');
            const canvas = document.getElementById('cameraCanvas');
            const captureButton = document.getElementById('capturePhoto');
            const switchButton = document.getElementById('switchCamera');
            const context = canvas.getContext('2d');
            let currentStream = null;
            let videoDevices = [];
            let currentIndex = 0;

            function stopCamera() {
                if (currentStream) {
                    currentStream.getTracks().forEach(track => track.stop());
                    currentStream = null;
                }
            }

            function startCamera(deviceId) {
                stopCamera();

                setTimeout(() => {
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
                }, 100);
            }

            function getVideoDevices() {
                navigator.mediaDevices.enumerateDevices()
                    .then(function(devices) {
                        videoDevices = devices.filter(device => device.kind === 'videoinput');
                        if (videoDevices.length > 0) {
                            startCamera(videoDevices[currentIndex].deviceId);
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
                    $wire.dispatch('image-captured', {
                        url: dataURL
                    });

                    video.pause();
                } else {
                    console.error("Tidak ada stream video yang aktif.");
                }
            });

            switchButton.addEventListener('click', function() {
                if (videoDevices.length > 1) {
                    currentIndex = (currentIndex + 1) % videoDevices.length;
                    startCamera(videoDevices[currentIndex].deviceId);
                } else {
                    alert("Hanya ada satu kamera yang tersedia.");
                    console.log("Hanya ada satu kamera yang tersedia.");
                }
            });

            getVideoDevices();

            // Clean up when the component is unmounted
            $wire.on('$dispose', function() {
                stopCamera();
            });

            // Expose methods to parent components
            $wire.on('selfie-camera-stop', stopCamera);
            $wire.on('selfie-camera-start', () => getVideoDevices());
        </script>
    @endscript

</div>
