<section class="panel">
    <!-- PANEL HEADER -->
    <div class="panel-header d-flex justify-content-between align-items-center mb-3">
        <h5><i class="fa-solid fa-house me-2"></i>List of Migration Records</h5>
        <button class="btn gov-btn-primary" data-bs-toggle="modal" data-bs-target="#add_migration_record_modal">
            <i class="fa-solid fa-plus me-2"></i>Add Migration Record
        </button>
    </div>

    <!-- PANEL BODY -->
    <div class="panel-body mb-3">
        <!-- FILTERS -->
        <form id="birthRecordSearchForm" action="javascript:void(0)" class="row g-2 mb-3">
            <div class="col-md-5"></div>
            <div class="col-md-4 d-flex flex-column">
                <div class="form-floating flex-grow-1">
                    <input type="text" name="search_input" class="form-control gov-input" id="search_input" placeholder="Search User" value="<?= esc($search_input ?? '') ?>">
                    <label><i class="fa-solid fa-magnifying-glass me-1"></i>Search Resident's Name</label>
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
                        <button type="button" class="btn btn-outline-secondary flex-grow-1" data-url="migration-records" id="reset_filter_button">
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
                        <th>Resident</th>
                        <th>Migration Type</th>
                        <th>Date of Migration</th>
                        <th>Origin</th>
                        <th>Destination</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($migration_records)): ?>
                        <?php $counter = ($current_page - 1) * 10 + 1; ?>

                        <?php foreach ($migration_records as $migration_record): ?>
                            <tr>
                                <td class="text-center">
                                    <?= esc($counter++) ?>
                                </td>
                                <td>
                                    <?= esc($migration_record['resident_name']) ?>
                                </td>
                                <td>
                                    <?php if ($migration_record['migration_type'] === 'IN'): ?>
                                        <span class="badge bg-success"><?= esc($migration_record['migration_type']) ?></span>
                                    <?php elseif ($migration_record['migration_type'] === 'OUT'): ?>
                                        <span class="badge bg-danger"><?= esc($migration_record['migration_type']) ?></span>
                                    <?php else: ?>
                                        <?= esc($migration_record['migration_type']) ?>
                                    <?php endif; ?>
                                </td>
                                <?php
                                $date_raw = $migration_record['date_of_migration'] ?? null;
                                $date_display = 'N/A';
                                if (!empty($date_raw)) {
                                    $ts = strtotime($date_raw);
                                    if ($ts !== false) {
                                        $date_display = date('F j, Y', $ts);
                                    }
                                }
                                ?>
                                <td>
                                    <?= esc($date_display) ?>
                                </td>
                                <td>
                                    <?= esc($migration_record['origin']) ?>
                                </td>
                                <td>
                                    <?= esc($migration_record['destination']) ?>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-success btn-edit-migration-record" title="Edit Migration Record" data-bs-toggle="modal" data-bs-target="#edit_migration_record_modal" data-migration_record='<?= json_encode($migration_record) ?>'>
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No Data Available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>