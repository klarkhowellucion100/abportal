<x-layout logoWrapper="back-button" logoHref="{{ route('dashboard.index') }}" pageTitle="Weather"
    imageUrl="{{ url('pwa/icons/android/android-launchericon-72-72.png') }}" imageStyle="display:none;" imageIconStyle="">

    <div class="container">
        <div class="row g-3">
            <!-- Single Blog Card -->
            <div class="container">
                <!-- Setting Card -->
                <div class="card mb-3 shadow-sm">
                    <div class="card-body direction-rtl">
                        <p class="mb-2">Weather Details</p>
                        <div class="responsive-iframe-container">
                            <iframe style="width: 100%" height="700"
                                src="https://embed.windy.com/embed.html?type=map&location=coordinates&metricRain=default&metricTemp=default&metricWind=default&zoom=11&overlay=wind&product=ecmwf&level=surface&lat=8.887&lon=125.565&detailLat=8.948&detailLon=125.543&detail=true&pressure=true&message=true"
                                frameborder="2"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-layout>
