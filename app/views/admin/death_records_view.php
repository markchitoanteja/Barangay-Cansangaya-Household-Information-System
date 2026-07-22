<section class="panel">
    <!-- PANEL HEADER -->
    <div class="panel-header d-flex justify-content-between align-items-center mb-3">
        <h5><i class="fa-solid fa-house me-2"></i>List of Death Records</h5>
        <button class="btn gov-btn-primary" data-bs-toggle="modal" data-bs-target="#add_death_record_modal">
            <i class="fa-solid fa-plus me-2"></i>Add Death Record
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
                        <button type="button" class="btn btn-outline-secondary flex-grow-1" data-url="death-records" id="reset_filter_button">
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
                        <th>Date of Death</th>
                        <th>Cause of Death</th>
                        <th>Manner of Death</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($death_records)): ?>
                        <?php $counter = ($current_page - 1) * 10 + 1; ?>

                        <?php foreach ($death_records as $death_record): ?>
                            <tr>
                                <td class="text-center">
                                    <?= esc($counter++) ?>
                                </td>
                                <td>
                                    <?= esc($death_record['resident_name']) ?>
                                </td>
                                <?php
                                $date_raw = $death_record['date_of_death'] ?? null;
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
                                    <?= esc($death_record['cause_of_death']) ?>
                                </td>
                                <td>
                                    <?= esc($death_record['manner_of_death']) ?>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-success btn-edit-death-record" title="Edit Death Record" data-bs-toggle="modal" data-bs-target="#edit_death_record_modal" data-death_record='<?= json_encode($death_record) ?>'>
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