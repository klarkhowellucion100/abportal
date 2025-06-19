<x-layout logoWrapper="back-button" logoHref="{{ route('dashboard.index') }}" pageTitle="Commitments Approved"
    imageUrl="{{ url('pwa/icons/android/android-launchericon-72-72.png') }}" imageStyle="display:none;" imageIconStyle="">

    <x-inputgroupbtn btnOne="btn-success" btnOneLink="{{ route('orders.approvedindex') }}" btnOneLabel="Approved"
        btnTwo="btn-outline-success" btnTwoLink="{{ route('orders.forapprovalindex') }}" btnTwoLabel="For Approval" />

    <div class="container" id="transaction-prices">

        <div class="card bg-white mb-3" id="commodities-today">
            <div class="card-body">
                <div class="input-group">
                    <p class='w-100 text-start text-success fw-bold'>Committed Commodities (Today)
                        <br>
                        {{ \Carbon\Carbon::parse($today)->format('l, Y M d') }}
                    </p>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th style="vertical-align: middle" class="text-center" scope="col">Commodity</th>
                                <th style="vertical-align: middle" class="text-center" scope="col">Commitment (kg)
                                </th>
                                <th style="vertical-align: middle" class="text-center" scope="col">Delivered (kg)
                                </th>
                                <th style="vertical-align: middle" class="text-center" scope="col">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($scheduledCommitment as $committedToday)
                                <tr>
                                    <td><span class="text-success fw-bold">{{ $committedToday->commodity_name }}</span>
                                    </td>
                                    <td class="text-end">
                                        {{ number_format($committedToday->total_quantity_adjusted, 2) }}
                                    </td>
                                    <td class="text-end">
                                        {{ number_format($committedToday->total_quantity_delivered, 2) }}
                                    </td>
                                    <td class="text-end">
                                        @if ($committedToday->total_quantity_adjusted == 0)
                                            0%
                                        @else
                                            {{ number_format(($committedToday->total_quantity_delivered / $committedToday->total_quantity_adjusted) * 100, 2) }}%
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <x-paginationlayout>
                    {{ $scheduledCommitment->appends([
                            'scheduledFutureCommitment_page' => $scheduledFutureCommitment->currentPage(),
                            'scheduledOfNextCommitment_page' => $scheduledOfNextCommitment->currentPage(),
                        ])->links() }}
                </x-paginationlayout>
            </div>
        </div>

        <div class="card bg-white mb-3" id="commodities-next">
            <div class="card-body">
                <div class="input-group">
                    <p class='w-100 text-start text-success fw-bold'>Committed Commodities (Next)
                        <br>
                        {{ \Carbon\Carbon::parse($nextDateCommitted)->format('l, Y M d') }}
                    </p>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th style="vertical-align: middle" class="text-center" scope="col">Commodity</th>
                                <th style="vertical-align: middle" class="text-center" scope="col">Commitment (kg)
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($scheduledOfNextCommitment as $committedNext)
                                <tr>
                                    <td><span class="text-success fw-bold">{{ $committedNext->commodity_name }}</span>
                                    </td>
                                    <td class="text-end">
                                        {{ number_format($committedNext->total_quantity_adjusted, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <x-paginationlayout>
                    {{ $scheduledOfNextCommitment->appends([
                            'scheduledFutureCommitment_page' => $scheduledFutureCommitment->currentPage(),
                            'scheduledCommitment_page' => $scheduledCommitment->currentPage(),
                        ])->links() }}
                </x-paginationlayout>
            </div>
        </div>

        <div class="card bg-white mb-3" id="commodities-upcoming">
            <div class="card-body">
                <div class="input-group">
                    <p class='w-100 text-start text-success fw-bold'>Committed Commodities (Upcoming)</p>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Commodity</th>
                                <th scope="col">Commitment (kg)</th>
                                <th scope="col">View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($scheduledFutureCommitment as $committedFuture)
                                <tr>
                                    <td><span
                                            class="text-success fw-bold">{{ $committedFuture->commodity_name }}</span>
                                    </td>
                                    <td class="text-end">
                                        {{ number_format($committedFuture->total_quantity_adjusted, 2) }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('orders.approvedshow', $committedFuture->commodity_id) }}"
                                            class="btn btn-outline-success btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <x-paginationlayout>
                    {{ $scheduledFutureCommitment->appends([
                            'scheduledCommitment_page' => $scheduledCommitment->currentPage(),
                            'scheduledOfNextCommitment_page' => $scheduledOfNextCommitment->currentPage(),
                        ])->links() }}
                </x-paginationlayout>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Map each paginator container ID to a keyword in the query string
            const paginations = [{
                    selector: '#commodities-today',
                    keyword: 'scheduledCommitment_page'
                },
                {
                    selector: '#commodities-upcoming',
                    keyword: 'scheduledFutureCommitment_page'
                },
                {
                    selector: '#commodities-next',
                    keyword: 'scheduledOfNextCommitment_page'
                },
                // Add more if needed
            ];

            paginations.forEach(pagination => {
                const links = document.querySelectorAll(`${pagination.selector} .pagination a`);

                links.forEach(link => {
                    const url = new URL(link.href);
                    if (url.searchParams.has(pagination.keyword)) {
                        link.href += pagination.selector;
                    }
                });
            });
        });
    </script>

</x-layout>
