<!-- Add Birth Record Modal -->
<div class="modal fade" id="add_birth_record_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content gov-modal">

            <!-- HEADER -->
            <div class="modal-header gov-modal-header">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= base_url('public/assets/img/') . ($system_information['official_logo'] ?? 'default_logo.png') . '?v=' . env('APP_VERSION') ?>" class="gov-modal-logo">

                    <div>
                        <h5 class="modal-title mb-0">ADD BIRTH RECORD</h5>

                        <small class="gov-modal-subtitle">
                            Barangay <?= ucfirst($system_information['barangay_name']) ?> Management System
                        </small>
                    </div>
                </div>

                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>


            <!-- FORM -->
            <form id="add_birth_record_form">

                <!-- BODY -->
                <div class="modal-body gov-modal-body">

                    <!-- BIRTH INFORMATION -->
                    <div class="gov-section">

                        <div class="gov-section__label">
                            Birth Information
                        </div>

                        <div class="row g-3">

                            <!-- CHILD -->
                            <div class="col-md-6">
                                <div class="form-floating">

                                    <select class="form-select gov-input" id="add_birth_record_child_resident_id" required>

                                        <option value="" disabled selected>
                                            -- Select One --
                                        </option>

                                        <?php foreach ($all_residents as $resident): ?>

                                            <option value="<?= $resident['id'] ?>">

                                                <?= $resident['last_name'] ?>,
                                                <?= $resident['first_name'] ?>

                                                <?= !empty($resident['middle_name'])
                                                    ? ' ' . ucfirst($resident['middle_name'][0]) . '.'
                                                    : ''
                                                    ?>

                                            </option>

                                        <?php endforeach; ?>

                                    </select>

                                    <label>Child</label>

                                </div>

                                <small class="info-text" data-tooltip="Select the resident who is registered as the child in this birth record.">
                                    Child Resident
                                </small>
                            </div>


                            <!-- MOTHER -->
                            <div class="col-md-6">
                                <div class="form-floating">

                                    <select class="form-select gov-input" id="add_birth_record_mother_resident_id" required>

                                        <option value="" disabled selected>
                                            -- Select One --
                                        </option>

                                        <?php foreach ($all_residents as $resident): ?>

                                            <option value="<?= $resident['id'] ?>">

                                                <?= $resident['last_name'] ?>,
                                                <?= $resident['first_name'] ?>

                                                <?= !empty($resident['middle_name'])
                                                    ? ' ' . ucfirst($resident['middle_name'][0]) . '.'
                                                    : ''
                                                    ?>

                                            </option>

                                        <?php endforeach; ?>

                                    </select>

                                    <label>Mother</label>

                                </div>

                                <small class="info-text" data-tooltip="Select the resident who is registered as the mother of the child.">
                                    Mother Resident
                                </small>
                            </div>


                            <!-- DATE OF BIRTH -->
                            <div class="col-md-6">
                                <div class="form-floating">

                                    <input type="date" class="form-control gov-input" id="add_birth_record_date_of_birth" readonly required>

                                    <label>Date of Birth</label>

                                </div>

                                <small class="info-text" data-tooltip="Enter the official date of birth of the child.">
                                    Birth Date
                                </small>
                            </div>


                            <!-- SEX -->
                            <div class="col-md-6">
                                <div class="form-floating">

                                    <select class="form-select gov-input" id="add_birth_record_sex" disabled required>

                                        <option value="" disabled selected>
                                            -- Select One --
                                        </option>

                                        <option value="Male">
                                            Male
                                        </option>

                                        <option value="Female">
                                            Female
                                        </option>

                                    </select>

                                    <label>Sex</label>

                                </div>

                                <small class="info-text" data-tooltip="Select the biological sex recorded for the child.">
                                    Child Sex
                                </small>
                            </div>

                        </div>

                    </div>


                    <!-- META NOTE -->
                    <div class="gov-meta">

                        <i class="fa-solid fa-circle-info me-2"></i>

                        Birth records should contain the registered child, the mother, the official date of birth, and the child's sex.

                    </div>

                </div>


                <!-- FOOTER -->
                <div class="modal-footer gov-modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>


                    <button type="submit" class="btn gov-btn-primary">

                        <i class="fa-solid fa-floppy-disk me-2"></i>

                        Save Birth Record

                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

<!-- Edit Birth Record Modal -->
<div class="modal fade" id="edit_birth_record_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content gov-modal">

            <!-- HEADER -->
            <div class="modal-header gov-modal-header">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= base_url('public/assets/img/') . ($system_information['official_logo'] ?? 'default_logo.png') . '?v=' . env('APP_VERSION') ?>" class="gov-modal-logo">

                    <div>
                        <h5 class="modal-title mb-0">ADD BIRTH RECORD</h5>

                        <small class="gov-modal-subtitle">
                            Barangay <?= ucfirst($system_information['barangay_name']) ?> Management System
                        </small>
                    </div>
                </div>

                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>


            <!-- FORM -->
            <form id="edit_birth_record_form">

                <!-- BODY -->
                <div class="modal-body gov-modal-body">

                <input type="hidden" id="edit_birth_record_id" name="edit_birth_record_id">

                    <!-- BIRTH INFORMATION -->
                    <div class="gov-section">

                        <div class="gov-section__label">
                            Birth Information
                        </div>

                        <div class="row g-3">

                            <!-- CHILD -->
                            <div class="col-md-6">
                                <div class="form-floating">

                                    <select class="form-select gov-input" id="edit_birth_record_child_resident_id" required>
                                        <?php foreach ($all_residents as $resident): ?>

                                            <option value="<?= $resident['id'] ?>">

                                                <?= $resident['last_name'] ?>,
                                                <?= $resident['first_name'] ?>

                                                <?= !empty($resident['middle_name'])
                                                    ? ' ' . ucfirst($resident['middle_name'][0]) . '.'
                                                    : ''
                                                    ?>

                                            </option>

                                        <?php endforeach; ?>

                                    </select>

                                    <label>Child</label>

                                </div>

                                <small class="info-text" data-tooltip="Select the resident who is registered as the child in this birth record.">
                                    Child Resident
                                </small>
                            </div>


                            <!-- MOTHER -->
                            <div class="col-md-6">
                                <div class="form-floating">

                                    <select class="form-select gov-input" id="edit_birth_record_mother_resident_id" required>
                                        <?php foreach ($all_residents as $resident): ?>

                                            <option value="<?= $resident['id'] ?>">

                                                <?= $resident['last_name'] ?>,
                                                <?= $resident['first_name'] ?>

                                                <?= !empty($resident['middle_name'])
                                                    ? ' ' . ucfirst($resident['middle_name'][0]) . '.'
                                                    : ''
                                                    ?>

                                            </option>

                                        <?php endforeach; ?>

                                    </select>

                                    <label>Mother</label>

                                </div>

                                <small class="info-text" data-tooltip="Select the resident who is registered as the mother of the child.">
                                    Mother Resident
                                </small>
                            </div>


                            <!-- DATE OF BIRTH -->
                            <div class="col-md-6">
                                <div class="form-floating">

                                    <input type="date" class="form-control gov-input" id="edit_birth_record_date_of_birth" readonly required>

                                    <label>Date of Birth</label>

                                </div>

                                <small class="info-text" data-tooltip="Enter the official date of birth of the child.">
                                    Birth Date
                                </small>
                            </div>


                            <!-- SEX -->
                            <div class="col-md-6">
                                <div class="form-floating">

                                    <select class="form-select gov-input" id="edit_birth_record_sex" disabled required>
                                        <option value="Male">
                                            Male
                                        </option>

                                        <option value="Female">
                                            Female
                                        </option>

                                    </select>

                                    <label>Sex</label>

                                </div>

                                <small class="info-text" data-tooltip="Select the biological sex recorded for the child.">
                                    Child Sex
                                </small>
                            </div>

                        </div>

                    </div>


                    <!-- META NOTE -->
                    <div class="gov-meta">

                        <i class="fa-solid fa-circle-info me-2"></i>

                        Birth records should contain the registered child, the mother, the official date of birth, and the child's sex.

                    </div>

                </div>


                <!-- FOOTER -->
                <div class="modal-footer gov-modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>


                    <button type="submit" class="btn gov-btn-primary">

                        <i class="fa-solid fa-floppy-disk me-2"></i>

                        Update Birth Record

                    </button>

                </div>

            </form>

        </div>
    </div>
</div>