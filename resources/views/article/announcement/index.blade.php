<x-layout logoWrapper="back-button" logoHref="{{ route('dashboard.index') }}" pageTitle="Announcement"
    imageUrl="{{ url('pwa/icons/android/android-launchericon-72-72.png') }}" imageStyle="display:none;" imageIconStyle="">

    <div class="container">
        <div class="row g-3">
            <!-- Single Blog Card -->
            @foreach ($allAnnouncements as $announcement)
                <div class="col-12">
                    <div class="card shadow-sm blog-list-card">
                        <div class="d-flex align-items-center">
                            <div class="card-blog-content w-100">
                                <span class="badge bg-primary rounded-pill mb-2 d-inline-block">
                                    {{ \Carbon\Carbon::parse($announcement->date_posted)->format('Y M d') }}</span>
                                <a class="blog-title d-block mb-3 text-dark"
                                    href="{{ route('article.announcementshow', $announcement->id) }}">{{ $announcement->title }}</a>
                            </div>
                        </div>
                        <div class="d-flex p-3">
                            <div class="ms-auto p-3">
                                <a class="btn btn-success btn-sm"
                                    href="{{ route('article.announcementshow', $announcement->id) }}">Read
                                    More</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <x-paginationlayout>
        {{ $allAnnouncements->links() }}
    </x-paginationlayout>

</x-layout>
