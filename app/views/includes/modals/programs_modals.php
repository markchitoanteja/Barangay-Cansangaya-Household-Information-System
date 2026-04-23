<!-- VIEW SOCIO-ECONOMIC PROFILE MODAL -->
<div class="modal fade" id="view_socio_economic_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content gov-modal">

            <!-- HEADER -->
            <div class="modal-header gov-modal-header">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= base_url('public/assets/img/') . ($system_information['official_logo'] ?? 'default_logo.png') . '?v=' . env('APP_VERSION') ?>"
                        class="gov-modal-logo">
                    <div>
                        <h5 class="modal-title mb-0">VIEW SOCIO-ECONOMIC PROFILE</h5>
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
                            <h5 class="fw-bold mb-1" id="view_socio_fullname">
                                Juan Dela Cruz
                            </h5>
                            <div class="text-muted small" id="view_socio_household">
                                Socio-Economic Profile Record
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RESIDENT INFORMATION -->
                <div class="gov-section">
                    <div class="gov-section__label">Resident Information</div>

                    <div class="panel">
                        <div class="panel-body p-0">
                            <table class="table mb-0 align-middle">
                                <tbody>
                                    <tr>
                                        <td class="text-muted" style="width:40%;">Resident</td>
                                        <td id="view_socio_resident" class="fw-semibold">Dela Cruz, Juan M.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- EMPLOYMENT INFORMATION -->
                <div class="gov-section">
                    <div class="gov-section__label">Employment Information</div>

                    <div class="panel">
                        <div class="panel-body p-0">
                            <table class="table mb-0 align-middle">
                                <tbody>

                                    <tr>
                                        <td class="text-muted" style="width:40%;">Occupation</td>
                                        <td id="view_socio_occupation" class="fw-semibold">Farmer</td>
                                    </tr>

                                    <tr>
                                        <td class="text-muted">Employment Status</td>
                                        <td id="view_socio_employment_status" class="fw-semibold">Employed</td>
                                    </tr>

                                    <tr>
                                        <td class="text-muted">Monthly Income</td>
                                        <td id="view_socio_monthly_income" class="fw-semibold">₱ 12,000.00</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- EDUCATION -->
                <div class="gov-section">
                    <div class="gov-section__label">Education</div>

                    <div class="panel">
                        <div class="panel-body p-0">
                            <table class="table mb-0 align-middle">
                                <tbody>

                                    <tr>
                                        <td class="text-muted" style="width:40%;">Education Level</td>
                                        <td id="view_socio_education_level" class="fw-semibold">High School</td>
                                    </tr>

                                    <tr>
                                        <td class="text-muted">Literacy Status</td>
                                        <td id="view_socio_literacy_status" class="fw-semibold">Literate</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- META NOTE -->
                <div class="gov-meta mt-3">
                    <i class="fa-solid fa-circle-info me-2"></i>
                    This data is used for profiling, reporting, and program targeting.
                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer gov-modal-footer">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<!-- Add Program Modal -->
<div class="modal fade" id="add_program_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content gov-modal">

            <!-- HEADER -->
            <div class="modal-header gov-modal-header">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= base_url('public/assets/img/') . ($system_information['official_logo'] ?? 'default_logo.png') . '?v=' . env('APP_VERSION') ?>" class="gov-modal-logo">
                    <div>
                        <h5 class="modal-title mb-0">ADD PROGRAM</h5>
                        <small class="gov-modal-subtitle">
                            Barangay <?= ucfirst($system_information['barangay_name']) ?> Management System
                        </small>
                    </div>
                </div>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- FORM -->
            <form id="add_program_form">
                <!-- BODY -->
                <div class="modal-body gov-modal-body">
                    <!-- PROGRAM INFORMATION -->
                    <div class="gov-section">
                        <div class="gov-section__label">Program Information</div>

                        <div class="row g-3">
                            <!-- PROGRAM NAME -->
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control gov-input"
                                        id="add_program_name"
                                        placeholder="Program Name"
                                        required>
                                    <label>Program Name</label>
                                </div>
                                <small class="info-text"
                                    data-tooltip="Official name used in records, reports, and tracking. Avoid abbreviations unless commonly recognized.">
                                    Official Program Name (e.g., Feeding Program 2026)
                                </small>
                            </div>

                            <!-- DESCRIPTION -->
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <textarea class="form-control gov-input"
                                        id="add_program_description"
                                        placeholder="Program Description"
                                        style="height: 120px;"></textarea>
                                    <label>Description (Optional)</label>
                                </div>
                                <small class="info-text"
                                    data-tooltip="Provide objectives, target beneficiaries, schedule, and scope. Useful for monitoring and reporting.">
                                    Program Details (e.g., Monthly feeding for children ages 3–6)
                                </small>
                            </div>

                        </div>
                    </div>

                    <!-- META NOTE -->
                    <div class="gov-meta">
                        <i class="fa-solid fa-circle-info me-2"></i>
                        Programs can later be linked to residents, activities, or reports.
                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer gov-modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn gov-btn-primary">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Save Program
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Edit Program Modal -->
<div class="modal fade" id="edit_program_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content gov-modal">

            <!-- HEADER -->
            <div class="modal-header gov-modal-header">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= base_url('public/assets/img/') . ($system_information['official_logo'] ?? 'default_logo.png') . '?v=' . env('APP_VERSION') ?>" class="gov-modal-logo">
                    <div>
                        <h5 class="modal-title mb-0">EDIT PROGRAM</h5>
                        <small class="gov-modal-subtitle">
                            Barangay <?= ucfirst($system_information['barangay_name']) ?> Management System
                        </small>
                    </div>
                </div>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- FORM -->
            <form id="edit_program_form">
                <input type="hidden" id="edit_program_id">
                <!-- BODY -->
                <div class="modal-body gov-modal-body">
                    <!-- PROGRAM INFORMATION -->
                    <div class="gov-section">
                        <div class="gov-section__label">Program Information</div>

                        <div class="row g-3">
                            <!-- PROGRAM NAME -->
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control gov-input"
                                        id="edit_program_name"
                                        placeholder="Program Name"
                                        required>
                                    <label>Program Name</label>
                                </div>
                                <small class="info-text"
                                    data-tooltip="Official name used in records, reports, and tracking. Avoid abbreviations unless commonly recognized.">
                                    Official Program Name (e.g., Feeding Program 2026)
                                </small>
                            </div>

                            <!-- DESCRIPTION -->
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <textarea class="form-control gov-input"
                                        id="edit_program_description"
                                        placeholder="Program Description"
                                        style="height: 120px;"></textarea>
                                    <label>Description (Optional)</label>
                                </div>
                                <small class="info-text"
                                    data-tooltip="Provide objectives, target beneficiaries, schedule, and scope. Useful for monitoring and reporting.">
                                    Program Details (e.g., Monthly feeding for children ages 3–6)
                                </small>
                            </div>

                        </div>
                    </div>

                    <!-- META NOTE -->
                    <div class="gov-meta">
                        <i class="fa-solid fa-circle-info me-2"></i>
                        Programs can later be linked to residents, activities, or reports.
                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer gov-modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn gov-btn-primary">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Save Program
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>