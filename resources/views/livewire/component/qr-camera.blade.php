<div>
    <div id="qr-scanner-container" wire:ignore>
        <label for="qr-scanner" class="form-label">Scan QR Code</label>
        <p>Scan QR Code Site Di sini sampai tampil Data Site yang di Scan</p>

        <video id="preview"></video>
        <div class="qr-camera-controls">
            <button type="button" id="switchQRScannerCamera" class="bx bx-transfer-alt bx-sm btn text-white"></button>
        </div>
    </div>

    @assets
        <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

        <style>
            #qr-scanner-container {
                position: relative;
                width: 100%;
                max-width: 100%;
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
        </style>
    @endassets

    @script
        <script>
            let scanner = null;
            let currentCameraIndex = 0;
            let cameras = [];

            const videoElement = document.getElementById('preview');
            const switchCameraButton = document.getElementById('switchQRScannerCamera');
            const retryButton = document.getElementById('retryQRScanner');

            function stopScanner() {
                if (scanner) {
                    scanner.stop();
                    scanner = null;
                }
            }

            function startScanner(cameraIndex) {
                stopScanner();

                setTimeout(() => {
                    Instascan.Camera.getCameras().then(function(availableCameras) {
                        cameras = availableCameras;
                        if (cameras.length > 0) {
                            scanner = new Instascan.Scanner({
                                video: videoElement
                            });
                            scanner.addListener('scan', function(content) {
                                console.log('QR Code terdeteksi:', content);
                                $wire.dispatch('qr-code-scanned', {
                                    content: content
                                });
                            });
                            scanner.start(cameras[cameraIndex]).catch(function(e) {
                                alert('Failed to start scanner: ' + e);
                                console.error('Failed to start scanner:', e);
                            });
                        } else {
                            console.error('Tidak ada kamera yang ditemukan.');
                        }
                    }).catch(function(e) {
                        alert('Error accessing cameras: ' + e);
                        console.error('Error accessing cameras:', e);
                    });
                }, 100);
            }

            switchCameraButton.addEventListener('click', function() {
                if (cameras.length > 1) {
                    currentCameraIndex = (currentCameraIndex + 1) % cameras.length;
                    startScanner(currentCameraIndex);
                } else {
                    console.log('Hanya ada satu kamera yang tersedia.');
                }
            });

            startScanner(currentCameraIndex);

            // Listen for stop and start events
            $wire.on('qr-scanner-stop', stopScanner);
            $wire.on('qr-scanner-start', () => startScanner(currentCameraIndex));

            // Clean up when the component is unmounted
            $wire.on('$dispose', stopScanner);
        </script>
    @endscript
</div>
