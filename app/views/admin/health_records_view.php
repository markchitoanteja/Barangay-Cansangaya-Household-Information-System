<section class="panel">
    <!-- PANEL HEADER -->
    <div class="panel-header d-flex justify-content-between align-items-center mb-3">
        <h5><i class="fa-solid fa-house me-2"></i>List of Health Records</h5>
        <button class="btn gov-btn-primary" data-bs-toggle="modal" data-bs-target="#healthRecordModal">
            <i class="fa-solid fa-plus me-2"></i>Add Health Record
        </button>
    </div>

    <!-- PANEL BODY -->
    <div class="panel-body mb-3">
        <!-- FILTERS -->
        <form id="healthRecordSearchForm" action="javascript:void(0)" class="row g-2 mb-3">
            <div class="col-md-5"></div>
            <div class="col-md-4 d-flex flex-column">
                <div class="form-floating flex-grow-1">
                    <input type="text" name="search_input" class="form-control gov-input" id="search_input" placeholder="Search User" value="<?= esc($search_input ?? '') ?>">
                    <label><i class="fa-solid fa-magnifying-glass me-1"></i>Search Resident Name</label>
                </div>
            </div>
            <div class="col-md-3 d-flex flex-column">
                <div class="row g-2 flex-grow-1">
                    <div class="col-6 d-flex">
                        <button type="submit" class="btn btn-primary flex-grow-1" id="search_filter_button">
                            <i class="fa-solid fa-magnifying-glass me-2"></i>Search
                        </button>
                    </div>
                    <div class="col-6 d-flex">
                        <button type="button" class="btn btn-outline-secondary flex-grow-1" data-url="health-records" id="reset_filter_button">
                            <i class="fa-solid fa-arrows-rotate me-2"></i>Reset
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- HOUSEHOLDS TABLE -->
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle border rounded">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">#</th>
                        <th>Resident</th>
                        <th>Is PWD</th>
                        <th>Is Senior Citizen</th>
                        <th>Has Chronic Illness</th>
                        <th>Blood Type</th>
                        <th>Vaccination Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($health_records)): ?>
                        <?php $counter = ($current_page - 1) * 10 + 1; ?>
                        <?php foreach ($health_records as $record): ?>
                            <tr>
                                <td class="text-center">
                                    <?= $counter ?>
                                </td>
                                <td>
                                    <?= esc($record['resident_name']) ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($record['is_pwd'] == "1"): ?>
                                        <span class="badge bg-success">Yes</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">No</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <?php if ($record['is_senior'] == "1"): ?>
                                        <span class="badge bg-primary">Yes</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">No</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <?php if ($record['has_chronic_illness'] == "1"): ?>
                                        <span class="badge bg-danger">Yes</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">No</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <span class="badge bg-dark">
                                        <?= esc($record['blood_type']) ?>
                                    </span>
                                </td>

                                <td class="text-center">
                                    <?php if ($record['vaccinated'] == "1"): ?>
                                        <span class="badge bg-success">
                                            <i class="fa-solid fa-check"></i> Vaccinated
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">
                                            <i class="fa-solid fa-xmark"></i> Not Vaccinated
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-success btn-view-health-record" title="View Health Record" data-bs-toggle="modal" data-bs-target="#viewHealthRecordModal" data-health_record='<?= json_encode($record) ?>'>
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary btn-edit-health-record" title="Edit Health Record" data-bs-toggle="modal" data-bs-target="#editHealthRecordModal" data-health_record='<?= json_encode($record) ?>'>
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php $counter++; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="text-center">
                            <td colspan="7">No Data Available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>