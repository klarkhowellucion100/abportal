<x-layout logoWrapper="back-button" logoHref="{{ route('demand.index') }}" pageTitle="Cart"
    imageUrl="{{ url('pwa/icons/android/android-launchericon-72-72.png') }}" imageStyle="display:none;" imageIconStyle="">

    <div class="container" id="commitment-commodities">
        <div class="card bg-white mb-3" id="commodities-today">
            <div class="card-body">

                <!-- Action Form -->
                <form method="POST" action="" id="actionForm">
                    @csrf

                    <!-- Hidden inputs -->
                    <input type="hidden" name="action_type" id="action_type">
                    <input type="hidden" name="adjusted_quantity" id="adjusted_quantity_input_hidden">

                    <!-- Buttons -->
                    <button type="button" class="btn btn-danger mb-2 me-2" onclick="confirmDelete()">
                        Delete
                    </button>

                    <button type="button" class="btn btn-warning mb-2" onclick="openAdjustModal()">
                        Adjust
                    </button>

                    <button type="button" class="btn btn-success mb-2 ms-2" onclick="openCheckoutModal()">
                        Checkout
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
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="selected_orders[]" value="{{ $orders->id }}">
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
                        @if ($cartActiveCount < 1)
                            <div class="d-flex justify-content-center flex-wrap mt-3">
                                <span class="text-center text-success fw-bold">
                                    <i class="bi bi-bag-check-fill" style="font-size: 40px;"></i> <br>
                                    Successfully checked out! Your commitments are now pending review and approval.
                                </span>

                            </div>
                            <div class="alert alert-warning mt-3" role="alert">
                                Your application will be reviewed by the AgriBloom Team, who will
                                visit your production site for validation and to provide technical assistance.
                                Approval of your applicationb will be based on the team's findings. Please stay in touch
                                as we schedule a visit to your site.

                                Thank you!
                            </div>
                            <div class="d-flex justify-content-center flex-wrap mt-3">
                                <a type="button" class="btn btn-warning text-white" href="{{ route('demand.index') }}">
                                    Back to Demands
                                </a>
                            </div>
                        @endif
                    </div>

                    <x-paginationlayout>
                        {{ $orderList->links() }}
                    </x-paginationlayout>
                </form>


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

                <!-- Confirm Delete Modal -->
                <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirm Delete</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete the selected commitments?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-danger"
                                    onclick="submitDeleteForm()">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Checkout Modal -->
                <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form onsubmit="submitCheckoutForm(event)">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="checkoutModalLabel">Checkout Commitments</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to checkout the selected commitments?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">Confirm Checkout</button>
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

                <!-- JS Scripts -->
                <script>
                    // Select All functionality
                    document.getElementById('selectAll').addEventListener('change', function() {
                        document.querySelectorAll('input[name="selected_orders[]"]').forEach(cb => {
                            cb.checked = this.checked;
                        });
                    });

                    function anyCheckboxChecked() {
                        return Array.from(document.querySelectorAll('input[name="selected_orders[]"]')).some(cb => cb.checked);
                    }

                    function confirmDelete() {
                        if (!anyCheckboxChecked()) {
                            let modal = new bootstrap.Modal(document.getElementById('noSelectionModal'));
                            modal.show();
                            return;
                        }
                        let modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
                        modal.show();
                    }

                    function submitDeleteForm() {
                        document.getElementById('actionForm').action = "{{ route('demand.delete') }}";
                        document.getElementById('actionForm').submit();
                    }

                    function openAdjustModal() {
                        if (!anyCheckboxChecked()) {
                            let modal = new bootstrap.Modal(document.getElementById('noSelectionModal'));
                            modal.show();
                            return;
                        }
                        let modal = new bootstrap.Modal(document.getElementById('adjustModal'));
                        modal.show();
                    }

                    function submitAdjustForm(event) {
                        event.preventDefault();
                        const qty = parseFloat(document.getElementById('adjusted_quantity_input').value);

                        if (isNaN(qty)) {
                            alert('Both fields are required and quantity must be valid.');
                            return;
                        }

                        document.getElementById('adjusted_quantity_input_hidden').value = qty;
                        document.getElementById('actionForm').action = "{{ route('demand.adjust') }}";
                        document.getElementById('actionForm').submit();
                    }

                    function openCheckoutModal() {
                        if (!anyCheckboxChecked()) {
                            let modal = new bootstrap.Modal(document.getElementById('noSelectionModal'));
                            modal.show();
                            return;
                        }
                        document.getElementById('action_type').value = 'checkout';
                        let modal = new bootstrap.Modal(document.getElementById('checkoutModal'));
                        modal.show();
                    }

                    function submitCheckoutForm(event) {
                        event.preventDefault();
                        document.getElementById('actionForm').action = "{{ route('demand.sendcheckout') }}";
                        document.getElementById('actionForm').submit();
                    }
                </script>

            </div>
        </div>
    </div>
</x-layout>
