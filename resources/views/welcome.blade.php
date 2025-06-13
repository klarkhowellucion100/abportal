<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="| {{ config('app.name') }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <meta name="theme-color" content="#2ecc4a" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />

    <!-- Title -->
    <title>{{ config('app.name') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ url('pwa/icons/android/android-launchericon-72-72.png') }}" />
    <link rel="shortcut icon" href="{{ url('pwa/android/android-launchericon-72-72.png') }}" />
    <link rel="apple-touch-icon" href="{{ url('frontend/img/icons/icon-96x96.png') }}" />
    <link rel="apple-touch-icon" sizes="152x152" href="{{ url('frontend/img/icons/icon-152x152.png') }}" />
    <link rel="apple-touch-icon" sizes="167x167" href="{{ url('frontend/img/icons/icon-167x167.png') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('frontend/img/icons/icon-180x180.png') }}" />

    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ url('frontend/style.css') }}" />

    <!-- Web App Manifest -->
    <link rel="manifest" href="{{ url('manifest.json') }}" />
    <link rel="manifest" href="{{ url('frontend/js/pwa.js') }}" />

    <link rel="apple-touch-icon" sizes="16x16" href="/pwa/icons/ios/16.png">
    <link rel="apple-touch-icon" sizes="20x20" href="/pwa/icons/ios/20.png">
    <link rel="apple-touch-icon" sizes="29x29" href="/pwa/icons/ios/29.png">
    <link rel="apple-touch-icon" sizes="32x32" href="/pwa/icons/ios/32.png">
    <link rel="apple-touch-icon" sizes="40x40" href="/pwa/icons/ios/40.png">
    <link rel="apple-touch-icon" sizes="50x50" href="/pwa/icons/ios/50.png">
    <link rel="apple-touch-icon" sizes="57x57" href="/pwa/icons/ios/57.png">
    <link rel="apple-touch-icon" sizes="58x58" href="/pwa/icons/ios/58.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/pwa/icons/ios/60.png">
    <link rel="apple-touch-icon" sizes="64x64" href="/pwa/icons/ios/64.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/pwa/icons/ios/72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/pwa/icons/ios/76.png">
    <link rel="apple-touch-icon" sizes="80x80" href="/pwa/icons/ios/80.png">
    <link rel="apple-touch-icon" sizes="87x87" href="/pwa/icons/ios/87.png">
    <link rel="apple-touch-icon" sizes="100x100" href="/pwa/icons/ios/100.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/pwa/icons/ios/114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/pwa/icons/ios/120.png">
    <link rel="apple-touch-icon" sizes="128x128" href="/pwa/icons/ios/128.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/pwa/icons/ios/144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/pwa/icons/ios/152.png">
    <link rel="apple-touch-icon" sizes="167x167" href="/pwa/icons/ios/167.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/pwa/icons/ios/180.png">
    <link rel="apple-touch-icon" sizes="192x192" href="/pwa/icons/ios/192.png">
    <link rel="apple-touch-icon" sizes="256x256" href="/pwa/icons/ios/256.png">
    <link rel="apple-touch-icon" sizes="512x512" href="/pwa/icons/ios/512.png">
    <link rel="apple-touch-icon" sizes="1024x1024" href="/pwa/icons/ios/1024.png">

    <link href="/pwa/icons/ios/1024.png" sizes="1024x1024" rel="apple-touch-startup-image">
    <link href="/pwa/icons/ios/512.png" sizes="512x512" rel="apple-touch-startup-image">
    <link href="/pwa/icons/ios/256.png" sizes="256x256" rel="apple-touch-startup-image">
    <link href="/pwa/icons/ios/192.png" sizes="192x192" rel="apple-touch-startup-image">
    <link
        href="https://fonts.googleapis.com/css2?family=Lora:wght@600;700&family=Montserrat:wght@300;400;600&display=swap"
        rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

</head>

<style>
    body {
        font-family: 'Montserrat', sans-serif;
        background-color: #f5f8f0;
    }

    .hero-block-content h1,
    .hero-block-content h2,
    .hero-block-content h3 {
        font-family: 'Lora', serif;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .hero-block-content p {
        font-family: 'Montserrat', sans-serif;
        font-weight: 300;
        font-size: 1.1rem;
    }

    .btn-warning {
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .shape {
        position: absolute;
        border-radius: 50%;
        opacity: 0.4;
        z-index: 0;
        pointer-events: none;
    }

    .shape1 {
        width: 120px;
        height: 120px;
        background-color: #ffcc00;
        top: 20%;
        left: 8%;
    }

    .shape2 {
        width: 150px;
        height: 150px;
        background-color: #00cc99;
        top: 40%;
        left: 80%;
    }

    .shape3 {
        width: 100px;
        height: 100px;
        background-color: #ff6699;
        top: 65%;
        left: 25%;
    }

    .shape4 {
        width: 80px;
        height: 80px;
        background-color: #66ccff;
        top: 75%;
        left: 60%;
    }
</style>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="spinner-grow text-success" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Internet Connection Status -->
    <div class="internet-connection-status" id="internetStatus"></div>

    <div class="toast toast-autohide custom-toast-1 toast-success home-page-toast shadow" role="alert"
        aria-live="assertive" aria-atomic="true" data-bs-delay="6000" data-bs-autohide="true" id="installWrap">
        <div class="toast-body p-4">
            <div class="toast-text me-2">
                <h6 class="text-white">Welcome to AB Portal!</h6>
                <span class="d-block mb-2">Click the <strong>Install Now</strong> button & enjoy it just
                    like an app.</span>
                <button id="installBtn" class="btn btn-sm btn-warning text-white" style="display: none;">
                    Install Now
                </button>

                <script>
                    let deferredPrompt;

                    const installBtn = document.getElementById("installBtn");

                    // Listen for the beforeinstallprompt event
                    window.addEventListener('beforeinstallprompt', (e) => {
                        // Prevent the mini-info bar from appearing on mobile
                        e.preventDefault();
                        // Stash the event so it can be triggered later
                        deferredPrompt = e;

                        // Show the install button
                        installBtn.style.display = 'block';

                        // Install button click handler
                        installBtn.addEventListener('click', () => {
                            // Hide the install button
                            installBtn.style.display = 'none';

                            // Show the install prompt
                            deferredPrompt.prompt();

                            // Wait for the user to respond to the prompt
                            deferredPrompt.userChoice.then((choiceResult) => {
                                if (choiceResult.outcome === 'accepted') {
                                    console.log('User accepted the A2HS prompt');
                                } else {
                                    console.log('User dismissed the A2HS prompt');
                                }
                                deferredPrompt = null;
                            });
                        });
                    });
                </script>
            </div>
        </div>
        <button class="btn btn-close btn-close-white position-absolute p-2" type="button" data-bs-dismiss="toast"
            aria-label="Close"></button>
    </div>

    <!-- Hero Block Wrapper -->
    <div class="hero-block-wrapper position-relative overflow-hidden"
        style="background: linear-gradient(rgba(0, 128, 0, 0.6), rgba(0, 128, 0, 0.6)), url('{{ url('frontend/img/bg-img/appbg.jpg') }}') no-repeat center center/cover; min-height: 100vh;">

        <!-- Animated Shapes -->
        {{-- <div id="animated-shapes" class="position-absolute top-0 start-0 w-100 h-100">
            <div class="shape shape1"></div>
            <div class="shape shape2"></div>
            <div class="shape shape3"></div>
            <div class="shape shape4"></div>
        </div> --}}

        <!-- Dark Overlay -->
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0,0,0,0.4); z-index:1;">
        </div>

        <!-- Hero Block Content -->
        <div class="custom-container position-relative d-flex flex-column justify-content-center align-items-center text-center px-3"
            style="z-index:2; min-height:100vh;">

            <img class="mb-4 logo-fade" src="{{ url('pwa/icons/android/android-launchericon-144-144.png') }}"
                alt="AgriBOOST Logo" style="width: 120px; height: auto;" />

            <h1 class="display-4 fw-bold text-white mb-3 hero-title">
                AgriBOOST Portal
            </h1>

            <p class="lead text-white mb-5 hero-subtitle" style="max-width: 400px;">
                Empowering Your Agricultural Journey with Freshness and Innovation
            </p>

            <a class="btn btn-warning btn-lg rounded-pill px-5 shadow hero-button mb-3" href="{{ route('login') }}">
                Get Started
            </a>

        </div>
    </div>

    {{-- <script src="{{ asset('resources/js/app.js') }}"></script> --}}
    <!-- All JavaScript Files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/ScrollTrigger.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initial entrance animations

            gsap.from(".logo-fade", {
                duration: 1,
                y: -50,
                opacity: 0,
                delay: 0.5,
                ease: "power2.out"
            });

            gsap.from(".hero-title", {
                duration: 1.2,
                y: 30,
                opacity: 0,
                delay: 0.8,
                ease: "power2.out"
            });

            gsap.from(".hero-subtitle", {
                duration: 1.2,
                y: 30,
                opacity: 0,
                delay: 1.1,
                ease: "power2.out"
            });

            gsap.from(".hero-button", {
                duration: 1,
                scale: 0.7,
                opacity: 0,
                delay: 1.4,
                ease: "back.out(1.7)"
            });

            // Parallax-like floating shapes on scroll
            gsap.utils.toArray(".shape").forEach((shape, i) => {
                gsap.to(shape, {
                    y: i % 2 === 0 ? "+=50" : "-=50",
                    ease: "sine.inOut",
                    scrollTrigger: {
                        trigger: shape,
                        scrub: true
                    }
                });
            });
        });
    </script>
    <script src="{{ url('frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('frontend/js/slideToggle.min.js') }}"></script>
    <script src="{{ url('frontend/js/internet-status.js') }}"></script>
    <script src="{{ url('frontend/js/tiny-slider.js') }}"></script>
    <script src="{{ url('frontend/js/venobox.min.js') }}"></script>
    <script src="{{ url('frontend/js/countdown.js') }}"></script>
    <script src="{{ url('frontend/js/rangeslider.min.js') }}"></script>
    <script src="{{ url('frontend/js/vanilla-dataTables.min.js') }}"></script>
    <script src="{{ url('frontend/js/index.js') }}"></script>
    <script src="{{ url('frontend/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ url('frontend/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ url('frontend/js/dark-rtl.js') }}"></script>
    <script src="{{ url('frontend/js/active.js') }}"></script>
    {{-- <script src="{{ url('frontend/js/pwa.js') }}"></script> --}}
</body>

</html>
