<!-- Add Household Modal with Examples -->
<div class="modal fade" id="householdModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content gov-modal">
            <!-- HEADER -->
            <div class="modal-header gov-modal-header">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= base_url('public/assets/img/') . ($system_information['official_logo'] ?? 'default_logo.png') . '?v=' . env('APP_VERSION') ?>" alt="Barangay Logo" class="gov-modal-logo">
                    <div>
                        <h5 class="modal-title mb-0">HOUSEHOLD RECORD</h5>
                        <small class="gov-modal-subtitle">
                            Barangay <?= ucfirst($system_information['barangay_name']) ?> Household Information System
                        </small>
                    </div>
                </div>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- FORM -->
            <form id="household_form">
                <div class="modal-body gov-modal-body">
                    <!-- HOUSEHOLD DETAILS -->
                    <div class="gov-section">
                        <div class="gov-section__label">Household Details</div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control gov-input" id="household_id" placeholder="Household ID" required>
                                    <label for="household_id">Household ID</label>
                                </div>
                                <small class="info-text text-truncate" data-tooltip="Unique ID, e.g., #001, #002, used to track each household.">
                                    Unique identifier (e.g., #001)
                                </small>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="household_purok" required>
                                        <option value="" selected disabled>-- Select One --</option>
                                        <option>Purok 1</option>
                                        <option>Purok 2</option>
                                    </select>
                                    <label for="household_purok">Purok / Zone</label>
                                </div>
                                <small class="info-text text-truncate" data-tooltip="The administrative area of the household. Example: Purok 1, Purok 2.">
                                    Area of household (e.g., Purok 1)
                                </small>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control gov-input" id="household_address" placeholder="Address">
                                    <label for="household_address">Address (Optional)</label>
                                </div>
                                <small class="info-text text-truncate" data-tooltip="Full address: street, barangay, or landmark. Example: 123 Rizal St., Barangay Cansangaya.">
                                    Full address (e.g., 123 Rizal St.)
                                </small>
                            </div>

                        </div>
                    </div>

                    <!-- HOUSING & FACILITIES -->
                    <div class="gov-section">
                        <div class="gov-section__label">Housing & Facilities</div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="housing_type" required>
                                        <option value="" disabled selected>-- Select One --</option>
                                        <option>Concrete</option>
                                        <option>Semi-concrete</option>
                                        <option>Wood</option>
                                    </select>
                                    <label for="housing_type">Housing Type</label>
                                </div>
                                <small class="info-text text-truncate" data-tooltip="Material of the house. Example: Concrete, Semi-concrete, Wood.">
                                    Material type (e.g., Concrete)
                                </small>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="comfort_room" required>
                                        <option value="" disabled selected>-- Select One --</option>
                                        <option>Owned</option>
                                        <option>Shared</option>
                                        <option>None</option>
                                    </select>
                                    <label for="comfort_room">Comfort Room</label>
                                </div>
                                <small class="info-text text-truncate" data-tooltip="Type of toilet facility. Example: Owned, Shared with neighbors, None.">
                                    Toilet facility (e.g., Owned)
                                </small>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="water_access" required>
                                        <option value="" disabled selected>-- Select One --</option>
                                        <option>Level 1</option>
                                        <option>Level 2</option>
                                        <option>Level 3</option>
                                    </select>
                                    <label for="water_access">Water System</label>
                                </div>
                                <small class="info-text text-truncate" data-tooltip="Water service level. Example: Level 1 (point source), Level 2 (shared faucet), Level 3 (private household).">
                                    Water service (e.g., Level 2)
                                </small>
                            </div>

                        </div>
                    </div>

                    <!-- SYSTEM NOTE -->
                    <div class="gov-meta">
                        <i class="fa-solid fa-circle-info me-2"></i>
                        Household members and socio-economic classifications (e.g., PWD, 4Ps, livelihood)
                        will be managed under the <strong>Residents</strong> and related modules.
                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer gov-modal-footer">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                    <button class="btn gov-btn-primary px-4">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Save Household
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>