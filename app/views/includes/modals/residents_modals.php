<!-- VIEW RESIDENT MODAL -->
<div class="modal fade" id="view_resident_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content gov-modal">

            <!-- HEADER -->
            <div class="modal-header gov-modal-header">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= base_url('public/assets/img/') . ($system_information['official_logo'] ?? 'default_logo.png') . '?v=' . env('APP_VERSION') ?>" alt="Barangay Logo" class="gov-modal-logo">
                    <div>
                        <h5 class="modal-title mb-0">VIEW RESIDENT RECORD</h5>
                        <small class="gov-modal-subtitle">
                            Barangay <?= ucfirst($system_information['barangay_name']) ?> Household Information System
                        </small>
                    </div>
                </div>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body gov-modal-body">
                <!-- RECORD HEADER -->
                <div class="panel mb-3">
                    <div class="panel-body d-flex justify-content-between align-items-center flex-wrap gap-2">

                        <div>
                            <h5 class="fw-bold mb-1" id="view_resident_fullname">
                                Juan Dela Cruz
                            </h5>
                            <div class="text-muted small" id="view_resident_household">
                                Resident Profile Record
                            </div>
                        </div>

                        <div class="text-end">
                            <div class="small text-muted">Status</div>
                            <div class="fw-semibold" id="view_resident_status">Active</div>
                        </div>

                    </div>
                </div>

                <!-- PERSONAL INFORMATION -->
                <div class="gov-section">
                    <div class="gov-section__label">Personal Information</div>

                    <div class="panel">
                        <div class="panel-body p-0">
                            <table class="table mb-0 align-middle">
                                <tbody>

                                    <tr>
                                        <td class="text-muted" style="width:40%;">First Name</td>
                                        <td id="view_resident_first_name" class="fw-semibold">Juan</td>
                                    </tr>

                                    <tr>
                                        <td class="text-muted">Middle Name</td>
                                        <td id="view_resident_middle_name" class="fw-semibold text-muted">N/A</td>
                                    </tr>

                                    <tr>
                                        <td class="text-muted">Last Name</td>
                                        <td id="view_resident_last_name" class="fw-semibold">Dela Cruz</td>
                                    </tr>

                                    <tr>
                                        <td class="text-muted">Sex</td>
                                        <td id="view_resident_sex" class="fw-semibold">Male</td>
                                    </tr>

                                    <tr>
                                        <td class="text-muted">Birthdate</td>
                                        <td id="view_resident_birthdate" class="fw-semibold">1995-01-01</td>
                                    </tr>

                                    <tr>
                                        <td class="text-muted">Age</td>
                                        <td id="view_resident_age" class="fw-semibold">30</td>
                                    </tr>

                                    <tr>
                                        <td class="text-muted">Civil Status</td>
                                        <td id="view_resident_civil_status" class="fw-semibold">Single</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- HOUSEHOLD INFORMATION -->
                <div class="gov-section">
                    <div class="gov-section__label">Household Assignment</div>

                    <div class="panel">
                        <div class="panel-body p-0">
                            <table class="table mb-0 align-middle">
                                <tbody>

                                    <tr>
                                        <td class="text-muted" style="width:40%;">Household</td>
                                        <td id="view_resident_household" class="fw-semibold">PRK01-0001</td>
                                    </tr>

                                    <tr>
                                        <td class="text-muted">Purok</td>
                                        <td id="view_resident_purok" class="fw-semibold">Purok 1</td>
                                    </tr>

                                    <tr>
                                        <td class="text-muted">Relationship</td>
                                        <td id="view_resident_relationship" class="fw-semibold">Head</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- RECORD STATUS -->
                <div class="gov-section">
                    <div class="gov-section__label">Record Status</div>

                    <div class="panel">
                        <div class="panel-body">

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Current Status</span>
                                <span class="pill" id="view_resident_status_pill">Active</span>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- FOOT NOTE -->
                <div class="gov-meta mt-3">
                    <i class="fa-solid fa-circle-info me-2"></i>
                    Resident records are linked to household profiles in the system.
                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer gov-modal-footer">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

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