<section class="panel">
    <!-- PANEL HEADER -->
    <div class="panel-header d-flex justify-content-between align-items-center mb-3">
        <h5><i class="fa-solid fa-house me-2"></i>List of Beneficiaries</h5>
        <button class="btn gov-btn-primary" data-bs-toggle="modal" data-bs-target="#add_beneficiary_modal">
            <i class="fa-solid fa-plus me-2"></i>Add Beneficiary
        </button>
    </div>

    <!-- PANEL BODY -->
    <div class="panel-body mb-3">
        <!-- FILTERS -->
        <form id="socioEconomicSearchForm" action="javascript:void(0)" class="row g-2 mb-3">
            <div class="col-md-5"></div>
            <div class="col-md-4 d-flex flex-column">
                <div class="form-floating flex-grow-1">
                    <input type="text" name="search_input" class="form-control gov-input" id="search_input" placeholder="Search User" value="<?= esc($search_input ?? '') ?>">
                    <label><i class="fa-solid fa-magnifying-glass me-1"></i>Search Beneficiary Name</label>
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
                        <button type="button" class="btn btn-outline-secondary flex-grow-1" data-url="programs-beneficiaries" id="reset_filter_button">
                            <i class="fa-solid fa-arrows-rotate me-2"></i>Reset
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- PROGRAMS TABLE -->
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle border rounded">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">#</th>
                        <th>Beneficiary Name</th>
                        <th>Program</th>
                        <th>Date Enrolled</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($beneficiaries)): ?>
                        <?php $counter = ($current_page - 1) * 10 + 1; ?>

                        <?php foreach ($beneficiaries as $beneficiary): ?>
                            <tr>
                                <td class="text-center"><?= esc($counter++) ?></td>
                                <td><?= esc($beneficiary['beneficiary_name']) ?></td>
                                <td><?= esc($beneficiary['program_name'] ?? 'N/A') ?></td>
                                <?php
                                $date_raw = $beneficiary['date_enrolled'] ?? null;
                                $date_display = 'N/A';
                                if (!empty($date_raw)) {
                                    $ts = strtotime($date_raw);
                                    if ($ts !== false) {
                                        $date_display = date('F j, Y', $ts);
                                    }
                                }
                                ?>
                                <td><?= esc($date_display) ?></td>
                                <?php $status = $beneficiary['status'] ?? 'N/A';
                                $status_class = (strtolower(trim($status)) === 'active') ? 'text-success' : 'text-danger'; ?>
                                <td class="<?= esc($status_class) ?>"><?= esc($status) ?></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-success btn-edit-beneficiary" title="Edit Beneficiary" data-bs-toggle="modal" data-bs-target="#update_beneficiary_modal" data-beneficiary='<?= json_encode($beneficiary) ?>'>
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No Data Available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>