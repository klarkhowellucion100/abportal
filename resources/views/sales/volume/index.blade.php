<x-layout logoWrapper="back-button" logoHref="{{ route('dashboard.index') }}" pageTitle="Volume"
    imageUrl="{{ url('pwa/icons/android/android-launchericon-72-72.png') }}" imageStyle="display:none;" imageIconStyle="">


    <x-inputgroupbtn btnOne="btn-success" btnOneLink="{{ route('sales.volumeindex') }}" btnOneLabel="Volume (kg)"
        btnTwo="btn-outline-success" btnTwoLink="{{ route('sales.incomeindex') }}" btnTwoLabel="Income (PhP)" />

    <div class="container">
        <div class="card bg-white mb-3" style="background-image: url('img/bg-img/3.jpg')">
            <div class="card-body p-4">
                <div class="input-group">
                    <p class='w-50 text-start text-success fw-bold'>Committed Volume <br> (As of
                        {{ \Carbon\Carbon::parse($today)->format('Y M d') }})</p>
                </div>
                <div class="d-flex justify-content-center">
                    <i class="bi bi-bullseye text-success" style="font-size: 40px;"></i>
                </div>
                <h2 class="text-success text-center">{{ number_format($totalVolumeCommitted, 2) }}kg</h2>
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
                    <p class='w-50 text-start text-warning fw-bold'>Delivered Volume</p>
                </div>
                <div class="d-flex justify-content-center">
                    <i class="bi bi-truck text-warning" style="font-size: 40px;"></i>
                </div>
                <h2 class="text-warning text-center">{{ number_format($totalVolumeDelivered, 2) }}kg</h2>
                <p class="mb-3 text-gray text-center fw-bold">
                    ({{ number_format($fulfillmentRate, 2) }}% Fulfillment Rate)
                </p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card bg-white mb-3" style="background-image: url('img/bg-img/3.jpg')">
            <div class="card-body p-4">
                <div class="input-group">
                    <p class='w-50 text-start text-danger fw-bold'>No. of Commodities</p>
                </div>
                <div class="d-flex justify-content-center">
                    <i class="bi bi-basket text-danger" style="font-size: 40px;"></i>
                </div>
                <h2 class="text-danger text-center">{{ number_format($noOfCommodities) }}kg</h2>
                {{-- <p class="mb-3 text-gray text-center fw-bold">
                        ({{ number_format($fulfillmentRate, 2) }}% Fulfillment Rate)
                    </p> --}}
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card bg-white mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class='text-start text-success fw-bold mb-0'>Commitment vs Delivered Volume (kg)</p>
                    <select id="yearSelect" class="form-select w-auto">
                        @foreach ($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="chart-container" style="position: relative; height: 400px; overflow-y: auto; width: 100%;">
                    <canvas id="volumeChart" height="500" style="width: 500px"></canvas>
                </div>

                <script>
                    const chartData = @json($data);
                    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

                    const commitmentVsDeliveredCtx = document.getElementById('volumeChart').getContext('2d');
                    let currentYear = document.getElementById('yearSelect').value;

                    function buildChartData(year) {
                        const delivered = [];
                        const adjusted = [];

                        for (let i = 1; i <= 12; i++) {
                            delivered.push(chartData[year]?.[i]?.delivered || 0);
                            adjusted.push(chartData[year]?.[i]?.adjusted || 0);
                        }

                        return {
                            labels: months,
                            datasets: [{
                                    label: 'Delivered Volume',
                                    data: delivered,
                                    borderColor: '#007bff',
                                    backgroundColor: 'rgba(0, 123, 255, 0.2)',
                                    fill: true,
                                    tension: 0.3
                                },
                                {
                                    label: 'Committed Volume',
                                    data: adjusted,
                                    borderColor: '#28a745',
                                    backgroundColor: 'rgba(40, 167, 69, 0.2)',
                                    fill: true,
                                    tension: 0.3
                                }
                            ]
                        };
                    }

                    let volumeChart = new Chart(commitmentVsDeliveredCtx, {
                        type: 'line',
                        data: buildChartData(currentYear),
                        options: {
                            responsive: true,
                            plugins: {
                                title: {
                                    display: true,
                                    // text: 'Adjusted vs Delivered Monthly'
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    document.getElementById('yearSelect').addEventListener('change', function() {
                        const selectedYear = this.value;
                        const newData = buildChartData(selectedYear);
                        volumeChart.data = newData;
                        volumeChart.update();
                    });
                </script>
            </div>
        </div>
    </div>

    <!-- Delivered per Commodity (Top 5) -->
    <div class="container">
        <div class="card bg-white mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="text-start text-success fw-bold mb-0">Delivered per Commodity (Top 5)</p>
                    <select id="yearSelectorDeliveredOnly" class="form-select w-auto">
                        @foreach ($commodityYears as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="chart-container" style="position: relative; height: 400px; overflow-y: auto;">
                    <canvas id="deliveredOnlyBarChart"></canvas>
                </div>

                <script>
                    const deliveredData = @json($commodityDeliveredByYear);
                    const deliveredOnlyCtx = document.getElementById('deliveredOnlyBarChart').getContext('2d');
                    let deliveredOnlyChart;

                    function renderDeliveredOnlyChart(year) {
                        const yearData = deliveredData[year] || [];
                        const labels = yearData.map(item => item.commodity_name);
                        const data = yearData.map(item => item.total_delivered);

                        if (deliveredOnlyChart) {
                            deliveredOnlyChart.destroy();
                        }

                        deliveredOnlyChart = new Chart(deliveredOnlyCtx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Total Quantity Delivered',
                                    data: data,
                                    backgroundColor: '#198754',
                                    borderRadius: 6,
                                    barThickness: 30,
                                    categoryPercentage: 0.5,
                                    barPercentage: 0.5
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                indexAxis: 'y',
                                scales: {
                                    x: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Quantity Delivered'
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
                                        text: 'Delivered Commodities'
                                    }
                                }
                            }
                        });
                    }

                    // Initial chart render
                    const initialYearDeliveredOnly = document.getElementById('yearSelectorDeliveredOnly').value;
                    renderDeliveredOnlyChart(initialYearDeliveredOnly);

                    // Handle year change
                    document.getElementById('yearSelectorDeliveredOnly').addEventListener('change', function() {
                        renderDeliveredOnlyChart(this.value);
                    });
                </script>
            </div>
        </div>
    </div>

    <!-- Delivered vs Committed per Commodity (Top 5) -->
    <div class="container">
        <div class="card bg-white mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="text-start text-success fw-bold mb-0">Delivered vs Committed per Commodity (Top 5)</p>
                    <select id="yearSelectorDeliveredCommitted" class="form-select w-auto">
                        @foreach ($statsYears as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="chart-container" style="position: relative; height: 400px; overflow-y: auto;">
                    <canvas id="deliveredCommittedBarChart"></canvas>
                </div>

                <script>
                    const commodityData = @json($commodityStatsByYear);
                    const deliveredCommittedCtx = document.getElementById('deliveredCommittedBarChart').getContext('2d');
                    let deliveredCommittedChart;

                    function renderDeliveredCommittedChart(year) {
                        const yearData = commodityData[year] || [];
                        const labels = yearData.map(item => item.commodity_name);
                        const delivered = yearData.map(item => item.total_delivered);
                        const committed = yearData.map(item => item.total_committed);

                        if (deliveredCommittedChart) {
                            deliveredCommittedChart.destroy();
                        }

                        deliveredCommittedChart = new Chart(deliveredCommittedCtx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                        label: 'Total Committed',
                                        data: committed,
                                        backgroundColor: '#ffc107',
                                        borderRadius: 6
                                    },
                                    {
                                        label: 'Total Delivered',
                                        data: delivered,
                                        backgroundColor: '#198754',
                                        borderRadius: 6
                                    }

                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                indexAxis: 'y',
                                scales: {
                                    x: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Quantity'
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
                                        text: 'Delivered vs Committed Commodities'
                                    }
                                }
                            }
                        });
                    }

                    // Initial render
                    const initialYearDeliveredCommitted = document.getElementById('yearSelectorDeliveredCommitted').value;
                    renderDeliveredCommittedChart(initialYearDeliveredCommitted);

                    document.getElementById('yearSelectorDeliveredCommitted').addEventListener('change', function() {
                        renderDeliveredCommittedChart(this.value);
                    });
                </script>
            </div>
        </div>
    </div>

    <div class="container" id="commodity-committedvsdelivered">
        <div class="card bg-white mb-3">
            <div class="card-body">
                <div class="input-group">
                    <p class='w-100 text-start text-success fw-bold'>Total Commitment Vs Delivered Per Commodity
                        <br>
                        (As of
                        {{ \Carbon\Carbon::parse($today)->format('Y M d') }})
                    </p>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Commodity</th>
                                <th scope="col">Committed</th>
                                <th scope="col">Adjusted/Canceled</th>
                                <th scope="col">Delivered</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($totalCommitmentVsDelivered as $status)
                                <tr>
                                    <td><span class="text-success fw-bold">{{ $status->commodity_name }}</span></td>
                                    <td class="text-end">{{ number_format($status->total_committed, 2) }}kg</td>
                                    <td class="text-end">{{ number_format($status->total_adjusted, 2) }}kg</td>
                                    <td class="text-end">{{ number_format($status->total_delivered, 2) }}kg</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- ✅ Move pagination inside --}}
                <x-paginationlayout>
                    {{ $totalCommitmentVsDelivered->appends([
                            'totalCommitmentVsDelivered_page' => $totalCommitmentVsDelivered->currentPage(),
                        ])->links() }}
                </x-paginationlayout>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Map each paginator container ID to a keyword in the query string
            const paginations = [{
                    selector: '#commodity-committedvsdelivered',
                    keyword: 'totalCommitmentVsDelivered_page'
                }
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
