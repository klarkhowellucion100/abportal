<x-layout logoWrapper="back-button" logoHref="{{ route('article.guideindex') }}" pageTitle="Guide"
    imageUrl="{{ url('pwa/icons/android/android-launchericon-72-72.png') }}" imageStyle="display:none;" imageIconStyle="">

    <div class="blog-description py-3">
        <div class="container">
            <a class="badge bg-success mb-2 d-inline-block" href="#">Guide</a>
            <h3 class="mb-3">
                {{ $showGuides->title }}
            </h3>

            <div class="d-flex align-items-center mb-1">
                <span class="ms-2" style="font-size: 14px;">
                    <span class="text-success">
                        Posted by:
                    </span>
                    <span class="text-dark fw-bold">
                        {{ $showGuides->full_name }}
                    </span>
                </span>
            </div>
            <div class="d-flex align-items-center mb-4">
                <span class="ms-2" style="font-size: 14px;">
                    <span class="text-success">
                        Posted on:
                    </span>
                    <span class="text-dark fw-bold">
                        {{ \Carbon\Carbon::parse($showGuides->date_posted)->format('Y M d') }}
                    </span>
                </span>
            </div>
            <div class="card">
                <div class="card-body">
                    <p class="fz-14 mb-3" style="text-align: justify;  white-space: pre-line;">
                        {{ $showGuides->content }}
                    </p>
                    <iframe
                        src="{{ $showGuides->picture_posted ? config('app.ah_webapp_img_url') . '/' . $showGuides->picture_posted : url('pwa/icons/android/android-launchericon-72-72.png') }}"
                        width="100%" height="600px" style="border: none;">
                    </iframe>
                </div>
            </div>

        </div>
    </div>

</x-layout>
