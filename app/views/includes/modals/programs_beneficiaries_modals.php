<!-- Add Beneficiary Modal -->
<div class="modal fade" id="add_beneficiary_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content gov-modal">

            <!-- HEADER -->
            <div class="modal-header gov-modal-header">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= base_url('public/assets/img/') . ($system_information['official_logo'] ?? 'default_logo.png') . '?v=' . env('APP_VERSION') ?>" class="gov-modal-logo">
                    <div>
                        <h5 class="modal-title mb-0">ADD BENEFICIARY</h5>
                        <small class="gov-modal-subtitle">
                            Barangay <?= ucfirst($system_information['barangay_name']) ?> Management System
                        </small>
                    </div>
                </div>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- FORM -->
            <form id="add_beneficiary_form">
                <!-- BODY -->
                <div class="modal-body gov-modal-body">

                    <!-- BENEFICIARY INFORMATION -->
                    <div class="gov-section">
                        <div class="gov-section__label">
                            Beneficiary Information
                        </div>

                        <div class="row g-3">
                            <!-- PROGRAM -->
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="add_program_id" required>
                                        <option value="" disabled selected>-- Select One --</option>
                                        <!-- Populate dynamically -->
                                        <?php foreach ($all_programs as $program): ?>
                                            <option value="<?= $program['id'] ?>"><?= $program['program_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label>Program</label>
                                </div>
                                <small class="info-text" data-tooltip="Choose the program where the resident will be enrolled.">
                                    Program Assignment
                                </small>
                            </div>
                            <!-- RESIDENT -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="add_resident_id" required>
                                        <option value="" disabled selected>-- Select One --</option>
                                        <!-- Populate dynamically -->
                                        <?php foreach ($all_residents as $resident): ?>
                                            <option value="<?= $resident['id'] ?>"><?= $resident['last_name'] ?>, <?= $resident['first_name'] ?>     <?= $resident['middle_name'] ? ucfirst($resident['middle_name'][0]) . '.' : '' ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label>Resident</label>
                                </div>
                                <small class="info-text" data-tooltip="Select the resident to enroll in the chosen program.">
                                    Resident Record
                                </small>
                            </div>
                            <!-- STATUS -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="add_status">
                                        <option value="" disabled selected>-- Select One --</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                    <label>Status</label>
                                </div>
                                <small class="info-text" data-tooltip="Active beneficiaries are currently participating in the program.">
                                    Beneficiary Status
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- META NOTE -->
                    <div class="gov-meta">
                        <i class="fa-solid fa-circle-info me-2"></i>
                        Each resident can only be enrolled once per program. Duplicate enrollments are prevented by the database.
                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer gov-modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>

                    <button type="submit" class="btn gov-btn-primary">
                        <i class="fa-solid fa-floppy-disk me-2"></i>
                        Save Beneficiary
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- Update Beneficiary Modal -->
<div class="modal fade" id="update_beneficiary_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content gov-modal">

            <!-- HEADER -->
            <div class="modal-header gov-modal-header">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= base_url('public/assets/img/') . ($system_information['official_logo'] ?? 'default_logo.png') . '?v=' . env('APP_VERSION') ?>" class="gov-modal-logo">
                    <div>
                        <h5 class="modal-title mb-0">ADD BENEFICIARY</h5>
                        <small class="gov-modal-subtitle">
                            Barangay <?= ucfirst($system_information['barangay_name']) ?> Management System
                        </small>
                    </div>
                </div>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- FORM -->
            <form id="update_beneficiary_form">
                <!-- BODY -->
                <div class="modal-body gov-modal-body">

                    <!-- BENEFICIARY INFORMATION -->
                    <div class="gov-section">
                        <div class="gov-section__label">
                            Beneficiary Information
                        </div>

                        <div class="row g-3">
                            <input type="hidden" id="update_beneficiary_id" name="beneficiary_id">

                            <!-- PROGRAM -->
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="update_program_id" required>
                                        <option value="" disabled selected>-- Select One --</option>
                                        <!-- Populate dynamically -->
                                        <?php foreach ($all_programs as $program): ?>
                                            <option value="<?= $program['id'] ?>"><?= $program['program_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label>Program</label>
                                </div>
                                <small class="info-text" data-tooltip="Choose the program where the resident will be enrolled.">
                                    Program Assignment
                                </small>
                            </div>
                            <!-- RESIDENT -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="update_resident_id" required>
                                        <option value="" disabled selected>-- Select One --</option>
                                        <!-- Populate dynamically -->
                                        <?php foreach ($all_residents as $resident): ?>
                                            <option value="<?= $resident['id'] ?>"><?= $resident['last_name'] ?>, <?= $resident['first_name'] ?>     <?= $resident['middle_name'] ? ucfirst($resident['middle_name'][0]) . '.' : '' ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label>Resident</label>
                                </div>
                                <small class="info-text" data-tooltip="Select the resident to enroll in the chosen program.">
                                    Resident Record
                                </small>
                            </div>
                            <!-- STATUS -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="update_status">
                                        <option value="" disabled selected>-- Select One --</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                    <label>Status</label>
                                </div>
                                <small class="info-text" data-tooltip="Active beneficiaries are currently participating in the program.">
                                    Beneficiary Status
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- META NOTE -->
                    <div class="gov-meta">
                        <i class="fa-solid fa-circle-info me-2"></i>
                        Each resident can only be enrolled once per program. Duplicate enrollments are prevented by the database.
                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer gov-modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>

                    <button type="submit" class="btn gov-btn-primary">
                        <i class="fa-solid fa-floppy-disk me-2"></i>
                        Save Beneficiary
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>