<!-- Add Death Record Modal -->
<div class="modal fade" id="add_death_record_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content gov-modal">

            <!-- HEADER -->
            <div class="modal-header gov-modal-header">
                <div class="d-flex align-items-center gap-3">

                    <img src="<?= base_url('public/assets/img/')
                        . ($system_information['official_logo'] ?? 'default_logo.png')
                        . '?v=' . env('APP_VERSION') ?>" class="gov-modal-logo">

                    <div>
                        <h5 class="modal-title mb-0">
                            ADD DEATH RECORD
                        </h5>

                        <small class="gov-modal-subtitle">
                            Barangay <?= ucfirst($system_information['barangay_name']) ?>
                            Management System
                        </small>
                    </div>

                </div>

                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>


            <!-- FORM -->
            <form id="add_death_record_form">
                <!-- BODY -->
                <div class="modal-body gov-modal-body">

                    <!-- DEATH INFORMATION -->
                    <div class="gov-section">

                        <div class="gov-section__label">
                            Death Information
                        </div>

                        <div class="row g-3">

                            <!-- RESIDENT -->
                            <div class="col-md-6">

                                <div class="form-floating">

                                    <select class="form-select gov-input" id="add_death_record_resident_id" required>

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

                                    <label>Resident</label>

                                </div>

                                <small class="info-text" data-tooltip="Select the resident associated with this death record.">
                                    Deceased Resident
                                </small>

                            </div>


                            <!-- DATE OF DEATH -->
                            <div class="col-md-6">

                                <div class="form-floating">

                                    <input type="date" class="form-control gov-input" id="add_death_record_date_of_death" required>

                                    <label>Date of Death</label>

                                </div>

                                <small class="info-text" data-tooltip="Enter the official date when the resident died.">
                                    Date of Death
                                </small>

                            </div>


                            <!-- CAUSE OF DEATH -->
                            <div class="col-md-6">

                                <div class="form-floating">

                                    <input type="text" class="form-control gov-input" id="add_death_record_cause_of_death" placeholder="Cause of Death" maxlength="255">

                                    <label>Cause of Death</label>

                                </div>

                                <small class="info-text" data-tooltip="Enter the medical or known cause of death.">
                                    Death Cause
                                </small>

                            </div>


                            <!-- MANNER OF DEATH -->
                            <div class="col-md-6">

                                <div class="form-floating">

                                    <input type="text" class="form-control gov-input" id="add_death_record_manner_of_death" placeholder="Manner of Death" maxlength="255">

                                    <label>Manner of Death</label>

                                </div>

                                <small class="info-text" data-tooltip="Enter how the death occurred, such as natural, accidental, suicidal, or homicidal.">
                                    Circumstances of Death
                                </small>

                            </div>

                        </div>

                    </div>


                    <!-- META NOTE -->
                    <div class="gov-meta">

                        <i class="fa-solid fa-circle-info me-2"></i>

                        Death records should contain the deceased resident,
                        date of death, and available information regarding
                        the cause and manner of death.

                    </div>

                </div>


                <!-- FOOTER -->
                <div class="modal-footer gov-modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>


                    <button type="submit" class="btn gov-btn-primary">

                        <i class="fa-solid fa-floppy-disk me-2"></i>

                        Save Death Record

                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

<!-- Edit Death Record Modal -->
<div class="modal fade" id="edit_death_record_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content gov-modal">

            <!-- HEADER -->
            <div class="modal-header gov-modal-header">
                <div class="d-flex align-items-center gap-3">

                    <img src="<?= base_url('public/assets/img/')
                        . ($system_information['official_logo'] ?? 'default_logo.png')
                        . '?v=' . env('APP_VERSION') ?>" class="gov-modal-logo">

                    <div>
                        <h5 class="modal-title mb-0">
                            EDIT DEATH RECORD
                        </h5>

                        <small class="gov-modal-subtitle">
                            Barangay
                            <?= ucfirst($system_information['barangay_name']) ?>
                            Management System
                        </small>
                    </div>

                </div>

                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>


            <!-- FORM -->
            <form id="edit_death_record_form">
                <input type="hidden" id="edit_death_record_id">
                <!-- BODY -->
                <div class="modal-body gov-modal-body">

                    <!-- DEATH INFORMATION -->
                    <div class="gov-section">

                        <div class="gov-section__label">
                            Death Information
                        </div>

                        <div class="row g-3">

                            <!-- RESIDENT -->
                            <div class="col-md-6">

                                <div class="form-floating">

                                    <select class="form-select gov-input" id="edit_death_record_resident_id" required>

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

                                    <label>Resident</label>

                                </div>

                                <small class="info-text" data-tooltip="Select the resident associated with this death record.">
                                    Deceased Resident
                                </small>

                            </div>


                            <!-- DATE OF DEATH -->
                            <div class="col-md-6">

                                <div class="form-floating">

                                    <input type="date" class="form-control gov-input" id="edit_death_record_date_of_death" required>

                                    <label>Date of Death</label>

                                </div>

                                <small class="info-text" data-tooltip="Enter the official date when the resident died.">
                                    Date of Death
                                </small>

                            </div>


                            <!-- CAUSE OF DEATH -->
                            <div class="col-md-6">

                                <div class="form-floating">

                                    <input type="text" class="form-control gov-input" id="edit_death_record_cause_of_death" placeholder="Cause of Death" maxlength="255">

                                    <label>Cause of Death</label>

                                </div>

                                <small class="info-text" data-tooltip="Enter the medical or known cause of death.">
                                    Death Cause
                                </small>

                            </div>


                            <!-- MANNER OF DEATH -->
                            <div class="col-md-6">

                                <div class="form-floating">

                                    <input type="text" class="form-control gov-input" id="edit_death_record_manner_of_death" placeholder="Manner of Death" maxlength="255">

                                    <label>Manner of Death</label>

                                </div>

                                <small class="info-text" data-tooltip="Enter how the death occurred, such as natural, accidental, suicidal, or homicidal.">
                                    Circumstances of Death
                                </small>

                            </div>

                        </div>

                    </div>


                    <!-- META NOTE -->
                    <div class="gov-meta">

                        <i class="fa-solid fa-circle-info me-2"></i>

                        Death records should contain the deceased resident,
                        date of death, and available information regarding
                        the cause and manner of death.

                    </div>

                </div>


                <!-- FOOTER -->
                <div class="modal-footer gov-modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>


                    <button type="submit" class="btn gov-btn-primary">

                        <i class="fa-solid fa-floppy-disk me-2"></i>

                        Update Death Record

                    </button>

                </div>

            </form>

        </div>
    </div>
</div>