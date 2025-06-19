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

</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="spinner-grow text-success" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="internet-connection-status" id="internetStatus"></div>

    {{ $slot }}

    {{-- <script src="{{ asset('resources/js/app.js') }}"></script> --}}
    <!-- All JavaScript Files -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/ScrollTrigger.min.js"></script>
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
