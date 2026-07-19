<!-- View Health Record Modal -->
<div class="modal fade" id="viewHealthRecordModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content gov-modal">

            <!-- HEADER -->
            <div class="modal-header gov-modal-header">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= base_url('public/assets/img/') . ($system_information['official_logo'] ?? 'default_logo.png') . '?v=' . env('APP_VERSION') ?>" class="gov-modal-logo">

                    <div>
                        <h5 class="modal-title mb-0">VIEW HEALTH RECORD</h5>
                        <small class="gov-modal-subtitle">
                            Barangay
                            <?= ucfirst($system_information['barangay_name']) ?> Health Information System
                        </small>
                    </div>
                </div>

                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body gov-modal-body">

                <!-- RESIDENT INFORMATION -->
                <div class="panel mb-3">
                    <div class="panel-body">

                        <div class="row align-items-center g-2">

                            <div class="col-md-8">
                                <h5 class="fw-bold mb-1" id="view_health_resident_name">
                                    Juan Dela Cruz
                                </h5>

                                <div class="text-muted small">
                                    Resident ID:
                                    <span id="view_health_resident_id">00001</span>
                                </div>
                            </div>

                            <div class="col-md-4 text-md-end">
                                <div class="small text-muted">
                                    Blood Type
                                </div>

                                <div class="fw-semibold" id="view_health_blood_type">
                                    O+
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <!-- HEALTH DETAILS -->
                <div class="panel">
                    <div class="panel-body p-0">

                        <table class="table mb-0 align-middle">

                            <thead>
                                <tr>
                                    <th colspan="2" class="bg-light text-uppercase small">
                                        Health Information
                                    </th>
                                </tr>
                            </thead>

                            <tbody>

                                <tr>
                                    <td class="text-muted" style="width:40%;">
                                        Person With Disability (PWD)
                                    </td>
                                    <td id="view_health_is_pwd" class="fw-semibold">
                                        Yes
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-muted">
                                        Senior Citizen
                                    </td>
                                    <td id="view_health_is_senior" class="fw-semibold">
                                        No
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-muted">
                                        Vaccinated
                                    </td>
                                    <td id="view_health_vaccinated" class="fw-semibold">
                                        Yes
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-muted">
                                        Has Chronic Illness
                                    </td>
                                    <td id="view_health_has_chronic_illness" class="fw-semibold">
                                        No
                                    </td>
                                </tr>

                                <tr id="view_chronic_details_row">
                                    <td class="text-muted">
                                        Chronic Illness Details
                                    </td>
                                    <td id="view_health_chronic_illness_details" class="fw-semibold">
                                        Hypertension, Diabetes Mellitus
                                    </td>
                                </tr>

                            </tbody>

                        </table>

                    </div>
                </div>

                <!-- RECORD INFORMATION -->
                <div class="panel mt-3">
                    <div class="panel-body p-0">

                        <table class="table mb-0">

                            <thead>
                                <tr>
                                    <th colspan="2" class="bg-light text-uppercase small">
                                        Record Information
                                    </th>
                                </tr>
                            </thead>

                            <tbody>

                                <tr>
                                    <td class="text-muted" style="width:40%;">
                                        Date Created
                                    </td>
                                    <td id="view_health_created_at" class="fw-semibold">
                                        July 19, 2026 2:30 PM
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-muted">
                                        Last Updated
                                    </td>
                                    <td id="view_health_updated_at" class="fw-semibold">
                                        July 20, 2026 9:12 AM
                                    </td>
                                </tr>

                            </tbody>

                        </table>

                    </div>
                </div>

                <!-- FOOT NOTE -->
                <div class="gov-meta mt-3">
                    <i class="fa-solid fa-circle-info me-2"></i>
                    This health record is linked to the resident profile. Updates made here will reflect the resident's latest health information.
                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer gov-modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>

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
                                    <select class="form-select gov-input" id="add_health_record_resident_id" name="resident_id" required>

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
                                    <select class="form-select gov-input" id="add_health_record_is_pwd" name="is_pwd" required>

                                        <option value="" selected disabled>-- Select One --</option>
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>

                                    </select>

                                    <label>Person With Disability (PWD)</label>
                                </div>
                            </div>

                            <!-- Senior -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="add_health_record_is_senior" name="is_senior" required>

                                        <option value="" selected disabled>-- Select One --</option>
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>

                                    </select>

                                    <label>Senior Citizen</label>
                                </div>
                            </div>

                            <!-- Vaccinated -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="add_health_record_vaccinated" name="vaccinated" required>

                                        <option value="" selected disabled>-- Select One --</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>

                                    </select>

                                    <label>Vaccinated</label>
                                </div>
                            </div>

                            <!-- Blood Type -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="add_health_record_blood_type" name="blood_type" required>

                                        <option value="" selected disabled>-- Select One --</option>
                                        <option value="Unknown">Unknown</option>
                                        <option value="A+">A+</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B-">B-</option>
                                        <option value="AB+">AB+</option>
                                        <option value="AB-">AB-</option>
                                        <option value="O+">O+</option>
                                        <option value="O-">O-</option>

                                    </select>

                                    <label>Blood Type</label>
                                </div>
                            </div>

                            <!-- Chronic Illness -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="add_health_record_has_chronic_illness" name="has_chronic_illness" required>

                                        <option value="" selected disabled>-- Select One --</option>
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>

                                    </select>

                                    <label>Has Chronic Illness</label>
                                </div>
                            </div>

                            <!-- Chronic Illness Details -->
                            <div class="col-md-12" id="chronic_illness_container">
                                <div class="form-floating">
                                    <textarea class="form-control gov-input" id="add_health_record_chronic_illness_details" name="chronic_illness_details" style="height:120px" placeholder="Describe illness..." disabled></textarea>

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

<!-- Edit Health Record Modal -->
<div class="modal fade" id="editHealthRecordModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content gov-modal">

            <!-- HEADER -->
            <div class="modal-header gov-modal-header">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= base_url('public/assets/img/') . ($system_information['official_logo'] ?? 'default_logo.png') . '?v=' . env('APP_VERSION') ?>" class="gov-modal-logo">

                    <div>
                        <h5 class="modal-title mb-0">EDIT HEALTH RECORD</h5>
                        <small class="gov-modal-subtitle">
                            Barangay <?= ucfirst($system_information['barangay_name']) ?> Management System
                        </small>
                    </div>
                </div>

                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- FORM -->
            <form id="edit_health_record_form">

                <div class="modal-body gov-modal-body">

                    <input type="hidden" name="health_record_id" id="edit_health_record_id">

                    <!-- RESIDENT -->
                    <div class="gov-section">

                        <div class="gov-section__label">
                            Resident Information
                        </div>

                        <div class="row g-3">

                            <div class="col-md-12">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="edit_health_record_resident_id" name="resident_id" required>

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
                                    <select class="form-select gov-input" id="edit_health_record_is_pwd" name="is_pwd" required>

                                        <option value="" selected disabled>-- Select One --</option>
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>

                                    </select>

                                    <label>Person With Disability (PWD)</label>
                                </div>
                            </div>

                            <!-- Senior -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="edit_health_record_is_senior" name="is_senior" required>

                                        <option value="" selected disabled>-- Select One --</option>
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>

                                    </select>

                                    <label>Senior Citizen</label>
                                </div>
                            </div>

                            <!-- Vaccinated -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="edit_health_record_vaccinated" name="vaccinated" required>

                                        <option value="" selected disabled>-- Select One --</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>

                                    </select>

                                    <label>Vaccinated</label>
                                </div>
                            </div>

                            <!-- Blood Type -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="edit_health_record_blood_type" name="blood_type" required>

                                        <option value="" selected disabled>-- Select One --</option>
                                        <option value="Unknown">Unknown</option>
                                        <option value="A+">A+</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B-">B-</option>
                                        <option value="AB+">AB+</option>
                                        <option value="AB-">AB-</option>
                                        <option value="O+">O+</option>
                                        <option value="O-">O-</option>

                                    </select>

                                    <label>Blood Type</label>
                                </div>
                            </div>

                            <!-- Chronic Illness -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="edit_health_record_has_chronic_illness" name="has_chronic_illness" required>

                                        <option value="" selected disabled>-- Select One --</option>
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>

                                    </select>

                                    <label>Has Chronic Illness</label>
                                </div>
                            </div>

                            <!-- Chronic Illness Details -->
                            <div class="col-md-12" id="chronic_illness_container">
                                <div class="form-floating">
                                    <textarea class="form-control gov-input" id="edit_health_record_chronic_illness_details" name="chronic_illness_details" style="height:120px" placeholder="Describe illness..." disabled></textarea>

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
                        Update Health Record

                    </button>

                </div>

            </form>

        </div>
    </div>
</div>