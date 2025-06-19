<x-layout logoWrapper="back-button" logoHref="{{ route('article.announcementindex') }}" pageTitle="Announcement"
    imageUrl="{{ url('pwa/icons/android/android-launchericon-72-72.png') }}" imageStyle="display:none;" imageIconStyle="">

    <div class="blog-description py-3">
        <div class="container">
            <a class="badge bg-success mb-2 d-inline-block" href="#">Announcement</a>
            <h3 class="mb-3">
                {{ $showAnnouncements->title }}
            </h3>

            <div class="d-flex align-items-center mb-1">
                <span class="ms-2" style="font-size: 14px;">
                    <span class="text-success">
                        Posted by:
                    </span>
                    <span class="text-dark fw-bold">
                        {{ $showAnnouncements->full_name }}
                    </span>
                </span>
            </div>
            <div class="d-flex align-items-center mb-4">
                <span class="ms-2" style="font-size: 14px;">
                    <span class="text-success">
                        Posted on:
                    </span>
                    <span class="text-dark fw-bold">
                        {{ \Carbon\Carbon::parse($showAnnouncements->date_posted)->format('Y M d') }}
                    </span>
                </span>
            </div>
            <div class="card">
                <div class="card-body">
                    <p class="fz-14" style="text-align: justify;  white-space: pre-line;">
                        {{ $showAnnouncements->content }}
                    </p>
                </div>
            </div>

        </div>
    </div>

</x-layout>
