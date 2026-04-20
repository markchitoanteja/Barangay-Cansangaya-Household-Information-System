<!-- Add Socio-Economic Profile Modal -->
<div class="modal fade" id="socioEconomicModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content gov-modal">
            <!-- HEADER -->
            <div class="modal-header gov-modal-header">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= base_url('public/assets/img/') . ($system_information['official_logo'] ?? 'default_logo.png') . '?v=' . env('APP_VERSION') ?>" class="gov-modal-logo">
                    <div>
                        <h5 class="modal-title mb-0">ADD SOCIO-ECONOMIC PROFILE</h5>
                        <small class="gov-modal-subtitle">
                            Barangay <?= ucfirst($system_information['barangay_name']) ?> Household Information System
                        </small>
                    </div>
                </div>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- FORM -->
            <form id="socio_economic_form">
                <!-- BODY -->
                <div class="modal-body gov-modal-body">
                    <!-- RESIDENT -->
                    <div class="gov-section">
                        <div class="gov-section__label">Resident Information</div>

                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="add_socio_economic_resident_id" required>
                                        <option value="" disabled selected>-- Select One --</option>
                                        <?php foreach ($residents_selection as $resident): ?>
                                            <option value="<?= $resident['id'] ?>"><?= $resident['last_name'] ?>, <?= $resident['first_name'] ?> <?= $resident['middle_name'] ? ucfirst($resident['middle_name'][0]) . '.' : '' ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label>Resident</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- EMPLOYMENT -->
                    <div class="gov-section">
                        <div class="gov-section__label">Employment Information</div>

                        <div class="row g-3">
                            <!-- OCCUPATION -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control gov-input" id="add_socio_economic_occupation" placeholder="Occupation" required>
                                    <label>Occupation</label>
                                </div>
                            </div>

                            <!-- EMPLOYMENT STATUS -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="add_socio_economic_employment_status" required>
                                        <option value="" disabled selected>-- Select One --</option>
                                        <option value="Employed">Employed</option>
                                        <option value="Unemployed">Unemployed</option>
                                        <option value="Self-employed">Self-employed</option>
                                        <option value="Student">Student</option>
                                        <option value="Retired">Retired</option>
                                    </select>
                                    <label>Employment Status</label>
                                </div>
                            </div>

                            <!-- MONTHLY INCOME -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="number" step="0.01" class="form-control gov-input" id="add_socio_economic_monthly_income" placeholder="Monthly Income" required>
                                    <label>Monthly Income (₱)</label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- EDUCATION -->
                    <div class="gov-section">
                        <div class="gov-section__label">Education</div>

                        <div class="row g-3">

                            <!-- EDUCATION LEVEL -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="add_socio_economic_education_level" required>
                                        <option value="" disabled selected>-- Select One --</option>
                                        <option value="None">None</option>
                                        <option value="Elementary">Elementary</option>
                                        <option value="High School">High School</option>
                                        <option value="Senior High">Senior High</option>
                                        <option value="College">College</option>
                                        <option value="Postgraduate">Postgraduate</option>
                                    </select>
                                    <label>Education Level</label>
                                </div>
                            </div>

                            <!-- LITERACY -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="add_socio_economic_literacy_status" required>
                                        <option value="" disabled selected>-- Select One --</option>
                                        <option value="1">Literate</option>
                                        <option value="0">Not Literate</option>
                                    </select>
                                    <label>Literacy Status</label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- META NOTE -->
                    <div class="gov-meta">
                        <i class="fa-solid fa-circle-info me-2"></i>
                        This data is used for profiling, reporting, and program targeting.
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="modal-footer gov-modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn gov-btn-primary">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Save Profile
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Edit Socio-Economic Profile Modal -->
<div class="modal fade" id="editSocioEconomicModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content gov-modal">
            <!-- HEADER -->
            <div class="modal-header gov-modal-header">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= base_url('public/assets/img/') . ($system_information['official_logo'] ?? 'default_logo.png') . '?v=' . env('APP_VERSION') ?>" class="gov-modal-logo">
                    <div>
                        <h5 class="modal-title mb-0">UPDATE SOCIO-ECONOMIC PROFILE</h5>
                        <small class="gov-modal-subtitle">
                            Barangay <?= ucfirst($system_information['barangay_name']) ?> Household Information System
                        </small>
                    </div>
                </div>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- FORM -->
            <form id="edit_socio_economic_form">
                <!-- BODY -->
                <div class="modal-body gov-modal-body">
                    <input type="hidden" id="edit_socio_economic_id">

                    <!-- RESIDENT -->
                    <div class="gov-section">
                        <div class="gov-section__label">Resident Information</div>

                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="edit_socio_economic_resident_id" required disabled>
                                        <?php foreach ($residents as $resident): ?>
                                            <option value="<?= $resident['id'] ?>"><?= $resident['first_name'] ?> <?= $resident['last_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label>Resident</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- EMPLOYMENT -->
                    <div class="gov-section">
                        <div class="gov-section__label">Employment Information</div>

                        <div class="row g-3">
                            <!-- OCCUPATION -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control gov-input" id="edit_socio_economic_occupation" placeholder="Occupation" required>
                                    <label>Occupation</label>
                                </div>
                            </div>

                            <!-- EMPLOYMENT STATUS -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="edit_socio_economic_employment_status" required>
                                        <option value="Employed">Employed</option>
                                        <option value="Unemployed">Unemployed</option>
                                        <option value="Self-employed">Self-employed</option>
                                        <option value="Student">Student</option>
                                        <option value="Retired">Retired</option>
                                    </select>
                                    <label>Employment Status</label>
                                </div>
                            </div>

                            <!-- MONTHLY INCOME -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="number" step="0.01" class="form-control gov-input" id="edit_socio_economic_monthly_income" placeholder="Monthly Income" required>
                                    <label>Monthly Income (₱)</label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- EDUCATION -->
                    <div class="gov-section">
                        <div class="gov-section__label">Education</div>

                        <div class="row g-3">
                            <!-- EDUCATION LEVEL -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="edit_socio_economic_education_level" required>
                                        <option value="None">None</option>
                                        <option value="Elementary">Elementary</option>
                                        <option value="High School">High School</option>
                                        <option value="Senior High">Senior High</option>
                                        <option value="College">College</option>
                                        <option value="Postgraduate">Postgraduate</option>
                                    </select>
                                    <label>Education Level</label>
                                </div>
                            </div>

                            <!-- LITERACY -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select gov-input" id="edit_socio_economic_literacy_status" required>
                                        <option value="1">Literate</option>
                                        <option value="0">Not Literate</option>
                                    </select>
                                    <label>Literacy Status</label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- META NOTE -->
                    <div class="gov-meta">
                        <i class="fa-solid fa-circle-info me-2"></i>
                        This data is used for profiling, reporting, and program targeting.
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="modal-footer gov-modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn gov-btn-primary">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Save Profile
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>