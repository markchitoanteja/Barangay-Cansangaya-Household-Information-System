<!-- =========================================================
     VIEW HOUSEHOLD MODAL
========================================================= -->
<div class="modal fade" id="viewHouseholdResidentsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content gov-modal">

            <!-- =================================================
                 HEADER
            ================================================== -->
            <div class="modal-header gov-modal-header py-3">

                <div class="d-flex align-items-center gap-3">

                    <img src="<?= base_url('public/assets/img/') . ($system_information['official_logo'] ?? 'default_logo.png') . '?v=' . env('APP_VERSION') ?>" class="gov-modal-logo" alt="Barangay Logo">

                    <div>
                        <h5 class="modal-title mb-0">
                            HOUSEHOLD RECORD
                        </h5>

                        <small class="gov-modal-subtitle">
                            Barangay <?= ucfirst($system_information['barangay_name']) ?>
                            Household Information System
                        </small>
                    </div>

                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>

            </div>


            <!-- =================================================
                 BODY
            ================================================== -->
            <div class="modal-body gov-modal-body">

                <!-- =============================================
                     HOUSEHOLD IDENTITY
                ============================================== -->
                <div class="household-summary mb-3">

                    <div class="row align-items-center g-3">

                        <!-- HOUSEHOLD CODE -->
                        <div class="col-md-5">

                            <div class="text-muted text-uppercase small fw-semibold">
                                Household Code
                            </div>

                            <div id="view_household_household_code" class="fw-bold fs-5">
                                #####-####
                            </div>

                        </div>


                        <!-- ADDRESS -->
                        <div class="col-md-5">

                            <div class="text-muted text-uppercase small fw-semibold">
                                Address
                            </div>

                            <div id="view_household_address" class="fw-semibold">
                                ##### #, ##########
                            </div>

                        </div>


                        <!-- PUROK -->
                        <div class="col-md-2">

                            <div class="text-muted text-uppercase small fw-semibold">
                                Purok / Zone
                            </div>

                            <div id="view_household_purok" class="fw-semibold">
                                ##### #
                            </div>

                        </div>

                    </div>

                </div>


                <!-- =============================================
                     HOUSEHOLD DETAILS
                ============================================== -->
                <div class="row g-3 mb-3">

                    <!-- =========================================
                         HOUSEHOLD HEAD
                    ========================================== -->
                    <div class="col-lg-7">

                        <div class="compact-card h-100">

                            <!-- SECTION HEADER -->
                            <div class="compact-card-header">

                                <div class="d-flex align-items-center gap-2">

                                    <div class="compact-icon">
                                        <i class="fa-solid fa-user"></i>
                                    </div>

                                    <div>
                                        <div class="section-label">
                                            Household Head
                                        </div>

                                        <div class="section-description">
                                            Primary person responsible for this household
                                        </div>
                                    </div>

                                </div>

                            </div>


                            <!-- HEAD PROFILE -->
                            <div class="compact-card-body">

                                <div class="d-flex align-items-center gap-3 mb-3">

                                    <div class="household-head-avatar">
                                        <i class="fa-solid fa-user"></i>
                                    </div>

                                    <div class="flex-grow-1 min-width-0">

                                        <div class="d-flex align-items-center flex-wrap gap-2">

                                            <h5 id="view_household_head_name" class="fw-bold mb-0 text-truncate">
                                                ########## ##########
                                            </h5>

                                            <span id="view_household_head_status" class="badge rounded-pill bg-secondary">
                                                ########
                                            </span>

                                        </div>

                                        <div class="small text-muted">
                                            Household Head
                                        </div>

                                    </div>

                                </div>

                                <!-- HEAD INFORMATION -->
                                <div class="row g-2">

                                    <!-- SEX -->
                                    <div class="col-md-4">

                                        <div class="info-item">

                                            <div class="info-icon">
                                                <i class="fa-solid fa-venus-mars"></i>
                                            </div>

                                            <div>
                                                <div class="info-label">
                                                    Sex
                                                </div>

                                                <div id="view_household_head_sex" class="info-value">
                                                    ########
                                                </div>
                                            </div>

                                        </div>

                                    </div>


                                    <!-- BIRTHDATE -->
                                    <div class="col-md-4">

                                        <div class="info-item">

                                            <div class="info-icon">
                                                <i class="fa-solid fa-calendar-days"></i>
                                            </div>

                                            <div>
                                                <div class="info-label">
                                                    Birthdate
                                                </div>

                                                <div id="view_household_head_birthdate" class="info-value">
                                                    ##########
                                                </div>
                                            </div>

                                        </div>

                                    </div>


                                    <!-- CIVIL STATUS -->
                                    <div class="col-md-4">

                                        <div class="info-item">

                                            <div class="info-icon">
                                                <i class="fa-solid fa-heart"></i>
                                            </div>

                                            <div>
                                                <div class="info-label">
                                                    Civil Status
                                                </div>

                                                <div id="view_household_head_civil_status" class="info-value">
                                                    ########
                                                </div>
                                            </div>

                                        </div>

                                    </div>


                                    <!-- ACTION BUTTON -->
                                    <div class="col-12 mt-3">
                                        <button type="button" class="btn btn-sm btn-primary w-100 py-2 loadable" id="btn_view_household_head_programs">

                                            <i class="fa-solid fa-list-check me-1"></i>
                                            View Programs Listed

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- =========================================
                         HOUSEHOLD INFORMATION
                    ========================================== -->
                    <div class="col-lg-5">

                        <div class="compact-card h-100">

                            <div class="compact-card-header">

                                <div class="d-flex align-items-center gap-2">

                                    <div class="compact-icon">
                                        <i class="fa-solid fa-house"></i>
                                    </div>

                                    <div>
                                        <div class="section-label">
                                            Household Information
                                        </div>

                                        <div class="section-description">
                                            Housing and basic utilities
                                        </div>
                                    </div>

                                </div>

                            </div>


                            <div class="compact-card-body p-0">

                                <!-- HOUSING -->
                                <div class="detail-row">

                                    <span>
                                        Housing Type
                                    </span>

                                    <strong id="view_household_housing_type">
                                        #######
                                    </strong>

                                </div>


                                <!-- OWNERSHIP -->
                                <div class="detail-row">

                                    <span>
                                        Ownership Status
                                    </span>

                                    <strong id="view_household_ownership_status">
                                        #######
                                    </strong>

                                </div>


                                <!-- COMFORT ROOM -->
                                <div class="detail-row">

                                    <span>
                                        Comfort Room
                                    </span>

                                    <strong id="view_household_comfort_room">
                                        #######
                                    </strong>

                                </div>


                                <!-- WATER -->
                                <div class="detail-row">

                                    <span>
                                        Water System
                                    </span>

                                    <strong id="view_household_water_system">
                                        ##### #
                                    </strong>

                                </div>


                                <!-- ELECTRICITY -->
                                <div class="detail-row">

                                    <span>
                                        Electricity
                                    </span>

                                    <strong id="view_household_electricity_access">
                                        ###
                                    </strong>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- =============================================
                     MEMBERS TABLE
                ============================================== -->
                <div class="compact-card">

                    <!-- RESIDENT HEADER -->
                    <div class="compact-card-header">

                        <div class="d-flex align-items-center justify-content-between gap-3">

                            <div class="d-flex align-items-center gap-2">

                                <div class="compact-icon">
                                    <i class="fa-solid fa-people-group"></i>
                                </div>

                                <div>

                                    <div class="section-label">
                                        Household Members
                                    </div>

                                    <div class="section-description">
                                        Residents currently registered under this household
                                    </div>

                                </div>

                            </div>

                            <!-- OPTIONAL COUNT -->
                            <span id="view_household_residents_count" class="badge bg-light text-dark border">
                                0
                            </span>

                        </div>

                    </div>


                    <!-- RESIDENT TABLE -->
                    <div class="table-responsive household-residents-table">

                        <table class="table mb-0 align-middle">

                            <thead>

                                <tr>

                                    <th class="text-center" style="width: 55px;">
                                        #
                                    </th>

                                    <th>
                                        Name
                                    </th>

                                    <th>
                                        Relationship
                                    </th>

                                    <th>
                                        Sex
                                    </th>

                                    <th>
                                        Birthdate
                                    </th>

                                    <th>
                                        Civil Status
                                    </th>

                                </tr>

                            </thead>


                            <tbody id="view_household_residents_table_body">

                                <tr>

                                    <td colspan="6" class="text-center text-muted py-4">

                                        <i class="fa-solid fa-users-slash me-2"></i>
                                        No residents available.

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>


                <!-- =============================================
                     INFORMATION NOTE
                ============================================== -->
                <div class="gov-meta mt-3">

                    <i class="fa-solid fa-circle-info me-2"></i>

                    This record displays the household information,
                    household head, and residents currently registered
                    under this household.

                </div>

            </div>


            <!-- =================================================
                 FOOTER
            ================================================== -->
            <div class="modal-footer gov-modal-footer py-2">

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                    Close

                </button>

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
                                    <input type="text" class="form-control gov-input" id="household_household_code" name="household_household_code" placeholder="Household Code" readonly required>
                                    <label>Household Code</label>
                                </div>
                                <small class="info-text" data-tooltip="System-generated unique code per household. Format: PRK##-####">
                                    Auto-generated (e.g., PRK01-0001)
                                </small>
                            </div>

                            <!-- PUROK -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="household_purok" name="purok" required>
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
                                    <input type="text" class="form-control gov-input" id="household_address" name="address" placeholder="Address">
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
                                    <select class="form-select gov-input" id="household_housing_type" name="housing_type" required>
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
                                    <select class="form-select gov-input" id="household_ownership_status" name="ownership_status">
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
                                    <select class="form-select gov-input" id="household_comfort_room" name="comfort_room" required>
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
                                    <select class="form-select gov-input" id="household_water_system" name="water_system" required>
                                        <option value="" disabled selected>-- Select One --</option>
                                        <option value="Level 1: Well/Spring">Level 1: Well/Spring</option>
                                        <option value="Level 2: Communal faucet">Level 2: Communal faucet</option>
                                        <option value="Level 3: Household connection">Level 3: Household connection</option>
                                    </select>
                                    <label>Water System</label>
                                </div>
                                <small class="info-text" data-tooltip="Level 1: Well/Spring • Level 2: Communal faucet • Level 3: Household connection">
                                    Water service classification
                                </small>
                            </div>

                            <!-- ELECTRICITY -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="household_electricity_access" name="electricity_access" required>
                                        <option value="" disabled selected>-- Select One --</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <label>Electricity Access</label>
                                </div>
                                <small class="info-text" data-tooltip="Indicates whether the household has access to electricity or has its own electricity meter.">
                                    Electricity access classification
                                </small>
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
                                    <input type="text" class="form-control gov-input" id="edit_household_household_code" name="edit_household_household_code" readonly required>
                                    <label>Household Code</label>
                                </div>
                                <small class="info-text" data-tooltip="System-generated unique code per household. Format: PRK##-####">
                                    Auto-generated (e.g., PRK01-0001)
                                </small>
                            </div>

                            <!-- PUROK -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="edit_household_purok" name="edit_purok" required>
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
                                    <input type="text" class="form-control gov-input" id="edit_household_address" name="edit_address" placeholder="Address">
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
                                    <select class="form-select gov-input" id="edit_household_housing_type" name="edit_housing_type" required>
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
                                    <select class="form-select gov-input" id="edit_household_ownership_status" name="edit_ownership_status">
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
                                    <select class="form-select gov-input" id="edit_household_comfort_room" name="edit_comfort_room" required>
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
                                    <select class="form-select gov-input" id="edit_household_water_system" name="edit_water_system" required>
                                        <option value="Level 1: Well/Spring">Level 1: Well/Spring</option>
                                        <option value="Level 2: Communal faucet">Level 2: Communal faucet</option>
                                        <option value="Level 3: Household connection">Level 3: Household connection</option>
                                    </select>
                                    <label>Water System</label>
                                </div>
                                <small class="info-text" data-tooltip="Level 1: Well/Spring • Level 2: Communal faucet • Level 3: Household connection">
                                    Water service classification
                                </small>
                            </div>

                            <!-- ELECTRICITY -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="edit_household_electricity_access" name="edit_electricity_access" required>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <label>Electricity Access</label>
                                </div>
                                <small class="info-text" data-tooltip="Indicates whether the household has access to electricity or has its own electricity meter.">
                                    Electricity access classification
                                </small>
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