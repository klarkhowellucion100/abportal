<x-layout logoWrapper="back-button" logoHref="{{ route('settings.index') }}" pageTitle="Profile"
    imageUrl="{{ url('pwa/icons/android/android-launchericon-72-72.png') }}" imageStyle="display:none;" imageIconStyle="">

    <div class="container">
        <!-- User Information-->
        <div class="card user-info-card mb-3">
            <div class="card-body d-flex align-items-center">
                <div class="m-3">
                    <img src="{{ $qrBase64 }}" alt="QR Code" width="80" height="80">
                </div>
                <div class="user-info">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-1 text-success fw-bold">
                            {{ $personalInfo->first_name . ' ' . $personalInfo->middle_name . ' ' . $personalInfo->last_name . ' ' . $personalInfo->extension_name }}
                        </h5>
                    </div>
                    <p class="mb-0">{{ $personalInfo->type }} ({{ $personalInfo->sub_type }})</p>
                </div>
            </div>
        </div>

        <!-- User Meta Data-->
        <div class="card user-data-card">
            <div class="card-body">
                <form action="{{ route('settings.profile.update', $personalInfo->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label class="form-label" for="first_name">First Name</label>
                        <input class="form-control" id="first_name" type="text" name="first_name"
                            value="{{ $personalInfo->first_name }}" placeholder="Enter First Name" required />
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" for="middle_name">Middle Name</label>
                        <input class="form-control" id="middle_name" type="text" name="middle_name"
                            value="{{ $personalInfo->middle_name }}" placeholder="Enter Middle Name" />
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" for="last_name">Last Name</label>
                        <input class="form-control" id="last_name" type="text" name="last_name"
                            value="{{ $personalInfo->last_name }}" placeholder="Enter Last Name" required />
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" for="extension_name">Extension Name</label>
                        <input class="form-control" id="extension_name" type="text" name="extension_name"
                            value="{{ $personalInfo->extension_name }}" placeholder="Enter Extension Name" />
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" for="contact_number">Contact Number</label>
                        <input class="form-control" id="contact_number" type="text" name="contact_number"
                            value="{{ $personalInfo->contact_number }}" placeholder="Enter Contact No." />
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" for="sex">Sex</label>
                        <select class="form-select" id="sex" name="sex">
                            <option value="{{ $personalInfo->sex }}">{{ $personalInfo->sex }}</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" for="birthdate">Birthdate</label>
                        <input class="form-control" id="birthdate" type="date" name="birthdate"
                            value="{{ $personalInfo->birthdate }}" placeholder="Enter Birthdate" />
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" for="specific_location">Specific Location</label>
                        <input class="form-control" id="specific_location" type="text" name="specific_location"
                            value="{{ $personalInfo->specific_location }}"
                            placeholder="Enter Street/Purok/Village/etc." />
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" for="address_id">Brgy/City/Municipality/Province/Region</label>
                        <select class="form-select" id="address_id" name="address_id">
                            <option value="{{ $personalInfo->address_id }}">{{ $personalInfo->barangay }},
                                {{ $personalInfo->municipality }}, {{ $personalInfo->province }},
                                {{ $personalInfo->region }}</option>
                            @foreach ($allAreas as $area)
                                <option value="{{ $area->id }}">{{ $area->barangay }},
                                    {{ $area->municipality }}, {{ $area->province }},
                                    {{ $area->region }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button class="btn btn-success w-100" type="submit">
                        Update Now
                    </button>
                </form>
            </div>
        </div>
    </div>

</x-layout>
