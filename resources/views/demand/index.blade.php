<x-layout logoWrapper="back-button" logoHref="{{ route('dashboard.index') }}" pageTitle="Commodities"
    imageUrl="{{ url('pwa/icons/android/android-launchericon-72-72.png') }}" imageStyle="display:none;" imageIconStyle="">

    <div class="container ">
        <div class="card bg-white mb-3">
            <div class="card-body">
                <form action="{{ route('demand.search') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="input-group gap-1">
                        <a class="btn btn-success" href="{{ route('demand.index') }}">All</a>

                        <select class="form-select form-control-clicked" id="defaultSelect" name="commodity_id"
                            aria-label="Default select example">
                            <option value="1" selected="">Select</option>
                            @foreach ($commoditiesSelect as $commodity)
                                <option value="{{ $commodity->id }}">{{ $commodity->comm }}</option>
                            @endforeach
                        </select>

                        <button class="btn btn-success" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="top-products-area">
        <div class="container">
            <div class="row g-3">
                <!-- Single Top Product Card -->
                @foreach ($commodities as $commodity)
                    <div class="col-6 col-sm-4 col-lg-3">
                        <div class="card single-product-card">
                            <div class="card-body p-3">
                                <!-- Product Thumbnail -->
                                <a class="product-thumbnail d-block" href="shop-details.html">
                                    <img src="{{ $commodity->comm_pic ? config('app.ah_webapp_img_url') . '/' . $commodity->comm_pic : url('pwa/icons/android/android-launchericon-72-72.png') }}"
                                        alt="" />
                                </a>
                                <!-- Product Title -->
                                <a class="product-title d-block text-truncate"
                                    href="{{ route('demand.show', $commodity->id) }}">{{ $commodity->comm }}</a>
                                <!-- Product Price -->
                                {{-- <p class="sale-price">$9.89<span>$13.42</span></p> --}}
                                <a class="btn btn-success rounded-pill btn-sm"
                                    href="{{ route('demand.show', $commodity->id) }}">View
                                    Demand</a>
                            </div>
                        </div>
                    </div>
                @endforeach
                <x-paginationlayout>
                    {{ $commodities->links() }}
                </x-paginationlayout>

            </div>
        </div>
    </div>

</x-layout>
