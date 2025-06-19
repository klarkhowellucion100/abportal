<x-layout logoWrapper="back-button" logoHref="{{ route('demand.index') }}" pageTitle="Set Commitment"
    imageUrl="{{ url('pwa/icons/android/android-launchericon-72-72.png') }}" imageStyle="display:none;" imageIconStyle="">

    <div class="container mb-3">
        <div class="card bg-white">
            <div class="card-body">
                <h4 class="text-success">{{ $commodity->comm }}</h4>
                <img src="{{ $commodity->comm_pic ? config('app.ah_webapp_img_url') . '/' . $commodity->comm_pic : url('pwa/icons/android/android-launchericon-72-72.png') }}"
                    alt="" />
            </div>
        </div>
    </div>

    <div class="container px-2 mb-3">
        <div class="card bg-white">
            <div class="card-body">
                <h4 class="mb-2 text-success">Demand Calendar</h4>

                <div style="">
                    <div id="calendar"></div>
                </div>

            </div>
            <p class="m-2 fw-bold text-success">Legends:</p>
            <div class="d-flex flex-wrap justify-content-center mb-3">
                <span class="m-1 badge rounded-pill bg-primary p-2">Order</span>
                <span class="m-1 badge rounded-pill bg-success p-2">Approved</span>
                <span class="m-1 badge rounded-pill bg-warning p-2">For Approval</span>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-2 text-success">Set Commitment <br>
                    PhP {{ $commodity->comm_fgp }}</h4>
                <p class="text-danger"><span class="fw-bold">*</span> This is the <span class="fw-bold">Static</span>
                    Class A Price of
                    {{ $commodity->comm }}. It will still be subjected to <span class="fw-bold">Dynamic Pricing</span>
                </p>

                <!-- Modal -->
                <div class="modal fade" id="calendarModal" tabindex="-1" aria-labelledby="calendarModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Select Delivery Date Range</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <div id="inlineCalendar" class="flatpickr-calendar"></div>
                            </div>
                            <div class="modal-footer">
                                <button id="applyDates" class="btn btn-success" data-bs-dismiss="modal">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>

                <x-form-error name='frequency' />
                <x-form-error name='from_date' />
                <x-form-error name='to_date' />
                <x-form-error name='quantity' />
                <x-form-error name='commodity_id' />

                <form action="{{ route('demand.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="multipleSelect">Delivery Days</label>
                        <select class="form-select border-success" id="search-frequency" name="frequency[]" multiple
                            aria-label="multiple select example">
                            <option value="1">Monday</option>
                            <option value="2">Tuesday</option>
                            <option value="3">Wednesday</option>
                            <option value="4">Thursday</option>
                            <option value="5">Friday</option>
                            <option value="6">Saturday</option>
                            <option value="7">Sunday</option>
                        </select>
                    </div>

                    {{-- <script>
                        $(document).ready(function() {
                            $('#search-frequency').select2({
                                placeholder: "Select Frequency",
                                allowClear: true,
                                multiple: true
                            });
                        });
                    </script> --}}

                    <!-- Hidden actual inputs -->
                    <input type="hidden" name="commodity_id" id="commodity_id" value="{{ $commodity->id }}" required>
                    <input type="hidden" id="from_date" name="from_date" required>
                    <input type="hidden" id="to_date" name="to_date" required>

                    <!-- Trigger to open modal -->
                    <div class="form-group">
                        <label class="form-label">Delivery Dates (From and To)</label>
                        <input type="text" class="form-control border-success" id="selectedRangeDisplay"
                            placeholder="Select date range" readonly style="background-color: #fff; cursor: pointer;"
                            data-bs-toggle="modal" data-bs-target="#calendarModal">
                    </div>

                    <script>
                        let selectedRange = null;

                        document.addEventListener('DOMContentLoaded', function() {
                            flatpickr("#inlineCalendar", {
                                mode: "range",
                                inline: true,
                                minDate: new Date().fp_incr(14), // today + 14 days
                                dateFormat: "Y-m-d",
                                onChange: function(selectedDates) {
                                    if (selectedDates.length === 2) {
                                        selectedRange = selectedDates;
                                    }
                                }
                            });

                            document.getElementById('applyDates').addEventListener('click', function() {
                                if (selectedRange && selectedRange.length === 2) {
                                    const start = selectedRange[0];
                                    const end = selectedRange[1];
                                    const formatted =
                                        `${flatpickr.formatDate(start, "Y-m-d")} to ${flatpickr.formatDate(end, "Y-m-d")}`;
                                    document.getElementById('selectedRangeDisplay').value = formatted;
                                    document.getElementById('from_date').value = flatpickr.formatDate(start, "Y-m-d");
                                    document.getElementById('to_date').value = flatpickr.formatDate(end, "Y-m-d");
                                }
                            });
                        });
                    </script>

                    <div class="form-group">
                        <label class="form-label" for="daterange">Volume to Deliver</label>
                        <input type="text" class="form-control border-success" placeholder="Enter Volume (kg)"
                            name="quantity" required>
                    </div>

                    <button class="btn btn-success w-100" type="submit">Commit</button>
                </form>

            </div>
        </div>
    </div>

    <style>
        @media (max-width: 576px) {
            .fc-event-title {
                font-size: 0.75rem;
            }

            .fc-toolbar-title {
                font-size: 1rem;
            }

            .fc-daygrid-event {
                padding: 1px !important;
            }

            .fc .fc-toolbar-title {
                font-size: 0.9rem;
            }

            .fc .fc-button {
                padding: 0.2rem 0.4rem;
                font-size: 0.7rem;
            }

            .fc .fc-toolbar {
                padding: 0.3rem 0;
            }

            .fc .fc-col-header-cell-cushion {
                font-size: 0.75rem;
                padding: 2px 4px;
            }

            .fc .fc-daygrid-day-number {
                font-size: 0.75rem;
                padding: 2px;
            }

            .fc-daygrid-body {
                max-height: 300px;
                /* adjust this height as needed */
                overflow-y: auto;
            }

            /* Ensure day cell doesn't expand forever */
            .fc-daygrid-day-frame {
                max-height: 100px;
                /* limit per day cell height */
                overflow-y: auto;
            }

        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 'auto',
                contentHeight: 'auto',
                aspectRatio: 1.5,
                events: [
                    @foreach ($orders as $order)
                        {
                            title: '{{ number_format($order->total_adjusted, 2) }}kg',
                            start: '{{ $order->transaction_date }}',
                            color: '#007bff',
                            extendedProps: {
                                priority: 1
                            }
                        },
                    @endforeach

                    @foreach ($suppliesApproved as $approved)
                        {
                            title: '{{ number_format($approved->total_adjusted, 2) }}kg',
                            start: '{{ $approved->transaction_date }}',
                            color: '#28a745',
                            extendedProps: {
                                priority: 2
                            }
                        },
                    @endforeach

                    @foreach ($suppliesForApproval as $supply)
                        {
                            title: '{{ number_format($supply->total_adjusted, 2) }}kg',
                            start: '{{ $supply->transaction_date }}',
                            color: '#ffc107',
                            extendedProps: {
                                priority: 3
                            }
                        },
                    @endforeach
                ],
                eventOrder: function(a, b) {
                    return a.extendedProps.priority - b.extendedProps.priority;
                },
                eventDidMount: function(info) {
                    new bootstrap.Tooltip(info.el, {
                        title: info.event.title,
                        placement: 'top',
                        trigger: 'hover',
                        container: 'body'
                    });
                }
            });

            calendar.render();
        });
    </script>

</x-layout>
