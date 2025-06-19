<x-layout logoWrapper="back-button" logoHref="{{ route('dashboard.index') }}" pageTitle="Price"
    imageUrl="{{ url('pwa/icons/android/android-launchericon-72-72.png') }}" imageStyle="display:none;" imageIconStyle="">

    <div class="container" id="transaction-prices">
        <form action="{{ route('prices.search') }}" method="POST">
            @csrf
            @method('POST')
            <div class="input-group mb-3">

                <input type="date" class="form-control" id='changeDate' name="price_date" value="{{ $today }}"
                    aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                <button class="input-group-text" id="inputGroup-sizing-default">Search Date</button>

            </div>
        </form>
        <div class="card bg-white mb-3">
            <div class="card-body">
                <div class="input-group">
                    <p class='w-50 text-start text-success fw-bold'>Prices
                        ({{ \Carbon\Carbon::parse($today)->format('l, Y M d') }})</p>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Commodity</th>
                                <th scope="col">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prices as $pricePerdDate)
                                <tr>
                                    <td><span class="text-success fw-bold">{{ $pricePerdDate->commodity_name }}</span>
                                    </td>
                                    <td class="text-end">₱{{ number_format($pricePerdDate->comm_fgp_f, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-layout>
