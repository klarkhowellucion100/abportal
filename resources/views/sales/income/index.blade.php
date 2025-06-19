<x-layout logoWrapper="back-button" logoHref="{{ route('dashboard.index') }}" pageTitle="Income"
    imageUrl="{{ url('pwa/icons/android/android-launchericon-72-72.png') }}" imageStyle="display:none;" imageIconStyle="">

    <x-inputgroupbtn btnOne="btn-outline-success" btnOneLink="{{ route('sales.volumeindex') }}" btnOneLabel="Volume (kg)"
        btnTwo="btn-success" btnTwoLink="{{ route('sales.incomeindex') }}" btnTwoLabel="Income (PhP)" />

    <div class="container">
        <div class="card bg-white mb-3" style="background-image: url('img/bg-img/3.jpg')">
            <div class="card-body p-4">
                <div class="input-group">
                    <p class='w-50 text-start text-success fw-bold'>Income from AgriHub</p>
                </div>
                <div class="d-flex justify-content-center">
                    <i class="bi bi-cash text-success" style="font-size: 40px;"></i>
                </div>
                <h2 class="text-success text-center">₱ {{ number_format($totalIncome, 2) }}</h2>
                {{-- <p class="mb-3 text-gray text-center fw-bold">
                    Income Today
                </p> --}}
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card bg-white mb-3" style="background-image: url('img/bg-img/3.jpg')">
            <div class="card-body p-4">
                <div class="input-group">
                    <p class='w-50 text-start text-warning fw-bold'>Income Today</p>
                </div>
                <div class="d-flex justify-content-center">
                    <i class="bi bi-cash text-warning" style="font-size: 40px;"></i>
                </div>
                <h2 class="text-warning text-center">₱ {{ number_format($totalIncomeToday, 2) }}</h2>
                {{-- <p class="mb-3 text-gray text-center fw-bold">
                    Income Today
                </p> --}}
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card bg-white mb-3">
            <div class="card-body">
                <div class="input-group">
                    <p class='w-50 text-start text-success fw-bold'>Details of Income Today</p>
                </div>
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Commodity</th>
                            <th scope="col">Value</th>
                            <th scope="col">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detailsIncomeToday as $details)
                            <tr>
                                <td>
                                    <span class="text-success fw-bold">{{ $details->commodity_name }}</span> <br>
                                    <span style="font-size: 12px;">Class: {{ $details->commodity_class }}</span>
                                </td>
                                <td class="d-flex align-items-center"> <span class="text-center"
                                        style="font-size: 12px;">{{ number_format($details->quantity_delivered, 2) }}kg
                                        <br>
                                        @ <br>
                                        ₱{{ number_format($details->price, 2) }}/kg</span></td>
                                <td class="text-end">₱{{ number_format($details->total_income, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card bg-white mb-3">
            <div class="card-body">
                <div class="input-group">
                    <p class='w-50 text-start text-success fw-bold'>Income Trend</p>
                </div>
                <canvas id="yearlyLineChart"></canvas>

                <script>
                    const incomeLineChartCtx = document.getElementById('yearlyLineChart').getContext('2d');
                    const yearlyLineChart = new Chart(incomeLineChartCtx, {
                        type: 'line',
                        data: {
                            labels: @json($months),
                            datasets: @json($datasets)
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Monthly Income Comparison by Year'
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Income'
                                    }
                                }
                            }
                        }
                    });
                </script>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card bg-white mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="text-start text-success fw-bold mb-0">Earning per Commodity (Top 5)</p>
                    <select id="commodityYearSelect" class="form-select w-auto">
                        @foreach ($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="chart-container" style="position: relative; height: 400px;">
                    <canvas id="commodityBarChart"></canvas>
                </div>

                <script>
                    const commodityData = @json($commodityByYear);
                    const commodityBarChartCtx = document.getElementById('commodityBarChart').getContext('2d');
                    const defaultYear = document.getElementById('commodityYearSelect').value;

                    function buildCommodityChartData(year) {
                        const yearData = commodityData[year] || [];
                        const labels = yearData.map(item => item.commodity_name);
                        const values = yearData.map(item => item.total_income);

                        return {
                            labels: labels,
                            datasets: [{
                                label: 'Total Income per Commodity (PhP)',
                                data: values,
                                backgroundColor: '#198754',
                                borderRadius: 6,
                                barThickness: 30,
                                categoryPercentage: 0.5,
                                barPercentage: 0.5
                            }]
                        };
                    }

                    let commodityBarChart = new Chart(commodityBarChartCtx, {
                        type: 'bar',
                        data: buildCommodityChartData(defaultYear),
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            indexAxis: 'y',
                            scales: {
                                x: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Income (PHP)'
                                    }
                                },
                                y: {
                                    title: {
                                        display: true,
                                        text: 'Commodity'
                                    },
                                    ticks: {
                                        autoSkip: true,
                                        maxTicksLimit: 10
                                    }
                                }
                            },
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Commodity Earnings'
                                }
                            }
                        }
                    });

                    document.getElementById('commodityYearSelect').addEventListener('change', function() {
                        const selectedYear = this.value;
                        const newChartData = buildCommodityChartData(selectedYear);
                        commodityBarChart.data = newChartData;
                        commodityBarChart.update();
                    });
                </script>
            </div>
        </div>
    </div>


    <div class="container" id="commodity-earnings">
        <div class="card bg-white mb-3">
            <div class="card-body">
                <div class="input-group">
                    <p class='w-50 text-start text-success fw-bold'>Total Earnings per Commodity</p>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Commodity</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($totalEarningPerCommodity as $earnings)
                                <tr>
                                    <td><span class="text-success fw-bold">{{ $earnings->commodity_name }}</span></td>
                                    <td class="text-end">₱{{ number_format($earnings->total_income, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- ✅ Move pagination inside --}}
                <x-paginationlayout>
                    {{ $totalEarningPerCommodity->appends([
                            'transactionPerReceipt_page' => $transactionPerReceipt->currentPage(),
                        ])->links() }}
                </x-paginationlayout>
            </div>
        </div>
    </div>

    <div class="container" id="transaction-earnings">
        <div class="card bg-white mb-3">
            <div class="card-body">
                <div class="input-group">
                    <p class='w-50 text-start text-success fw-bold'>Transaction Per Receipt</p>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Transaction Date</th>
                                <th scope="col">Transaction No.</th>
                                <th scope="col">Total</th>
                                <th scope="col">Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactionPerReceipt as $receipt)
                                <tr>
                                    <td><span
                                            class="text-success fw-bold">{{ \Carbon\Carbon::parse($receipt->transaction_date)->format('Y M d') }}
                                        </span>
                                    </td>
                                    <td><a href="{{ route('sales.incomeinvoice', $receipt->transaction_number) }}"><span
                                                class="fw-bold">{{ $receipt->transaction_number }}
                                            </span>
                                        </a>
                                    </td>
                                    <td class="text-end">₱{{ number_format($receipt->total_income, 2) }}</td>
                                    <td class="text-center"><a
                                            href="{{ route('sales.incomeinvoice', $receipt->transaction_number) }}"><span
                                                class="fw-bold"> <i
                                                    class="bi bi-receipt text-success fw-bold text-center fs-1"></i>
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- ✅ Move pagination inside --}}
                <x-paginationlayout>
                    {{ $transactionPerReceipt->appends([
                            'earningsPerCommodity_page' => $totalEarningPerCommodity->currentPage(),
                        ])->links() }}
                </x-paginationlayout>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Map each paginator container ID to a keyword in the query string
            const paginations = [{
                    selector: '#commodity-earnings',
                    keyword: 'earningsPerCommodity_page'
                },
                {
                    selector: '#transaction-earnings',
                    keyword: 'transactionPerReceipt_page'
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


    {{-- <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card mt-3">
                    <div class="card-body p-3">
                        <div>
                            <div class="mt-3">
                                {{ $allGuides->links() }}</div>
                            <p class="text-center">No more guides available.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    {{-- <div class="row g-3">
            <!-- Single Blog Card -->
            @foreach ($allGuides as $guide)
                <div class="col-12">
                    <div class="card shadow-sm blog-list-card">
                        <div class="d-flex align-items-center">
                            <div class="card-blog-content w-100">
                                <span class="badge bg-primary rounded-pill mb-2 d-inline-block">
                                    {{ \Carbon\Carbon::parse($guide->date_posted)->format('Y M d') }}</span>
                                <a class="blog-title d-block mb-3 text-dark"
                                    href="{{ route('article.guideshow', $guide->id) }}">{{ $guide->title }}</a>
                            </div>
                        </div>
                        <div class="d-flex p-3">
                            <div class="ms-auto p-3">
                                <a class="btn btn-success btn-sm"
                                    href="{{ route('article.guideshow', $guide->id) }}">Read
                                    More</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card mt-3">
                    <div class="card-body p-3">
                        <div>
                            <div class="mt-3">
                                {{ $allGuides->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

</x-layout>
