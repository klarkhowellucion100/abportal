<!-- filepath: resources/views/auth/qr.blade.php -->
<x-authlayout>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Back Button -->
    <div class="login-back-button">
        <a href="/">
            <i class="bi bi-arrow-left-short text-success"></i>
        </a>
    </div>

    <div class="login-wrapper d-flex align-items-center justify-content-center">
        <div class="custom-container">
            <div class="text-center px-4">
                <img class="login-intro-img" src="{{ url('pwa/icons/android/android-launchericon-144-144.png') }}"
                    alt="" />
            </div>

            <!-- User Info Form (Initially hidden) -->
            <div class="register-form mt-4" id="user-info-form" style="display: none;">
                <h6 class="mb-3 text-center">User Found. Proceed to Login</h6>

                <form id="proceed-form">
                    <div class="form-group" style="display: none;">
                        <label>ID:</label>
                        <input class="form-control" type="hidden" id="scanned-id" readonly />
                    </div>

                    <div class="form-group" style="display: none;">
                        <label>Hello!</label>
                        <input class="form-control" type="text" id="scanned-fname" readonly />
                    </div>

                    <button class="btn btn-success w-100" type="submit">Proceed</button>
                </form>
            </div>

            <!-- QR Code Scanner -->
            <div id="qr-reader-container" class="mt-3">
                <div id="qr-reader"></div>
                <button class="btn btn-danger mt-3 w-100" id="stop-qr-btn">Cancel Scan</button>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div class="modal fade" id="qrErrorModal" tabindex="-1" aria-labelledby="qrErrorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="qrErrorModalLabel">QR Code Login Failed</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="qrErrorModalBody">
                    <!-- Message will be injected here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Okay</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive QR Reader CSS -->
    <style>
        #qr-reader {
            width: 280px;
            height: 210px;
        }

        @media (min-width: 768px) {
            #qr-reader {
                width: 100%;
                height: 320px;
            }
        }
    </style>

    <!-- QR Scanner Script -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const qrReaderContainer = document.getElementById('qr-reader-container');
            const stopQRBtn = document.getElementById('stop-qr-btn');
            const userInfoForm = document.getElementById('user-info-form');
            const scannedIdInput = document.getElementById('scanned-id');
            const scannedFnameInput = document.getElementById('scanned-fname');
            const proceedForm = document.getElementById('proceed-form');

            let redirectUrl = '';

            let html5QrCode = new Html5Qrcode("qr-reader");

            // Function to start scanner with environment facingMode, fallback to user facingMode and camera selection UI
            function startScanner() {
                html5QrCode.start({
                        facingMode: {
                            exact: "environment"
                        }
                    }, {
                        fps: 10,
                        qrbox: 200
                    },
                    onScanSuccess,
                    onScanFailure
                ).catch(err => {
                    // fallback to environment without exact
                    html5QrCode.start({
                            facingMode: "environment"
                        }, {
                            fps: 10,
                            qrbox: 200
                        },
                        onScanSuccess,
                        onScanFailure
                    ).catch(err2 => {
                        // fallback to user camera
                        html5QrCode.start({
                                facingMode: "user"
                            }, {
                                fps: 10,
                                qrbox: 200
                            },
                            onScanSuccess,
                            onScanFailure
                        ).catch(err3 => {
                            // fallback to camera selection UI
                            Html5Qrcode.getCameras().then(devices => {
                                if (devices && devices.length) {
                                    html5QrCode.start({
                                            deviceId: {
                                                exact: devices[0].id
                                            }
                                        }, {
                                            fps: 10,
                                            qrbox: 200
                                        },
                                        onScanSuccess,
                                        onScanFailure
                                    );
                                } else {
                                    showQRModal("No camera found on this device.");
                                }
                            }).catch(err4 => {
                                showQRModal("Camera initialization failed: " + err4
                                    .message);
                            });
                        });
                    });
                });
            }

            function onScanSuccess(decodedText, decodedResult) {
                console.log("Full QR Code Text:", decodedText);

                const formattedText = decodedText.replace(/&&/g, '&');
                const params = new URLSearchParams(formattedText);
                const id = params.get('id');

                console.log("Extracted ID:", id);

                if (!id) {
                    showQRModal("Invalid QR Code data. 'id' parameter not found.");
                    return;
                }

                fetch(`/login/qrredirect/${id}`, {
                        method: 'GET'
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            // Stop QR scanner
                            html5QrCode.stop();

                            // Show user info form
                            scannedIdInput.value = id;
                            scannedFnameInput.value = data.fname || '';

                            redirectUrl = data.redirect;

                            userInfoForm.style.display = 'block';
                            qrReaderContainer.style.display = 'none';

                        } else {
                            showQRModal(data.message || "Invalid QR Code. Please try again.");
                        }
                    })
                    .catch(err => {
                        console.error("Login failed:", err);
                        showQRModal("Login request failed. Please try again.");
                    });
            }

            function onScanFailure(errorMessage) {
                // optional: you can log or ignore scan failures
            }

            function showQRModal(message) {
                const modal = new bootstrap.Modal(document.getElementById('qrErrorModal'), {
                    backdrop: false
                });
                document.getElementById('qrErrorModalBody').textContent = message;
                modal.show();
            }

            // Start scanning on load
            startScanner();

            stopQRBtn.addEventListener('click', () => {
                html5QrCode.stop().then(() => {
                    qrReaderContainer.style.display = 'none';
                }).catch(err => {
                    console.error("Error stopping QR scanner:", err);
                });
            });

            proceedForm.addEventListener('submit', function(e) {
                e.preventDefault();

                if (redirectUrl) {
                    window.location.href = redirectUrl;
                } else {
                    showQRModal("No redirect URL found. Please scan again.");
                }
            });
        });
    </script>
</x-authlayout>
