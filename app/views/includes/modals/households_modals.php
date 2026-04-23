<!-- View Household Modal -->
<div class="modal fade" id="viewHouseholdModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content gov-modal">

            <!-- HEADER -->
            <div class="modal-header gov-modal-header">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= base_url('public/assets/img/') . ($system_information['official_logo'] ?? 'default_logo.png') . '?v=' . env('APP_VERSION') ?>" class="gov-modal-logo">
                    <div>
                        <h5 class="modal-title mb-0">VIEW HOUSEHOLD RECORD</h5>
                        <small class="gov-modal-subtitle">
                            Barangay <?= ucfirst($system_information['barangay_name']) ?> Household Information System
                        </small>
                    </div>
                </div>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- FORM BODY -->
            <div class="modal-body gov-modal-body">

                <!-- RECORD HEADER -->
                <div class="panel mb-3">
                    <div class="panel-body">

                        <div class="row align-items-center g-2">
                            <div class="col-md-8">
                                <h5 class="fw-bold mb-1" id="view_household_household_code">
                                    #####-####
                                </h5>
                                <div class="text-muted small" id="view_household_address">
                                    ##### #, ##########
                                </div>
                            </div>

                            <div class="col-md-4 text-md-end">
                                <div class="small text-muted">Purok / Zone</div>
                                <div class="fw-semibold" id="view_household_purok">##### #</div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- MAIN RECORD TABLE -->
                <div class="panel">
                    <div class="panel-body p-0">
                        <table class="table mb-0 align-middle">
                            <!-- HOUSING -->
                            <thead>
                                <tr>
                                    <th colspan="2" class="bg-light text-uppercase small">
                                        Housing Information
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-muted" style="width: 40%;">Housing Type</td>
                                    <td id="view_household_housing_type" class="fw-semibold">#######</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Ownership Status</td>
                                    <td id="view_household_ownership_status" class="fw-semibold">#######</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Comfort Room</td>
                                    <td id="view_household_comfort_room" class="fw-semibold">#######</td>
                                </tr>
                            </tbody>

                            <!-- UTILITIES -->
                            <thead>
                                <tr>
                                    <th colspan="2" class="bg-light text-uppercase small">
                                        Basic Utilities
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-muted">Water System</td>
                                    <td id="view_household_water_system" class="fw-semibold">##### #</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Electricity Access</td>
                                    <td id="view_household_electricity_access" class="fw-semibold">###</td>
                                </tr>
                            </tbody>

                        </table>

                    </div>
                </div>

                <!-- FOOT NOTE -->
                <div class="gov-meta mt-3">
                    <i class="fa-solid fa-circle-info me-2"></i>
                    Household members are managed under <strong>Residents</strong>.
                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer gov-modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Household Modal -->
<div class="modal fade" id="householdModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content gov-modal">

            <!-- HEADER -->
            <div class="modal-header gov-modal-header">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= base_url('public/assets/img/') . ($system_information['official_logo'] ?? 'default_logo.png') . '?v=' . env('APP_VERSION') ?>" class="gov-modal-logo">
                    <div>
                        <h5 class="modal-title mb-0">ADD HOUSEHOLD RECORD</h5>
                        <small class="gov-modal-subtitle">
                            Barangay <?= ucfirst($system_information['barangay_name']) ?> Household Information System
                        </small>
                    </div>
                </div>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- FORM -->
            <form id="household_form">
                <!-- FORM BODY -->
                <div class="modal-body gov-modal-body">

                    <!-- HOUSEHOLD IDENTIFICATION -->
                    <div class="gov-section">
                        <div class="gov-section__label">Household Identification</div>

                        <div class="row g-3">

                            <!-- HOUSEHOLD CODE -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control gov-input"
                                        id="household_household_code"
                                        name="household_household_code"
                                        placeholder="Household Code"
                                        readonly required>
                                    <label>Household Code</label>
                                </div>
                                <small class="info-text"
                                    data-tooltip="System-generated unique code per household. Format: PRK##-####">
                                    Auto-generated (e.g., PRK01-0001)
                                </small>
                            </div>

                            <!-- PUROK -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input"
                                        id="household_purok"
                                        name="purok"
                                        required>
                                        <option value="" disabled selected>-- Select One --</option>
                                        <?php for ($i = 1; $i <= 7; $i++): ?>
                                            <option value="Purok <?= $i ?>">Purok <?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <label>Purok / Zone</label>
                                </div>
                            </div>

                            <!-- ADDRESS -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control gov-input"
                                        id="household_address"
                                        name="address"
                                        placeholder="Address">
                                    <label>Address (Optional)</label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- HOUSING INFORMATION -->
                    <div class="gov-section">
                        <div class="gov-section__label">Housing Information</div>

                        <div class="row g-3">

                            <!-- HOUSING TYPE -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input"
                                        id="household_housing_type"
                                        name="housing_type"
                                        required>
                                        <option value="" disabled selected>-- Select One --</option>
                                        <option value="Concrete">Concrete</option>
                                        <option value="Semi-concrete">Semi-concrete</option>
                                        <option value="Wood">Wood</option>
                                    </select>
                                    <label>Housing Type</label>
                                </div>
                            </div>

                            <!-- OWNERSHIP STATUS -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input"
                                        id="household_ownership_status"
                                        name="ownership_status">
                                        <option value="" disabled selected>-- Select One --</option>
                                        <option value="Owned">Owned</option>
                                        <option value="Rented">Rented</option>
                                        <option value="Informal Settler">Informal Settler</option>
                                    </select>
                                    <label>Ownership Status</label>
                                </div>
                            </div>

                            <!-- COMFORT ROOM -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input"
                                        id="household_comfort_room"
                                        name="comfort_room"
                                        required>
                                        <option value="" disabled selected>-- Select One --</option>
                                        <option value="Owned">Owned</option>
                                        <option value="Shared">Shared</option>
                                        <option value="None">None</option>
                                    </select>
                                    <label>Comfort Room</label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- BASIC UTILITIES -->
                    <div class="gov-section">
                        <div class="gov-section__label">Basic Utilities</div>

                        <div class="row g-3">

                            <!-- WATER SYSTEM -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select gov-input"
                                        id="household_water_system"
                                        name="water_system"
                                        required>
                                        <option value="" disabled selected>-- Select One --</option>
                                        <option value="Level 1">Level 1</option>
                                        <option value="Level 2">Level 2</option>
                                        <option value="Level 3">Level 3</option>
                                    </select>
                                    <label>Water System</label>
                                </div>
                                <small class="info-text"
                                    data-tooltip="Level 1: Well/Spring • Level 2: Communal faucet • Level 3: Household connection">
                                    Water service classification
                                </small>
                            </div>

                            <!-- ELECTRICITY -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select gov-input"
                                        id="household_electricity_access"
                                        name="electricity_access"
                                        required>
                                        <option value="" disabled selected>-- Select One --</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <label>Electricity Access</label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- NOTE -->
                    <div class="gov-meta">
                        <i class="fa-solid fa-circle-info me-2"></i>
                        Household members are managed under <strong>Residents</strong>.
                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer gov-modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn gov-btn-primary">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Save Household
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Edit Household Modal -->
<div class="modal fade" id="editHouseholdModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content gov-modal">
            <!-- HEADER -->
            <div class="modal-header gov-modal-header">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= base_url('public/assets/img/') . ($system_information['official_logo'] ?? 'default_logo.png') . '?v=' . env('APP_VERSION') ?>" class="gov-modal-logo">
                    <div>
                        <h5 class="modal-title mb-0">UPDATE HOUSEHOLD RECORD</h5>
                        <small class="gov-modal-subtitle">
                            Barangay <?= ucfirst($system_information['barangay_name']) ?> Household Information System
                        </small>
                    </div>
                </div>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- FORM -->
            <form id="edit_household_form">
                <div class="modal-body gov-modal-body">

                    <!-- HIDDEN FIELDS -->
                    <input type="hidden" id="edit_household_id">
                    <input type="hidden" id="edit_original_household_household_code">
                    <input type="hidden" id="edit_original_household_purok">

                    <!-- HOUSEHOLD IDENTIFICATION -->
                    <div class="gov-section">
                        <div class="gov-section__label">Household Identification</div>

                        <div class="row g-3">

                            <!-- HOUSEHOLD CODE -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control gov-input"
                                        id="edit_household_household_code"
                                        name="edit_household_household_code"
                                        readonly required>
                                    <label>Household Code</label>
                                </div>
                                <small class="info-text"
                                    data-tooltip="System-generated unique code per household. Format: PRK##-####">
                                    Auto-generated (e.g., PRK01-0001)
                                </small>
                            </div>

                            <!-- PUROK -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input"
                                        id="edit_household_purok"
                                        name="edit_purok"
                                        required>
                                        <?php for ($i = 1; $i <= 7; $i++): ?>
                                            <option value="Purok <?= $i ?>">Purok <?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <label>Purok / Zone</label>
                                </div>
                            </div>

                            <!-- ADDRESS -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control gov-input"
                                        id="edit_household_address"
                                        name="edit_address"
                                        placeholder="Address">
                                    <label>Address (Optional)</label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- HOUSING INFORMATION -->
                    <div class="gov-section">
                        <div class="gov-section__label">Housing Information</div>

                        <div class="row g-3">

                            <!-- HOUSING TYPE -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input"
                                        id="edit_household_housing_type"
                                        name="edit_housing_type"
                                        required>
                                        <option value="Concrete">Concrete</option>
                                        <option value="Semi-concrete">Semi-concrete</option>
                                        <option value="Wood">Wood</option>
                                    </select>
                                    <label>Housing Type</label>
                                </div>
                            </div>

                            <!-- OWNERSHIP STATUS -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input"
                                        id="edit_household_ownership_status"
                                        name="edit_ownership_status">
                                        <option value="Owned">Owned</option>
                                        <option value="Rented">Rented</option>
                                        <option value="Informal Settler">Informal Settler</option>
                                    </select>
                                    <label>Ownership Status</label>
                                </div>
                            </div>

                            <!-- COMFORT ROOM -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input"
                                        id="edit_household_comfort_room"
                                        name="edit_comfort_room"
                                        required>
                                        <option value="Owned">Owned</option>
                                        <option value="Shared">Shared</option>
                                        <option value="None">None</option>
                                    </select>
                                    <label>Comfort Room</label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- BASIC UTILITIES -->
                    <div class="gov-section">
                        <div class="gov-section__label">Basic Utilities</div>

                        <div class="row g-3">

                            <!-- WATER SYSTEM -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select gov-input"
                                        id="edit_household_water_system"
                                        name="edit_water_system"
                                        required>
                                        <option value="Level 1">Level 1</option>
                                        <option value="Level 2">Level 2</option>
                                        <option value="Level 3">Level 3</option>
                                    </select>
                                    <label>Water System</label>
                                </div>
                                <small class="info-text"
                                    data-tooltip="Level 1: Well/Spring • Level 2: Communal faucet • Level 3: Household connection">
                                    Water service classification
                                </small>
                            </div>

                            <!-- ELECTRICITY -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select gov-input"
                                        id="edit_household_electricity_access"
                                        name="edit_electricity_access"
                                        required>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <label>Electricity Access</label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- NOTE -->
                    <div class="gov-meta">
                        <i class="fa-solid fa-circle-info me-2"></i>
                        Household members are managed under <strong>Residents</strong>.
                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer gov-modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn gov-btn-primary">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>