<x-layout logoWrapper="logo-wrapper" logoHref="{{ route('dashboard.index') }}" pageTitle=""
    imageUrl="{{ url('pwa/icons/android/android-launchericon-72-72.png') }}" imageStyle="" imageIconStyle="display:none;">

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

    <!-- Tiny Slider One Wrapper -->
    <div class="tiny-slider-one-wrapper">
        <div class="tiny-slider-one">
            <!-- Single Hero Slide -->

            @foreach ($articlesPosted as $articles)
                <div>
                    <div class="single-hero-slide position-relative"
                        style="background-image: url('{{ $articles->picture_posted ? config('app.ah_webapp_img_url') . '/' . $articles->picture_posted : asset('images/default.jpg') }}');">

                        <a href="{{ route('article.newsindex') }}" class="position-absolute m-3 fw-bold text-white"
                            style="top: 0; right: 0; z-index: 2; font-size: 13px; padding: 4px 8px; background-color: rgba(0, 0, 0, 0.3); border-radius: 5px;">
                            See More...
                        </a>

                        <div
                            style="background-color: rgba(40, 167, 69, 0.8); position: absolute; top: 0; right: 0; bottom: 0; left: 0;">
                        </div>

                        <div class="h-100 d-flex align-items-center text-center position-relative">
                            <div class="container">
                                <h3 class="text-white mb-3">{{ $articles->title }}</h3>
                                <a class="btn btn-creative btn-warning text-white"
                                    href="{{ route('article.newsshow', $articles->id) }}">Read</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <div class="pt-3"></div>

    <div class="container">
        <div class="card bg-success mb-3 bg-img" style="background-image: url('img/core-img/1.png')">
            <div class="card-body p-4">
                <div class="text-end"><i class="bi bi-cpu text-white mb-0 display-1"></i></div>
                <h1 class="text-white" style="font-size: 20px; margin-top: -50px;">Loyalty Program</h1>
                <p class="mb-0 text-white fw-normal"><span>Tier:</span> <span class="fw-bold">{{ $tier }}</span>
                </p>
                <p class="mb-0 text-white fw-normal"><span>Status:</span> <span
                        class="fw-bold">{{ $status }}</span></p>
                <p class="mb-0 text-white fw-normal"><span>Redeemed Points:</span> <span
                        class="fw-bold">{{ number_format($totalRedeemed, 2) }}</span>
                </p>
                <p class="mb-0 text-white fw-normal"><span>Redeemable Points:</span> <span
                        class="fw-bold">{{ number_format($totalRedeemable, 2) }}</span>
                </p>
                <p class="mb-0 text-white fw-normal"><span>Total Points:</span> <span
                        class="fw-bold">{{ number_format($totalEarned, 2) }}</span>
                </p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card bg-white mb-3" style="background-image: url('img/bg-img/3.jpg')">

            <div class="card-body p-4">
                <div class="input-group">
                    <p class='w-50 text-start text-success fw-bold'>Income Today</p>
                    <p class='w-50 text-end text-success fw-bold' style="font-size:12px;"><a class="text-success"
                            href="{{ route('sales.incomeindex') }}">See Details...</a>
                    </p>
                </div>
                <div class="d-flex justify-content-center">
                    <i class="bi bi-cash text-success" style="font-size: 40px;"></i>
                </div>
                <h2 class="text-success text-center">₱ {{ number_format($totalIncomeToday, 2) }}</h2>
                {{-- <p class="mb-3 text-gray text-center fw-bold">
                    Income Today
                </p> --}}
                <div class='table-responsive'>
                    <table>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card mb-3">
            <div class="card-body">
                <div class="input-group">
                    <p class='w-50 text-start text-success fw-bold'>Prices Today</p>
                    <p class='w-50 text-end text-success fw-bold' style="font-size:12px;"><a class="text-success"
                            href="{{ route('prices.index') }}">See More...</a>
                    </p>
                </div>
                <div class="row g-3">
                    @foreach ($pricesToday as $fgpToday)
                        <div class="col-4">
                            <div class="feature-card mx-auto text-center">
                                <div class="card mx-auto bg-white border border-success">
                                    <img src="{{ $fgpToday->commodity_pic ? config('app.ah_webapp_img_url') . '/' . $fgpToday->commodity_pic : url('pwa/icons/android/android-launchericon-72-72.png') }}"
                                        alt="" />
                                </div>
                                <p class="mb-0 text-success" style="font-size: 12px;">
                                    ₱ {{ number_format($fgpToday->comm_fgp_f, 2) }}
                                </p>
                                <p class="mb-0" style="font-size: 12px;">{{ $fgpToday->commodity_name }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <style>
        .weather-container {
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .weather-container h1 {
            margin: 0;
        }

        .weather-info {
            margin: 15px 0;
        }

        .weather-icon {
            width: 100px;
            height: 100px;
        }
    </style>
    <div class="container">
        <div class="card card-bg-img bg-img mb-3">
            <!-- <div class="card card-bg-img bg-img bg-overlay mb-3" style="background-image: url('img/bg-img/3.jpg')"> -->
            <div class="card-body p-4">
                <div class="weather-container">
                    <h3 class="text-success fw-bold" style="font-size: 17px;">Current Weather</h3>
                    <div class="weather-info" id="weather-info">
                        Loading...
                    </div>
                </div>
                <a class="btn btn-warning mt-3 text-white" href="{{ route('weather.index') }}">See Details</a>
            </div>
        </div>
    </div>

    <script>
        async function getWeather() {
            const apiKey = '18b34f38f70d98b5765b4dee949bcd82';
            var lat = 8.947890;
            var lon = 125.532333;
            const url =
                `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${apiKey}&units=metric`;

            try {
                const response = await fetch(url);
                const data = await response.json();

                if (response.ok) {
                    const iconUrl = `http://openweathermap.org/img/wn/${data.weather[0].icon}@2x.png`;
                    const weatherInfo = `
                            <p>Location: ${data.name}</p>
                            <p>Temperature: ${data.main.temp} °C</p>
                            <p>Humidity: ${data.main.humidity}%</p>
                            <p>Wind Speed: ${data.wind.speed} m/s</p>
                            <p>Condition: ${data.weather[0].description}</p>
                            <img src="${iconUrl}" alt="${data.weather[0].description}" class="weather-icon">
                        `;
                    document.getElementById('weather-info').innerHTML = weatherInfo;
                } else {
                    document.getElementById('weather-info').innerHTML = `<p>Error: ${data.message}</p>`;
                }
            } catch (error) {
                document.getElementById('weather-info').innerHTML = `<p>Error: Unable to fetch weather data</p>`;
            }
        }

        getWeather();
    </script>

    <div class="container">
        <div class="card mb-3 bg-success">
            <div class="card-body">
                <div class="input-group">
                    <p class='w-50 text-start text-white fw-bold'>Commitment Today</p>
                    <p class='w-50 text-end text-success fw-bold' style="font-size:12px;"><a class="text-white"
                            href="{{ route('orders.approvedindex') }}">See More...</a>
                    </p>
                </div>
                <div class="row g-3">
                    @foreach ($scheduledCommitment as $schedule)
                        <div class="col-4">
                            <div class="feature-card mx-auto text-center">
                                <div class="card mx-auto bg-white border border-success">
                                    <img src="{{ $schedule->commodity_pic ? config('app.ah_webapp_img_url') . '/' . $schedule->commodity_pic : url('pwa/icons/android/android-launchericon-72-72.png') }}"
                                        alt="" />
                                </div>
                                <p class="mb-0 text-white" style="font-size: 12px;">
                                    {{ number_format($schedule->total_quantity_adjusted, 2) }}kg
                                </p>
                                <p class="mb-0 text-white" style="font-size: 12px;">{{ $schedule->commodity_name }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card mb-3">
            <div class="card-body">
                <div class="input-group">
                    <p class='w-50 text-start text-success fw-bold'>Announcements</p>
                    <p class='w-50 text-end text-success fw-bold' style="font-size:12px;"><a class="text-success"
                            href="{{ route('article.announcementindex') }}">See More...</a>
                    </p>
                </div>
                <div class="testimonial-slide-three-wrapper">
                    <div class="testimonial-slide3 testimonial-style3">
                        @foreach ($announcementsPosted as $announcements)
                            <!-- Single Testimonial Slide -->
                            <div class="single-testimonial-slide">
                                <div class="text-content">
                                    <h6 class="mb-2">
                                        {{ $announcements->title }}
                                    </h6>
                                    <p>{{ \Carbon\Carbon::parse($announcements->date_posted)->format('Y M d') }}</p>
                                    <span class="d-block text-truncate mb-3"> {{ $announcements->content }}</span>
                                    <a class="btn btn-creative btn-warning text-white"
                                        href="{{ route('article.announcementshow', $announcements->id) }}">See
                                        Details
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card mb-3">
            <div class="card-body">
                <div class="input-group">
                    <p class='w-50 text-start text-success fw-bold'>Guides</p>
                    <p class='w-50 text-end text-success fw-bold' style="font-size:12px;">
                        <a class="text-success" href="{{ route('article.guideindex') }}">See More...</a>
                    </p>
                </div>

                <div class="custom-carousel position-relative">
                    <div class="carousel-items">
                        @foreach ($guidesPosted as $guides)
                            <div class="carousel-item" style="display: none;">
                                <div class="text-content p-3 border rounded">
                                    <h6 class="mb-2">{{ $guides->title }}</h6>
                                    <p>{{ \Carbon\Carbon::parse($guides->date_posted)->format('Y M d') }}</p>
                                    <span class="d-block text-truncate mb-3">{{ $guides->content }}</span>
                                    <a class="btn btn-warning text-white"
                                        href="{{ route('article.guideshow', $guides->id) }}">See Details</a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Controls -->
                    <button
                        class="carousel-prev btn btn-sm btn-outline-success position-absolute top-50 start-0 translate-middle-y">
                        ‹
                    </button>
                    <button
                        class="carousel-next btn btn-sm btn-outline-success position-absolute top-50 end-0 translate-middle-y">
                        ›
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card bg-success mb-3 bg-img" style="background-image: url('img/core-img/1.png')">
            <div class="card-body p-4">
                <h1 class="text-white" style="font-size: 17px;">Commitment Setting</h1>
                <p class="mb-4 text-white">To start with setting your commitment, kindly proceed with viewing the
                    current demands.</p>
                <a class="btn btn-warning text-white" href="{{ route('demand.index') }}">Proceed</a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const items = document.querySelectorAll('.custom-carousel .carousel-item');
            const prevBtn = document.querySelector('.custom-carousel .carousel-prev');
            const nextBtn = document.querySelector('.custom-carousel .carousel-next');
            let current = 0;

            function showSlide(index) {
                items.forEach((item, i) => {
                    item.style.display = i === index ? 'block' : 'none';
                });
            }

            showSlide(current); // Show the first item initially

            nextBtn.addEventListener('click', () => {
                current = (current + 1) % items.length;
                showSlide(current);
            });

            prevBtn.addEventListener('click', () => {
                current = (current - 1 + items.length) % items.length;
                showSlide(current);
            });
        });
    </script>
</x-layout>
