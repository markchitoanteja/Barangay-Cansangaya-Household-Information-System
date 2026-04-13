<!-- ADD RESIDENT MODAL -->
<div class="modal fade" id="add_resident_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content gov-modal">

            <!-- HEADER -->
            <div class="modal-header gov-modal-header">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= base_url('public/assets/img/') . ($system_information['official_logo'] ?? 'default_logo.png') . '?v=' . env('APP_VERSION') ?>" alt="Barangay Logo" class="gov-modal-logo">
                    <div>
                        <h5 class="modal-title mb-0">ADD RESIDENT RECORD</h5>
                        <small class="gov-modal-subtitle">
                            Barangay <?= ucfirst($system_information['barangay_name']) ?> Household Information System
                        </small>
                    </div>
                </div>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- FORM -->
            <form id="add_resident_form">
                <div class="modal-body gov-modal-body">
                    <!-- PERSONAL INFORMATION -->
                    <div class="gov-section">
                        <div class="gov-section__label">Personal Information</div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control gov-input" id="add_resident_first_name" placeholder="First Name" required>
                                    <label>First Name</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control gov-input" id="add_resident_middle_name" placeholder="Middle Name">
                                    <label>Middle Name (Optional)</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control gov-input" id="add_resident_last_name" placeholder="Last Name" required>
                                    <label>Last Name</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="add_resident_sex" required>
                                        <option value="" disabled selected>-- Select One --</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                    <label>Sex</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control gov-input" id="add_resident_birthdate" required>
                                    <label>Birthdate</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control gov-input" id="add_resident_age" placeholder="Age" readonly required>
                                    <label>Age (Auto)</label>
                                </div>
                                <small class="info-text" data-tooltip="Auto Generated based on birthdate. Will be updated if birthdate is edited.">
                                    Auto Generated (e.g., 24 years old)
                                </small>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="add_resident_civil_status">
                                        <option value="" disabled selected>-- Select One --</option>
                                        <option>Single</option>
                                        <option>Married</option>
                                        <option>Widowed</option>
                                        <option>Separated</option>
                                    </select>
                                    <label>Civil Status</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- HOUSEHOLD LINK -->
                    <div class="gov-section">
                        <div class="gov-section__label">Household Assignment</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="add_resident_household_id" required>
                                        <option value="" disabled selected>-- Select One --</option>
                                        <?php foreach ($households_unfiltered as $household): ?>
                                            <option value="<?= esc($household['id']) ?>">
                                                <?= esc($household['household_code']) ?> - <?= esc($household['purok']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label>Household</label>
                                </div>
                                <small class="info-text" data-tooltip="Select a household to assign this resident to. Only active households are available for selection.">
                                    Assign resident to a household record.
                                </small>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="add_resident_relationship">
                                        <option value="" disabled selected>-- Select One --</option>
                                        <option>Head</option>
                                        <option>Spouse</option>
                                        <option>Child</option>
                                        <option>Relative</option>
                                        <option>Other</option>
                                    </select>
                                    <label>Relationship to Head</label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="modal-footer gov-modal-footer">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                    <button class="btn gov-btn-primary px-4">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Save Resident
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- EDIT RESIDENT MODAL -->
<div class="modal fade" id="edit_resident_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content gov-modal">

            <!-- HEADER -->
            <div class="modal-header gov-modal-header">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= base_url('public/assets/img/') . ($system_information['official_logo'] ?? 'default_logo.png') . '?v=' . env('APP_VERSION') ?>" alt="Barangay Logo" class="gov-modal-logo">
                    <div>
                        <h5 class="modal-title mb-0">UPDATE RESIDENT RECORD</h5>
                        <small class="gov-modal-subtitle">
                            Barangay <?= ucfirst($system_information['barangay_name']) ?> Household Information System
                        </small>
                    </div>
                </div>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- FORM -->
            <form id="edit_resident_form">
                <div class="modal-body gov-modal-body">
                    <input type="hidden" id="edit_resident_id">

                    <!-- PERSONAL INFORMATION -->
                    <div class="gov-section">
                        <div class="gov-section__label">Personal Information</div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control gov-input" id="edit_resident_first_name" placeholder="First Name" required>
                                    <label>First Name</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control gov-input" id="edit_resident_middle_name" placeholder="Middle Name">
                                    <label>Middle Name (Optional)</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control gov-input" id="edit_resident_last_name" placeholder="Last Name" required>
                                    <label>Last Name</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="edit_resident_sex" required>
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                    <label>Sex</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control gov-input" id="edit_resident_birthdate" required>
                                    <label>Birthdate</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control gov-input" id="edit_resident_age" placeholder="Age" readonly required>
                                    <label>Age (Auto)</label>
                                </div>
                                <small class="info-text" data-tooltip="Auto Generated based on birthdate. Will be updated if birthdate is edited.">
                                    Auto Generated (e.g., 24 years old)
                                </small>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="edit_resident_civil_status">
                                        <option>Single</option>
                                        <option>Married</option>
                                        <option>Widowed</option>
                                        <option>Separated</option>
                                    </select>
                                    <label>Civil Status</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- HOUSEHOLD LINK -->
                    <div class="gov-section">
                        <div class="gov-section__label">Household Assignment</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="edit_resident_household_id" required>
                                        <?php foreach ($households_unfiltered as $household): ?>
                                            <option value="<?= esc($household['id']) ?>">
                                                <?= esc($household['household_code']) ?> - <?= esc($household['purok']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label>Household</label>
                                </div>
                                <small class="info-text" data-tooltip="Select a household to assign this resident to. Only active households are available for selection.">
                                    Assign resident to a household record.
                                </small>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="edit_resident_relationship">
                                        <option>Head</option>
                                        <option>Spouse</option>
                                        <option>Child</option>
                                        <option>Relative</option>
                                        <option>Other</option>
                                    </select>
                                    <label>Relationship to Head</label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="modal-footer gov-modal-footer">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                    <button class="btn gov-btn-primary px-4">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Save Resident
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>