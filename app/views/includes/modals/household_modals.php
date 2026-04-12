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
                <div class="modal-body gov-modal-body">
                    <!-- HOUSEHOLD DETAILS -->
                    <div class="gov-section">
                        <div class="gov-section__label">Household Details</div>
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
                                    data-tooltip="System-generated unique code per household. Format: PRK##-#### (Purok + sequence number).">
                                    Auto-generated (e.g., PRK01-0001)
                                </small>
                            </div>

                            <!-- PUROK -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="household_purok" required>
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
                                        name="household_address"
                                        placeholder="Address">
                                    <label>Address (Optional)</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- HOUSING & FACILITIES -->
                    <div class="gov-section">
                        <div class="gov-section__label">Housing & Facilities</div>
                        <div class="row g-3">
                            <!-- HOUSING TYPE -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input"
                                        id="household_housing_type"
                                        name="household_housing_type" required>
                                        <option value="" disabled selected>-- Select One --</option>
                                        <option value="Concrete">Concrete</option>
                                        <option value="Semi-concrete">Semi-concrete</option>
                                        <option value="Wood">Wood</option>
                                    </select>
                                    <label>Housing Type</label>
                                </div>
                            </div>

                            <!-- COMFORT ROOM -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input"
                                        id="household_comfort_room"
                                        name="household_comfort_room" required>
                                        <option value="" disabled selected>-- Select One --</option>
                                        <option value="Owned">Owned</option>
                                        <option value="Shared">Shared</option>
                                        <option value="None">None</option>
                                    </select>
                                    <label>Comfort Room</label>
                                </div>
                            </div>

                            <!-- WATER System -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input"
                                        id="household_water_system"
                                        name="household_water_system" required>
                                        <option value="" disabled selected>-- Select One --</option>
                                        <option value="Level 1">Level 1</option>
                                        <option value="Level 2">Level 2</option>
                                        <option value="Level 3">Level 3</option>
                                    </select>
                                    <label>Water System</label>
                                </div>
                                <small class="info-text"
                                    data-tooltip="• Level 1: Point source (well/spring) • Level 2: Communal faucet • Level 3: Household connection">
                                    Water service (e.g., Level 2)
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
                    <input type="hidden" id="edit_household_id">
                    <input type="hidden" id="edit_original_household_household_code">
                    <input type="hidden" id="edit_original_household_purok">
                    
                    <!-- HOUSEHOLD DETAILS -->
                    <div class="gov-section">
                        <div class="gov-section__label">Household Details</div>
                        <div class="row g-3">

                            <!-- HOUSEHOLD CODE -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control gov-input"
                                        id="edit_household_household_code"
                                        name="edit_household_household_code"
                                        placeholder="Household Code"
                                        readonly required>
                                    <label>Household Code</label>
                                </div>
                                <small class="info-text"
                                    data-tooltip="System-generated unique code per household. Format: PRK##-#### (Purok + sequence number).">
                                    Auto-generated (e.g., PRK01-0001)
                                </small>
                            </div>

                            <!-- PUROK -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="edit_household_purok" required>
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
                                        name="edit_household_address"
                                        placeholder="Address">
                                    <label>Address (Optional)</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- HOUSING & FACILITIES -->
                    <div class="gov-section">
                        <div class="gov-section__label">Housing & Facilities</div>
                        <div class="row g-3">
                            <!-- HOUSING TYPE -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input"
                                        id="edit_household_housing_type"
                                        name="edit_household_housing_type" required>
                                        <option value="Concrete">Concrete</option>
                                        <option value="Semi-concrete">Semi-concrete</option>
                                        <option value="Wood">Wood</option>
                                    </select>
                                    <label>Housing Type</label>
                                </div>
                            </div>

                            <!-- COMFORT ROOM -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input"
                                        id="edit_household_comfort_room"
                                        name="edit_household_comfort_room" required>
                                        <option value="Owned">Owned</option>
                                        <option value="Shared">Shared</option>
                                        <option value="None">None</option>
                                    </select>
                                    <label>Comfort Room</label>
                                </div>
                            </div>

                            <!-- WATER System -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input"
                                        id="edit_household_water_system"
                                        name="edit_household_water_system" required>
                                        <option value="Level 1">Level 1</option>
                                        <option value="Level 2">Level 2</option>
                                        <option value="Level 3">Level 3</option>
                                    </select>
                                    <label>Water System</label>
                                </div>
                                <small class="info-text" data-tooltip="• Level 1: Point source (well/spring) • Level 2: Communal faucet • Level 3: Household connection">
                                    Water service (e.g., Level 2)
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