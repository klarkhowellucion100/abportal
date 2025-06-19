<x-layout logoWrapper="back-button" logoHref="{{ route('orders.forapprovalindex') }}" pageTitle="For Approval Schedule"
    imageUrl="{{ url('pwa/icons/android/android-launchericon-72-72.png') }}" imageStyle="display:none;" imageIconStyle="">

    <div class="container">
        <div class="card bg-white mb-3">
            <div class="card-body">
                <form action="{{ route('orders.forapprovalshow', ['id' => request()->route('id')]) }}" method="GET">
                    <div class="input-group gap-1">
                        <a class="btn btn-success"
                            href="{{ route('orders.forapprovalshow', ['id' => request()->route('id')]) }}">All</a>
                        <!-- Hidden actual inputs -->
                        <input type="hidden" name="date_from" id="date_from" value="{{ $dateFrom }}">
                        <input type="hidden" name="date_to" id="date_to" value="{{ $dateTo }}">

                        <!-- Visible date range trigger -->
                        <input type="text" class="form-control text-success" id="daterange"
                            placeholder="Select date range" readonly style="cursor: pointer;">

                        <button class="btn btn-success" type="submit">Search Date</button>

                    </div>
                </form>

                <script>
                    $(function() {
                        // Store initial values of dateFrom and dateTo
                        const initialDateFrom = '{{ $dateFrom }}';
                        const initialDateTo = '{{ $dateTo }}';

                        $('#daterange').daterangepicker({
                            opens: 'center',
                            autoUpdateInput: false,
                            locale: {
                                cancelLabel: 'Clear'
                            },
                            minDate: moment().format('YYYY-MM-DD'), // Disable dates before today
                        });

                        $('#daterange').on('apply.daterangepicker', function(ev, picker) {
                            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format(
                                'YYYY-MM-DD'));
                            $('#date_from').val(picker.startDate.format('YYYY-MM-DD'));
                            $('#date_to').val(picker.endDate.format('YYYY-MM-DD'));
                        });

                        $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
                            // Set the value back to the original dateFrom and dateTo values
                            $(this).val(initialDateFrom + ' to ' + initialDateTo); // Restore the range
                            $('#date_from').val(initialDateFrom); // Restore the value for date_from
                            $('#date_to').val(initialDateTo); // Restore the value for date_to
                        });
                    });
                </script>
            </div>
        </div>
    </div>

    <div class="container" id="commitment-commodities">
        <div class="card bg-white mb-3" id="commodities-today">
            <div class="card-body">
                <div class="input-group">
                    <p class='w-100 text-start text-success fw-bold'>Committed (Upcoming Delivery): {{ $commodityName }}
                    </p>
                    <br>
                    <p>
                        <span class="text-success fw-bold">
                            Date From:
                        </span>{{ \Carbon\Carbon::parse($dateFrom)->format('l, Y M d') }}
                        <br>
                        <span class="text-success fw-bold">
                            Date To:
                        </span>{{ \Carbon\Carbon::parse($dateTo)->format('l, Y M d') }}
                    </p>
                </div>

                <form method="POST" action="{{ route('orders.forapprovalcancel') }}" id="actionForm">
                    @csrf

                    <!-- Hidden inputs for reason and adjusted quantity -->
                    <input type="hidden" name="action_type" id="action_type">
                    <input type="hidden" name="cancel_reason" id="cancel_reason_input">
                    <input type="hidden" name="adjusted_quantity" id="adjusted_quantity_input_hidden">

                    <!-- Action Buttons -->
                    <button type="button" class="btn btn-danger mb-2 me-2" onclick="openCancelModal()">
                        Cancel
                    </button>

                    <button type="button" class="btn btn-warning mb-2" onclick="openAdjustModal()">
                        Adjust
                    </button>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>All <input type="checkbox" id="selectAll"></th>
                                    <th class="text-center">Date </th>
                                    <th class="text-center">Commitment (kg)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderList as $orders)
                                    @php
                                        $transactionDate = \Carbon\Carbon::parse($orders->transaction_date);
                                        $todayDate = \Carbon\Carbon::parse($today);
                                        $diffInDays = $todayDate->diffInDays($transactionDate);
                                    @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="selected_orders[]" value="{{ $orders->id }}"
                                                @if ($diffInDays < 14) disabled @endif>
                                        </td>
                                        <td>
                                            <span class="text-success fw-bold">
                                                {{ \Carbon\Carbon::parse($orders->transaction_date)->format('l, Y M d') }}
                                                <br>
                                                {{ $orders->commodity_name }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            {{ number_format($orders->quantity_adjusted, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <x-paginationlayout>
                        {{ $orderList->appends([
                                'date_from' => request()->get('date_from'),
                                'date_to' => request()->get('date_to'),
                            ])->links() }}
                    </x-paginationlayout>
                </form>

                <!-- Cancel Modal -->
                <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form onsubmit="submitCancelForm(event)">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="cancelModalLabel">Cancel Commitment</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="cancel_reason_textarea" class="form-label">Reason for
                                        Cancellation</label>
                                    <textarea class="form-control" id="cancel_reason_textarea" rows="3" required></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Confirm Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Adjust Modal -->
                <div class="modal fade" id="adjustModal" tabindex="-1" aria-labelledby="adjustModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form onsubmit="submitAdjustForm(event)">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="adjustModalLabel">Adjust Commitment</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="adjusted_quantity_input" class="form-label">Adjusted Quantity
                                            (kg)</label>
                                        <input type="number" class="form-control" id="adjusted_quantity_input"
                                            min="0" step="0.01" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="adjust_reason_textarea" class="form-label">Reason</label>
                                        <textarea class="form-control" id="adjust_reason_textarea" rows="3" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-warning">Confirm Adjustment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- No Selection Modal -->
                <div class="modal fade" id="noSelectionModal" tabindex="-1" aria-labelledby="noSelectionModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body text-center">
                                <p class="text-danger fw-bold">No items selected. Please select at least one
                                    commitment.</p>
                                <button type="button" class="btn btn-secondary mt-2"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- JavaScript -->
                <script>
                    document.getElementById('selectAll').addEventListener('change', function() {
                        document.querySelectorAll('input[name="selected_orders[]"]:not(:disabled)').forEach(cb => {
                            cb.checked = this.checked;
                        });
                    });

                    function anyCheckboxChecked() {
                        return Array.from(document.querySelectorAll('input[name="selected_orders[]"]:not(:disabled)'))
                            .some(cb => cb.checked);
                    }

                    function openCancelModal() {
                        if (!anyCheckboxChecked()) {
                            let modal = new bootstrap.Modal(document.getElementById('noSelectionModal'));
                            modal.show();
                            return;
                        }
                        document.getElementById('action_type').value = 'cancel';
                        let modal = new bootstrap.Modal(document.getElementById('cancelModal'));
                        modal.show();
                    }

                    function openAdjustModal() {
                        if (!anyCheckboxChecked()) {
                            let modal = new bootstrap.Modal(document.getElementById('noSelectionModal'));
                            modal.show();
                            return;
                        }
                        document.getElementById('action_type').value = 'adjust';
                        let modal = new bootstrap.Modal(document.getElementById('adjustModal'));
                        modal.show();
                    }

                    function submitCancelForm(event) {
                        event.preventDefault();
                        const reason = document.getElementById('cancel_reason_textarea').value.trim();
                        if (!reason) {
                            alert('Reason is required.');
                            return;
                        }

                        document.getElementById('cancel_reason_input').value = reason;
                        document.getElementById('adjusted_quantity_input_hidden').value = 0;
                        document.getElementById('actionForm').submit();
                    }

                    function submitAdjustForm(event) {
                        event.preventDefault();
                        const reason = document.getElementById('adjust_reason_textarea').value.trim();
                        const qty = parseFloat(document.getElementById('adjusted_quantity_input').value);

                        if (!reason || isNaN(qty)) {
                            alert('Both fields are required and quantity must be valid.');
                            return;
                        }

                        document.getElementById('cancel_reason_input').value = reason;
                        document.getElementById('adjusted_quantity_input_hidden').value = qty;
                        document.getElementById('actionForm').submit();
                    }
                </script>

            </div>
        </div>
    </div>

</x-layout>
