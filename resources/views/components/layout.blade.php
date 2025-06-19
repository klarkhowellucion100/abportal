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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="spinner-grow text-success" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Internet Connection Status -->
    <div class="internet-connection-status" id="internetStatus"></div>

    <div class="header-area" id="headerArea">
        <div class="container">
            <!-- Header Content -->
            <div
                class="header-content header-style-five position-relative d-flex align-items-center justify-content-between">
                <!-- Logo Wrapper -->
                <div class="{{ $logoWrapper }}">
                    <a href="{{ $logoHref }}">
                        <img src="{{ $imageUrl }}" alt="" style="{{ $imageStyle }}" />
                        <i class="bi bi-arrow-left-short" style="{{ $imageIconStyle }}"></i>
                    </a>
                </div>

                <div class="page-heading">
                    <h6 class="mb-0">{{ $pageTitle }}</h6>
                </div>

                <!-- Right-side Icons and Toggler -->
                <div class="d-flex align-items-center gap-3">

                    <!-- Cart with Badge -->
                    <div class="position-relative me-2">
                        <a href="{{ route('demand.checkout') }}" class="text-success">
                            <i class="bi bi-cart3 fs-5 text-success"></i>
                        </a>
                        @if ($cartActiveCount > 0)
                            <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger"
                                style="font-size: 9px; padding: 2px 5px; line-height: 1;">
                                {{ $cartActiveCount }}
                            </span>
                        @endif
                    </div>

                    <!-- Navbar Toggler -->
                    <div class="navbar--toggler" id="affanNavbarToggler7" data-bs-toggle="offcanvas"
                        data-bs-target="#affanOffcanvas" aria-controls="affanOffcanvas">
                        <span class="d-block"></span>
                        <span class="d-block"></span>
                        <span class="d-block"></span>
                    </div>

                </div>

                <!-- Optional hover style -->
                <style>
                    .navbar--toggler:hover {
                        border-color: #198754 !important;
                    }
                </style>
            </div>
        </div>
    </div>

    <!-- Header Area -->
    {{-- <div class="header-area" id="headerArea">
    <div class="container">
      <!-- Header Content -->
      <div class="header-content header-style-five position-relative d-flex align-items-center justify-content-between">
        <!-- Back Button -->
        <div class="back-button">
          <a href="home.html">
            <i class="bi bi-arrow-left-short"></i>
          </a>
        </div>

        <!-- Page Title -->
        <div class="page-heading">
          <h6 class="mb-0">Chats</h6>
        </div>

        <!-- Navbar Toggler -->
        <div class="navbar--toggler" id="affanNavbarToggler" data-bs-toggle="offcanvas" data-bs-target="#affanOffcanvas"
          aria-controls="affanOffcanvas">
          <span class="d-block"></span>
          <span class="d-block"></span>
          <span class="d-block"></span>
        </div>
      </div>
    </div>
  </div> --}}


    <div class="offcanvas offcanvas-start" id="affanOffcanvas" data-bs-scroll="true" tabindex="-1"
        aria-labelledby="affanOffcanvsLabel">
        <button class="btn-close btn-close-white text-reset" type="button" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>

        <div class="offcanvas-body p-0">
            <div class="sidenav-wrapper">
                <!-- Sidenav Profile -->
                <div class="sidenav-profile bg-success">
                    <div class="sidenav-style1"></div>

                    <!-- User Thumbnail -->
                    <div class="user-profile">
                        <img src="img/bg-img/2.jpg" alt="" />
                    </div>

                    <!-- User Info -->

                    <div class="user-info">
                        <h6 class="user-name mb-0">
                            {{ Auth::guard('partner')->user()->first_name . ' ' . Auth::guard('partner')->user()->last_name . ' ' . Auth::guard('partner')->user()->extension_name }}
                        </h6>
                        <span>{{ Auth::guard('partner')->user()->type . '(' . Auth::guard('partner')->user()->sub_type . ')' }}</span>
                    </div>
                </div>

                <!-- Sidenav Nav -->
                <ul class="sidenav-nav ps-0">
                    <li>
                        <a href="{{ route('dashboard.index') }}"><i class="bi bi-house-door"></i> Home</a>
                    </li>
                    {{-- <li>
                        <a href="elements.html"><i class="bi bi-heart"></i> Elements
                            <span class="badge bg-danger rounded-pill ms-2">220+</span>
                        </a>
                    </li>
                    <li>
                        <a href="pages.html"><i class="bi bi-folder2-open"></i> Pages
                            <span class="badge bg-success rounded-pill ms-2">100+</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"><i class="bi bi-cart-check"></i> Shop</a>
                        <ul>
                            <li>
                                <a href="shop-grid.html"> Shop Grid</a>
                            </li>
                            <li>
                                <a href="shop-list.html"> Shop List</a>
                            </li>
                            <li>
                                <a href="shop-details.html"> Shop Details</a>
                            </li>
                            <li>
                                <a href="cart.html"> Cart</a>
                            </li>
                            <li>
                                <a href="checkout.html"> Checkout</a>
                            </li>
                        </ul>
                    </li> --}}
                    <li>
                        <a href="{{ route('settings.index') }}"><i class="bi bi-gear"></i> Settings</a>
                    </li>
                    <li>
                        <div class="night-mode-nav">
                            <i class="bi bi-moon"></i> Night Mode
                            <div class="form-check form-switch">
                                <input class="form-check-input form-check-success" id="darkSwitch" type="checkbox" />
                            </div>
                        </div>
                    </li>

                    @auth('partner')
                        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                        <li>
                            <a href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </li>
                    @endauth
                </ul>

                <!-- Social Info -->
                <div class="social-info-wrap">
                    <a href="{{ url('https://www.facebook.com/AgriboostButuan') }}">
                        <i class="bi bi-facebook"></i>
                    </a>
                    {{-- <a href="#">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="#">
                        <i class="bi bi-linkedin"></i>
                    </a> --}}
                </div>

                <!-- Copyright Info -->
                <div class="copyright-info">
                    <p>
                        <span id="copyrightYear"></span>
                        &copy; Made by <a href="#" class="text-success"> KHDL</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content-wrapper py-3">

        {{ $slot }}

        <div class="pb-3"></div>
    </div>

    @if (session('success'))
        <div class="position-fixed bottom-0 end-0 w-100 d-flex justify-content-end p-3" style="z-index: 1100;">
            <div class="position-fixed bottom-0 end-0 w-100 d-flex justify-content-end p-3" style="z-index: 1100;">
                <div class="toast toast-autohide custom-toast-1 toast-success mb-2" role="alert"
                    aria-live="assertive" aria-atomic="true" data-bs-delay="8000" data-bs-autohide="true">
                    <div class="toast-body">
                        <img src="{{ url('pwa/icons/android/android-launchericon-48-48.png') }}" alt="" />
                        <div class="toast-text ms-3 me-2">
                            <p class="mb-0 text-white">{{ session('success') }}</p>
                            <small class="d-block">Just now</small>
                        </div>
                    </div>

                    <button class="btn btn-close btn-close-white position-absolute p-1" type="button"
                        data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    @if (session('warning'))
        <div class="position-fixed bottom-0 end-0 w-100 d-flex justify-content-end p-3" style="z-index: 1100;">
            <div class="toast custom-toast-1 toast-warning mb-2 fade show" role="alert" aria-live="assertive"
                aria-atomic="true" data-bs-delay="5000" data-bs-autohide="false">
                <div class="toast-body">
                    <img src="{{ url('pwa/icons/android/android-launchericon-48-48.png') }}" alt="" />
                    <div class="toast-text ms-3 me-2">
                        <p class="mb-0 text-white">{{ session('warning') }}</p>
                        <small class="d-block mb-3">Just now</small>
                        @if (session('conflict_ids'))
                            <a href="{{ route('demand.conflictupdate', ['ids' => implode(',', session('conflict_ids'))]) }}"
                                class="btn btn-sm btn-primary ms-3">
                                Review & Update
                            </a>
                        @endif
                    </div>
                </div>

                <button class="btn btn-close btn-close-white position-absolute p-1" type="button"
                    data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <div class="modal fade bottom-align-modal" id="bottomAlignModal" tabindex="-1"
        aria-labelledby="bottomAlignModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-end">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="bottomAlignModalLabel">
                        Chat
                    </h6>
                    <button class="btn btn-close p-1 ms-auto" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">
                    <div class="input-group">
                        <a class="btn w-50 btn-outline-success" type="submit" href="https://m.me/335731516300927">
                            Chat with Admin
                        </a>
                        <a class="btn w-50 btn-outline-success" type="submit"
                            href="https://m.me/j/AbaMHt5jyLm7HYcX/">Chat with Other Farmers</a>
                    </div>
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-secondary" type="button" data-bs-dismiss="modal">
                        Close
                    </button>
                    <!-- <button class="btn btn-sm btn-success" type="button">Save</button> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Nav -->
    <div class="footer-nav-area" id="footerNav">
        <div class="container px-0">
            <!-- Footer Content -->
            <style>
                .active-link {
                    border-radius: 50px;
                    padding: 3px;
                    font-weight: bold;
                    color: white;
                    transition: all 0.3s ease;
                }
            </style>
            <div class="footer-nav position-relative">
                <ul class="h-100 d-flex align-items-center justify-content-between ps-0">

                    <li
                        class="{{ Route::is('dashboard.*', 'article.*', 'weather.*') ? 'active-link bg-success' : '' }}">
                        <a href="{{ route('dashboard.index') }}" class="">
                            <i class="bi bi-house"
                                style="color: {{ Route::is('dashboard.*', 'article.*', 'weather.*') ? 'white' : '#198754' }};"></i>
                            <span
                                style="color: {{ Route::is('dashboard.*', 'article.*', 'weather.*') ? 'white' : '#198754' }}">Home</span>
                        </a>
                    </li>

                    <li class="{{ Route::is('demand.*') ? 'active-link bg-success' : '' }}">
                        <a href="{{ route('demand.index') }}">
                            <i class="bi bi-shop"
                                style="color: {{ Route::is('demand.*') ? 'white' : '#198754' }}"></i>
                            <span style="color: {{ Route::is('demand.*') ? 'white' : '#198754' }}">Demands</span>
                        </a>
                    </li>

                    <li class="{{ Route::is('orders.*') ? 'active-link bg-success' : '' }}">
                        <a href="{{ route('orders.approvedindex') }}">
                            <i class="bi bi-calendar-week"
                                style="color: {{ Route::is('orders.*') ? 'white' : '#198754' }}"></i>
                            <span style="color: {{ Route::is('orders.*') ? 'white' : '#198754' }}">Orders</span>
                        </a>
                    </li>

                    <li class="{{ Route::is('sales.*') ? 'active-link bg-success' : '' }}">
                        <a href="{{ route('sales.volumeindex') }}" class="">
                            <i class="bi bi-truck"
                                style="color: {{ Route::is('sales.*') ? 'white' : '#198754' }}"></i>
                            <span style="color: {{ Route::is('sales.*') ? 'white' : '#198754' }}">Sales</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#bottomAlignModal">
                            <i class="bi bi-chat-dots" style="color: #198754"></i>
                            <span style="color: #198754">Chat</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- @vite(['resources/js/app.js']) --}}
    {{-- <script src="{{ asset('resources/js/app.js') }}"></script> --}}
    <!-- All JavaScript Files -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
