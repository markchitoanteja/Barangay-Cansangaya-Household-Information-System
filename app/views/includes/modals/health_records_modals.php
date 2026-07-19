<!-- Add Health Record Modal -->
<div class="modal fade" id="healthRecordModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content gov-modal">

            <!-- HEADER -->
            <div class="modal-header gov-modal-header">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= base_url('public/assets/img/') . ($system_information['official_logo'] ?? 'default_logo.png') . '?v=' . env('APP_VERSION') ?>" class="gov-modal-logo">

                    <div>
                        <h5 class="modal-title mb-0">ADD HEALTH RECORD</h5>
                        <small class="gov-modal-subtitle">
                            Barangay <?= ucfirst($system_information['barangay_name']) ?> Management System
                        </small>
                    </div>
                </div>

                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- FORM -->
            <form id="add_health_record_form">

                <div class="modal-body gov-modal-body">

                    <!-- RESIDENT -->
                    <div class="gov-section">

                        <div class="gov-section__label">
                            Resident Information
                        </div>

                        <div class="row g-3">

                            <div class="col-md-12">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="add_resident_id" name="resident_id" required>

                                        <option value="" disabled selected>-- Select Resident --</option>

                                        <?php foreach ($all_residents as $resident): ?>
                                            <option value="<?= $resident['id'] ?>">
                                                <?= $resident['last_name'] ?>,
                                                <?= $resident['first_name'] ?>
                                                <?= $resident['middle_name']
                                                    ? ucfirst($resident['middle_name'][0]) . '.'
                                                    : '' ?>
                                            </option>
                                        <?php endforeach; ?>

                                    </select>

                                    <label>Resident</label>
                                </div>

                                <small class="info-text" data-tooltip="Select the resident whose health information will be recorded. A resident can only have one health record.">
                                    Select the resident whose health information will be recorded.
                                </small>
                            </div>

                        </div>

                    </div>

                    <!-- HEALTH INFORMATION -->
                    <div class="gov-section mt-4">

                        <div class="gov-section__label">
                            Health Information
                        </div>

                        <div class="row g-3">

                            <!-- PWD -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="is_pwd" name="is_pwd">

                                        <option value="0" selected>No</option>
                                        <option value="1">Yes</option>

                                    </select>

                                    <label>Person With Disability (PWD)</label>
                                </div>
                            </div>

                            <!-- Senior -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="is_senior" name="is_senior">

                                        <option value="0" selected>No</option>
                                        <option value="1">Yes</option>

                                    </select>

                                    <label>Senior Citizen</label>
                                </div>
                            </div>

                            <!-- Vaccinated -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="vaccinated" name="vaccinated">

                                        <option value="1">Yes</option>
                                        <option value="0" selected>No</option>

                                    </select>

                                    <label>Vaccinated</label>
                                </div>
                            </div>

                            <!-- Blood Type -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="blood_type" name="blood_type">

                                        <option value="">Unknown</option>
                                        <option>A+</option>
                                        <option>A-</option>
                                        <option>B+</option>
                                        <option>B-</option>
                                        <option>AB+</option>
                                        <option>AB-</option>
                                        <option>O+</option>
                                        <option>O-</option>

                                    </select>

                                    <label>Blood Type</label>
                                </div>
                            </div>

                            <!-- Chronic Illness -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="has_chronic_illness" name="has_chronic_illness">

                                        <option value="0" selected>No</option>
                                        <option value="1">Yes</option>

                                    </select>

                                    <label>Has Chronic Illness</label>
                                </div>
                            </div>

                            <!-- Chronic Illness Details -->
                            <div class="col-md-12" id="chronic_illness_container">
                                <div class="form-floating">
                                    <textarea class="form-control gov-input" id="chronic_illness_details" name="chronic_illness_details" style="height:120px" placeholder="Describe illness..." disabled></textarea>

                                    <label>Chronic Illness Details</label>
                                </div>

                                <small class="info-text" data-tooltip="Specify whether the resident has any long-term or chronic medical condition.">
                                    Specify the diagnosed chronic illness (e.g. Hypertension, Diabetes, Asthma).
                                </small>
                            </div>

                        </div>

                    </div>

                    <!-- NOTE -->
                    <div class="gov-meta mt-4">
                        <i class="fa-solid fa-circle-info me-2"></i>

                        Each resident can only have one health record. Attempting to add another record for the same resident will be rejected.
                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer gov-modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>

                    <button type="submit" class="btn gov-btn-primary">

                        <i class="fa-solid fa-floppy-disk me-2"></i>
                        Save Health Record

                    </button>

                </div>

            </form>

        </div>
    </div>
</div>