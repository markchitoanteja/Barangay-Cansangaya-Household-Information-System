<!-- ADD RESIDENT MODAL -->
<div class="modal fade" id="residentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content gov-modal">

            <!-- HEADER -->
            <div class="modal-header gov-modal-header">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= base_url('public/assets/img/') . ($system_information['official_logo'] ?? 'default_logo.png') . '?v=' . env('APP_VERSION') ?>" alt="Barangay Logo" class="gov-modal-logo">
                    <div>
                        <h5 class="modal-title mb-0">RESIDENT RECORD</h5>
                        <small class="gov-modal-subtitle">
                            Barangay <?= ucfirst($system_information['barangay_name']) ?> Household Information System
                        </small>
                    </div>
                </div>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- FORM -->
            <form id="resident_form">
                <div class="modal-body gov-modal-body">

                    <!-- PERSONAL INFORMATION -->
                    <div class="gov-section">
                        <div class="gov-section__label">Personal Information</div>
                        <div class="row g-3">

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control gov-input" id="first_name" placeholder="First Name" required>
                                    <label>First Name</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control gov-input" id="middle_name" placeholder="Middle Name">
                                    <label>Middle Name (Optional)</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control gov-input" id="last_name" placeholder="Last Name" required>
                                    <label>Last Name</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="sex" required>
                                        <option value="" disabled selected>-- Select --</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                    <label>Sex</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control gov-input" id="birthdate" required>
                                    <label>Birthdate</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="number" class="form-control gov-input" id="age" placeholder="Age" readonly>
                                    <label>Age (Auto)</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="civil_status">
                                        <option value="" disabled selected>-- Select --</option>
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
                                    <select class="form-select gov-input" id="household_id" required>
                                        <option value="" disabled selected>-- Select Household --</option>
                                        <!-- dynamic -->
                                    </select>
                                    <label>Household</label>
                                </div>
                                <small class="info-text">
                                    Assign resident to a household record.
                                </small>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="relationship">
                                        <option value="" disabled selected>-- Select --</option>
                                        <option>Head</option>
                                        <option>Spouse</option>
                                        <option>Child</option>
                                        <option>Relative</option>
                                    </select>
                                    <label>Relationship to Head</label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- LIVELIHOOD -->
                    <div class="gov-section">
                        <div class="gov-section__label">Livelihood</div>
                        <div class="row g-3">

                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_farmer">
                                    <label class="form-check-label">Farmer</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_fisherfolk">
                                    <label class="form-check-label">Fisherfolk</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="has_sari_sari">
                                    <label class="form-check-label">Sari-sari Store Owner</label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- SOCIAL SECTORS -->
                    <div class="gov-section">
                        <div class="gov-section__label">Social Classification</div>
                        <div class="row g-3">

                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_pwd">
                                    <label class="form-check-label">PWD</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_solo_parent">
                                    <label class="form-check-label">Solo Parent</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_4ps">
                                    <label class="form-check-label">4Ps Beneficiary</label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- HEALTH MONITORING -->
                    <div class="gov-section">
                        <div class="gov-section__label">Health Monitoring</div>
                        <div class="row g-3">

                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="teen_pregnancy">
                                    <label class="form-check-label">
                                        Teenage Pregnancy Case
                                    </label>
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