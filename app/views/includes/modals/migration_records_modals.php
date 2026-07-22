<!-- Add Migration Record Modal -->
<div class="modal fade" id="add_migration_record_modal" tabindex="-1">
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
                            ADD MIGRATION RECORD
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
            <form id="add_migration_record_form">

                <!-- BODY -->
                <div class="modal-body gov-modal-body">

                    <!-- MIGRATION INFORMATION -->
                    <div class="gov-section">

                        <div class="gov-section__label">
                            Migration Information
                        </div>

                        <div class="row g-3">

                            <!-- RESIDENT -->
                            <div class="col-md-12">

                                <div class="form-floating">

                                    <select class="form-select gov-input" id="add_migration_record_resident_id" required>

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

                                <small class="info-text" data-tooltip="Select the resident associated with this migration record.">
                                    Migrating Resident
                                </small>

                            </div>


                            <!-- MIGRATION TYPE -->
                            <div class="col-md-6">

                                <div class="form-floating">

                                    <select class="form-select gov-input" id="add_migration_record_migration_type" required>

                                        <option value="" disabled selected>
                                            -- Select One --
                                        </option>

                                        <option value="IN">
                                            IN - Migrated Into Barangay
                                        </option>

                                        <option value="OUT">
                                            OUT - Migrated Out of Barangay
                                        </option>

                                    </select>

                                    <label>Migration Type</label>

                                </div>

                                <small class="info-text" data-tooltip="Select whether the resident migrated into or out of the barangay.">
                                    Migration Direction
                                </small>

                            </div>


                            <!-- DATE OF MIGRATION -->
                            <div class="col-md-6">

                                <div class="form-floating">

                                    <input type="date" class="form-control gov-input" id="add_migration_record_date_of_migration" required>

                                    <label>Date of Migration</label>

                                </div>

                                <small class="info-text" data-tooltip="Enter the official date when the resident migrated.">
                                    Migration Date
                                </small>

                            </div>


                            <!-- ORIGIN -->
                            <div class="col-md-6">

                                <div class="form-floating">
                                    <input type="text" class="form-control gov-input" id="add_migration_record_origin" placeholder="Origin" readonly required>
                                    <label>Origin</label>
                                </div>

                                <small class="info-text" data-tooltip="Enter the place where the resident came from.">
                                    Previous Location
                                </small>

                            </div>


                            <!-- DESTINATION -->
                            <div class="col-md-6">

                                <div class="form-floating">

                                    <input type="text" class="form-control gov-input" id="add_migration_record_destination" placeholder="Destination" readonly required>

                                    <label>Destination</label>

                                </div>

                                <small class="info-text" data-tooltip="Enter the place where the resident moved to.">
                                    New Location
                                </small>

                            </div>

                        </div>

                    </div>


                    <!-- META NOTE -->
                    <div class="gov-meta">

                        <i class="fa-solid fa-circle-info me-2"></i>

                        Migration records should contain the resident, migration direction,
                        date of migration, and the relevant origin or destination.

                    </div>

                </div>


                <!-- FOOTER -->
                <div class="modal-footer gov-modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>


                    <button type="submit" class="btn gov-btn-primary">

                        <i class="fa-solid fa-floppy-disk me-2"></i>

                        Save Migration Record

                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

<!-- Edit Migration Record Modal -->
<div class="modal fade" id="edit_migration_record_modal" tabindex="-1">
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
                            EDIT MIGRATION RECORD
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
            <form id="edit_migration_record_form">
                <input type="hidden" id="edit_migration_record_id">

                <!-- BODY -->
                <div class="modal-body gov-modal-body">

                    <!-- MIGRATION INFORMATION -->
                    <div class="gov-section">

                        <div class="gov-section__label">
                            Migration Information
                        </div>

                        <div class="row g-3">

                            <!-- RESIDENT -->
                            <div class="col-md-12">

                                <div class="form-floating">

                                    <select class="form-select gov-input" id="edit_migration_record_resident_id" required>

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

                                <small class="info-text" data-tooltip="Select the resident associated with this migration record.">
                                    Migrating Resident
                                </small>

                            </div>


                            <!-- MIGRATION TYPE -->
                            <div class="col-md-6">

                                <div class="form-floating">

                                    <select class="form-select gov-input" id="edit_migration_record_migration_type" required>

                                        <option value="" disabled selected>
                                            -- Select One --
                                        </option>

                                        <option value="IN">
                                            IN - Migrated Into Barangay
                                        </option>

                                        <option value="OUT">
                                            OUT - Migrated Out of Barangay
                                        </option>

                                    </select>

                                    <label>Migration Type</label>

                                </div>

                                <small class="info-text" data-tooltip="Select whether the resident migrated into or out of the barangay.">
                                    Migration Direction
                                </small>

                            </div>


                            <!-- DATE OF MIGRATION -->
                            <div class="col-md-6">

                                <div class="form-floating">

                                    <input type="date" class="form-control gov-input" id="edit_migration_record_date_of_migration" required>

                                    <label>Date of Migration</label>

                                </div>

                                <small class="info-text" data-tooltip="Enter the official date when the resident migrated.">
                                    Migration Date
                                </small>

                            </div>


                            <!-- ORIGIN -->
                            <div class="col-md-6">

                                <div class="form-floating">
                                    <input type="text" class="form-control gov-input" id="edit_migration_record_origin" placeholder="Origin" readonly required>
                                    <label>Origin</label>
                                </div>

                                <small class="info-text" data-tooltip="Enter the place where the resident came from.">
                                    Previous Location
                                </small>

                            </div>


                            <!-- DESTINATION -->
                            <div class="col-md-6">

                                <div class="form-floating">

                                    <input type="text" class="form-control gov-input" id="edit_migration_record_destination" placeholder="Destination" readonly required>

                                    <label>Destination</label>

                                </div>

                                <small class="info-text" data-tooltip="Enter the place where the resident moved to.">
                                    New Location
                                </small>

                            </div>

                        </div>

                    </div>


                    <!-- META NOTE -->
                    <div class="gov-meta">

                        <i class="fa-solid fa-circle-info me-2"></i>

                        Migration records should contain the resident, migration direction,
                        date of migration, and the relevant origin or destination.

                    </div>

                </div>


                <!-- FOOTER -->
                <div class="modal-footer gov-modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>


                    <button type="submit" class="btn gov-btn-primary">

                        <i class="fa-solid fa-floppy-disk me-2"></i>

                        Update Migration Record

                    </button>

                </div>

            </form>

        </div>
    </div>
</div>