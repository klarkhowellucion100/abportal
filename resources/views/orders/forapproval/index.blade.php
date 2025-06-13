<x-layout logoWrapper="back-button" logoHref="{{ route('dashboard.index') }}" pageTitle="Commitments for Approval"
    imageUrl="{{ url('pwa/icons/android/android-launchericon-72-72.png') }}" imageStyle="display:none;" imageIconStyle="">

    <x-inputgroupbtn btnOne="btn-outline-success" btnOneLink="{{ route('orders.approvedindex') }}" btnOneLabel="Approved"
        btnTwo="btn-success" btnTwoLink="{{ route('orders.forapprovalindex') }}" btnTwoLabel="For Approval" />

    <div class="container" id="transaction-prices">

        <div class="card bg-white mb-3" id="commodities-upcoming">
            <div class="card-body">
                <div class="input-group">
                    <p class='w-100 text-start text-success fw-bold'>Commodities for Approval</p>
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
                            @foreach ($scheduledFutureForApprovalCommitment as $commitmentsForApproval)
                                <tr>
                                    <td><span
                                            class="text-success fw-bold">{{ $commitmentsForApproval->commodity_name }}</span>
                                    </td>
                                    <td class="text-end">
                                        {{ number_format($commitmentsForApproval->total_quantity_adjusted, 2) }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('orders.forapprovalshow', $commitmentsForApproval->commodity_id) }}"
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
                    {{ $scheduledFutureForApprovalCommitment->links() }}
                </x-paginationlayout>
            </div>
        </div>
    </div>

</x-layout>
