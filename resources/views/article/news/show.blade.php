<x-layout logoWrapper="back-button" logoHref="{{ route('article.newsindex') }}" pageTitle="News"
    imageUrl="{{ url('pwa/icons/android/android-launchericon-72-72.png') }}" imageStyle="display:none;" imageIconStyle="">

    <div class="container">
        <div class="pt-3 d-block"></div>

        <div class="blog-details-post-thumbnail position-relative">
            <!-- Post Image -->
            <img class="w-100 rounded-lg"
                src="{{ $showNews->picture_posted ? config('app.ah_webapp_img_url') . '/' . $showNews->picture_posted : url('pwa/icons/android/android-launchericon-72-72.png') }}"
                alt="" />
            <!-- Post Bookmark -->
            {{-- <a class="post-bookmark position-absolute card-badge" href="#">
                <i class="bi bi-bookmark"></i>
            </a> --}}
        </div>
    </div>

    <div class="blog-description py-3">
        <div class="container">
            <a class="badge bg-success mb-2 d-inline-block" href="#">News</a>
            <h3 class="mb-3">
                {{ $showNews->title }}
            </h3>

            <div class="d-flex align-items-center mb-1">
                <span class="ms-2" style="font-size: 14px;">
                    <span class="text-success">
                        Posted by:
                    </span>
                    <span class="text-dark fw-bold">
                        {{ $showNews->full_name }}
                    </span>
                </span>
            </div>
            <div class="d-flex align-items-center mb-4">
                <span class="ms-2" style="font-size: 14px;">
                    <span class="text-success">
                        Posted on:
                    </span>
                    <span class="text-dark fw-bold">
                        {{ \Carbon\Carbon::parse($showNews->date_posted)->format('Y M d') }}
                    </span>
                </span>
            </div>
            <div class="card">
                <div class="card-body">
                    <p class="fz-14" style="text-align: justify;  white-space: pre-line;">
                        {{ $showNews->content }}
                    </p>
                </div>
            </div>

        </div>
    </div>

</x-layout>
