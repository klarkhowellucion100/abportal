<x-layout logoWrapper="back-button" logoHref="{{ route('dashboard.index') }}" pageTitle="News"
    imageUrl="{{ url('pwa/icons/android/android-launchericon-72-72.png') }}" imageStyle="display:none;" imageIconStyle="">

    <div class="container">

        <div class="row g-3 justify-content-center">
            <!-- Single Blog Card -->
            @foreach ($allNews as $news)
                <div class="col-12 col-md-8 col-lg-7 col-xl-6">
                    <div class="card shadow-sm blog-list-card">
                        <div class="d-flex align-items-center">
                            <div class="card-blog-img position-relative"
                                style="background-image: url('{{ $news->picture_posted ? config('app.ah_webapp_img_url') . '/' . $news->picture_posted : url('pwa/icons/android/android-launchericon-72-72.png') }}')">
                                <span class="badge bg-warning text-white position-absolute card-badge">News</span>
                            </div>
                            <div class="card-blog-content">
                                <span class="badge bg-primary rounded-pill mb-2 d-inline-block">
                                    {{ \Carbon\Carbon::parse($news->date_posted)->format('Y M d') }}</span>
                                <a class="blog-title d-block mb-3 text-dark"
                                    href="{{ route('article.newsshow', $news->id) }}">{{ $news->title }}</a>
                                <a class="btn btn-success btn-sm" href="{{ route('article.newsshow', $news->id) }}">Read
                                    More</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <x-paginationlayout>
        {{ $allNews->links() }}
    </x-paginationlayout>

</x-layout>
