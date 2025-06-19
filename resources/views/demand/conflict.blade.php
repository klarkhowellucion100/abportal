<x-layout logoWrapper="back-button" logoHref="{{ route('demand.checkout') }}" pageTitle="Conflicting Demands"
    imageUrl="{{ url('pwa/icons/android/android-launchericon-72-72.png') }}" imageStyle="display:none;" imageIconStyle="">

    <div class="container">
        <div class="card bg-white mb-3" id="commodities-today">
            <div class="card-body">
                <div class="input-group">
                    <p class='w-100 text-start text-success fw-bold'>Update Existing Commitments
                    </p>
                </div>
                <form action="{{ route('demand.conflict.update.save') }}" method="POST">
                    @csrf
                    <div class="table-responsive">

                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th class="text-success fw-bold">Transaction Date</th>
                                    <th class="text-success fw-bold">Quantity Adjusted</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($conflictingTransactions as $transaction)
                                    <tr>
                                        <td class="text-success fw-bold">
                                            {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('l, Y M d') }}
                                        </td>
                                        <td>
                                            <input type="hidden" name="transactions[{{ $transaction->id }}][id]"
                                                value="{{ $transaction->id }}">
                                            <input type="number"
                                                name="transactions[{{ $transaction->id }}][quantity_adjusted]"
                                                value="{{ $transaction->quantity_adjusted }}" class="form-control"
                                                min="0" step="any">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="btn btn-success mt-3 w-100">Save Changes</button>
                </form>
            </div>
        </div>
    </div>

</x-layout>
