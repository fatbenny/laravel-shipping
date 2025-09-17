<div class="package package-card mb-4">
    <div class="package-header">
        <h4 class="package-title">
            <i class="fas fa-shipping-fast"></i>
            {{ $type }} Information
        </h4>
    </div>

    <div class="package-body">
        <!-- Contact Information -->
        <h6 class="section-title">
            <i class="fas fa-user"></i>
            Contact Details
        </h6>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="form-floating">
                    <input type="text" name="{{ $type }}[contact][personName]" class="form-control" id="{{ $type }}Name"
                        placeholder="Name" value="{{ $type }}">
                    <label for="{{ $type }}Name">
                        <i class="fas fa-user me-2"></i>Full Name
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating">
                    <input type="tel" name="{{ $type }}[contact][phoneNumber]" class="form-control" id="{{ $type }}Phone"
                        placeholder="Phone" value="1234567890">
                    <label for="{{ $type }}Phone">
                        <i class="fas fa-phone me-2"></i>Phone Number
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating">
                    <input type="email" name="{{ $type }}[contact][emailAddress]" class="form-control" id="{{ $type }}Email"
                        placeholder="Email" value="{{ $type }}@gmail.com">
                    <label for="{{ $type }}Email">
                        <i class="fas fa-envelope me-2"></i>Email Address
                    </label>
                </div>
            </div>
        </div>

        <!-- Address Information -->
        <div class="address-section">
            <h6 class="section-title">
                <i class="fas fa-map-marker-alt"></i>
                Shipping Address
            </h6>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <select name="{{ $type }}[address][countryCode]" class="form-select" id="{{ $type }}Country">
                            @foreach(config('fedex.CountryCodes') as $label => $value)
                                <option value="{{ $value }}" {{ ($value == 'US') ? 'selected' : '' }}>{{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <label for="{{ $type }}Country">
                            <i class="fas fa-globe me-2"></i>Country
                        </label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating mb-2">
                        <input type="text" name="{{ $type }}[address][streetLines][0]" class="form-control street-input"
                            id="streetLine1" placeholder="Street Line 1" value="5300 Irwindale Ave">
                        <label for="streetLine1">
                            <i class="fas fa-road me-2"></i>Street Address Line 1
                        </label>
                    </div>
                    <div class="form-floating">
                        <input type="text" name="{{ $type }}[address][streetLines][1]" class="form-control street-input"
                            id="streetLine2" placeholder="Street Line 2" value="">
                        <label for="streetLine2">
                            <i class="fas fa-road me-2"></i>Street Address Line 2 (Optional)
                        </label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" name="{{ $type }}[address][city]" class="form-control" id="{{ $type }}City"
                            placeholder="City" value="Baldwin Park">
                        <label for="{{ $type }}City">
                            <i class="fas fa-city me-2"></i>City
                        </label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" name="{{ $type }}[address][stateOrProvinceCode]" class="form-control"
                            id="{{ $type }}State" placeholder="State" value="CA">
                        <label for="{{ $type }}State">
                            <i class="fas fa-map me-2"></i>State/Province
                        </label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" name="{{ $type }}[address][postalCode]" class="form-control" id="{{ $type }}Postal"
                            placeholder="Postal Code" value="91706">
                        <label for="{{ $type }}Postal">
                            <i class="fas fa-mail-bulk me-2"></i>Postal Code
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>