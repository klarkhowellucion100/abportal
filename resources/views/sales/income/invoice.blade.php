<x-layout logoWrapper="back-button" logoHref="{{ route('sales.incomeindex') }}" pageTitle="Invoice"
    imageUrl="{{ url('pwa/icons/android/android-launchericon-72-72.png') }}" imageStyle="display:none;" imageIconStyle="">

    <div class="container">
        <div class="card invoice-card shadow" id="invoice-area">
            <div class="card-body">
                <!-- Download Invoice -->
                <div class="download-invoice text-end mb-3">
                    <a class="btn btn-sm btn-success me-2" href="javascript:void(0);" onclick="generatePDF()">
                        <i class="bi bi-file-earmark-pdf"></i> PDF
                    </a>
                </div>

                <!-- Invoice Info -->
                <div class="invoice-info text-end mb-4">
                    <h5 class="mb-1 fz-14">AgriHub</h5>
                    <h6 class="fz-12">Invoice No. {{ $transaction_number }}</h6>
                    <p class="mb-0 fz-12">Transaction Date:
                        {{ \Carbon\Carbon::parse($invoiceDetails->first()->transaction_date)->format('Y M d') }}</p>
                </div>

                <!-- Invoice Table -->
                <div class="invoice-table">
                    <div class="table-responsive">
                        <table class="table table-bordered caption-top">
                            <caption>
                                Transaction Details
                            </caption>
                            <thead class="table-light">
                                <tr>
                                    <th>Commodity</th>
                                    <th>Volume (kg)</th>
                                    <th>Price (PhP)</th>
                                    <th>Total (PhP)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoiceDetails as $details)
                                    <tr>
                                        <td><span class="text-success fw-bold">{{ $details->commodity_name }}</span>
                                            <br>
                                            Class: {{ $details->commodity_class }}
                                        </td>
                                        <td class="text-end">{{ number_format($details->quantity_delivered, 2) }}</td>
                                        <td class="text-end">{{ number_format($details->price, 2) }}</td>
                                        <td class="text-end">{{ number_format($details->total_income, 2) }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td class="text-end fw-bold text-success" colspan="3">Total:</td>
                                    <td class="text-end fw-bold text-success">
                                        ₱{{ number_format($invoiceTotal->total_income, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <p class="mb-0">Notice: This is auto generated invoice.</p>
            </div>
        </div>
    </div>
    <script>
        function generatePDF() {
            const element = document.getElementById('invoice-area');
            const opt = {
                margin: 0.3,
                filename: 'invoice-{{ $transaction_number }}.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'in',
                    format: 'a4',
                    orientation: 'portrait'
                }
            };
            html2pdf().set(opt).from(element).save();
        }
    </script>
</x-layout>
