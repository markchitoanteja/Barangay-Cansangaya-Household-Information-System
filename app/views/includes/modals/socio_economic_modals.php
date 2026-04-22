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