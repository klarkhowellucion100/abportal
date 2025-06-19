<x-layout logoWrapper="back-button" logoHref="{{ route('dashboard.index') }}" pageTitle="Settings"
    imageUrl="{{ url('pwa/icons/android/android-launchericon-72-72.png') }}" imageStyle="display:none;" imageIconStyle="">

    <div class="container">

        <!-- Setting Card-->
        <div class="card mb-3 shadow-sm">
            <div class="card-body direction-rtl">
                <p class="mb-2">Account Setup</p>

                <div class="single-setting-panel">
                    <a href="{{ route('settings.profile.index') }}">
                        <div class="icon-wrapper  bg-success">
                            <i class="bi bi-person"></i>
                        </div>
                        Update Profile
                    </a>
                </div>

                {{-- <div class="single-setting-panel">
                    <a href="change-password.html">
                        <div class="icon-wrapper bg-info">
                            <i class="bi bi-lock"></i>
                        </div>
                        Change Password
                    </a>
                </div> --}}

                <div class="single-setting-panel">
                    <a href="{{ route('settings.privacypolicy.index') }}">
                        <div class="icon-wrapper bg-warning">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        Privacy Policy
                    </a>
                </div>
            </div>
        </div>

        <!-- Setting Card-->
        <div class="card shadow-sm">
            <div class="card-body direction-rtl">
                <p class="mb-2">Logout</p>

                <div class="single-setting-panel">
                    @auth('partner')
                        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                        <a href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <div class="icon-wrapper bg-danger">
                                <i class="bi bi-box-arrow-right"></i>
                            </div>
                            Logout
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-layout>
