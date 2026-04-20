<section class="panel">
    <!-- PANEL HEADER -->
    <div class="panel-header d-flex justify-content-between align-items-center mb-3">
        <h5><i class="fa-solid fa-house me-2"></i>List of Residents</h5>
        <button class="btn gov-btn-primary" data-bs-toggle="modal" data-bs-target="#add_resident_modal">
            <i class="fa-solid fa-plus me-2"></i>Add Resident
        </button>
    </div>

    <!-- PANEL BODY -->
    <div class="panel-body mb-3">
        <!-- FILTERS -->
        <form id="residentsSearchForm" action="javascript:void(0)" class="row g-2 mb-3">
            <div class="col-md-5 d-flex flex-column">
                <div class="form-floating flex-grow-1">
                    <input type="text" name="search_input" class="form-control gov-input" id="search_input" placeholder="Search User" value="<?= esc($search_input ?? '') ?>">
                    <label><i class="fa-solid fa-magnifying-glass me-1"></i>Search First Name / Last Name</label>
                </div>
            </div>
            <div class="col-md-2 d-flex flex-column">
                <div class="form-floating flex-grow-1">
                    <select class="form-select gov-input" name="sex" id="sex">
                        <option value="">All Genders</option>
                        <option value="Male" <?= ($sex ?? '') === 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= ($sex ?? '') === 'Female' ? 'selected' : '' ?>>Female</option>
                    </select>
                    <label><i class="fa-solid fa-venus-mars me-1"></i>Gender</label>
                </div>
            </div>
            <div class="col-md-2 d-flex flex-column">
                <div class="form-floating flex-grow-1">
                    <select class="form-select gov-input" name="relationship" id="relationship">
                        <option value="">All Relationships</option>
                        <option value="Head" <?= ($relationship ?? '') === 'Head' ? 'selected' : '' ?>>Head</option>
                        <option value="Spouse" <?= ($relationship ?? '') === 'Spouse' ? 'selected' : '' ?>>Spouse</option>
                        <option value="Child" <?= ($relationship ?? '') === 'Child' ? 'selected' : '' ?>>Child</option>
                        <option value="Relative" <?= ($relationship ?? '') === 'Relative' ? 'selected' : '' ?>>Relative</option>
                        <option value="Other" <?= ($relationship ?? '') === 'Other' ? 'selected' : '' ?>>Other</option>
                    </select>
                    <label><i class="fa-solid fa-user me-1"></i>Relationship to Head</label>
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
                        <button type="button" class="btn btn-outline-secondary flex-grow-1" data-url="residents" id="reset_filter_button">
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
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Sex</th>
                        <th>Birth Date</th>
                        <th>Age</th>
                        <th>Household</th>
                        <th>Relationship to Head</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($residents)): ?>
                        <?php $counter = ($current_page - 1) * 10 + 1; ?>

                        <?php foreach ($residents as $resident): ?>
                            <tr>
                                <td class="text-center"><?= $counter++ ?></td>
                                <td><?= esc($resident['last_name']) ?></td>
                                <td><?= esc($resident['first_name']) ?></td>
                                <td><?= esc($resident['sex']) ?></td>
                                <td><?= esc(date('F j, Y', strtotime($resident['birthdate']))) ?></td>
                                <td><?= ($age = (new DateTime())->diff(new DateTime($resident['birthdate']))->y) . ' ' . ($age === 1 ? 'year old' : 'years old') ?></td>
                                <td><?= esc($resident['household_name']) ?></td>
                                <td><?= esc($resident['relationship']) ?></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-soft btn-edit-resident"
                                        title="Edit Resident"
                                        data-bs-toggle="modal"
                                        data-bs-target="#edit_resident_modal"
                                        data-id="<?= $resident['id'] ?>"
                                        data-first_name="<?= esc($resident['first_name']) ?>"
                                        data-last_name="<?= esc($resident['last_name']) ?>"
                                        data-middle_name="<?= esc($resident['middle_name']) ?>"
                                        data-sex="<?= esc($resident['sex']) ?>"
                                        data-birthdate="<?= esc($resident['birthdate']) ?>"
                                        data-household_id="<?= esc($resident['household_id']) ?>"
                                        data-civil_status="<?= esc($resident['civil_status']) ?>"
                                        data-relationship="<?= esc($resident['relationship']) ?>">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="text-center">
                            <td colspan="8">No Data Available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <?php if ($total_pages > 1): ?>
            <nav aria-label="Household pagination">
                <ul class="pagination justify-content-center mt-3">
                    <?php $query_params = $_GET; ?>

                    <!-- Previous -->
                    <li class="page-item <?= ($current_page <= 1) ? 'disabled' : '' ?>">
                        <?php $query_params['page'] = $current_page - 1; ?>
                        <a class="loadable page-link" href="?<?= http_build_query($query_params) ?>">&laquo; Prev</a>
                    </li>

                    <!-- Pages -->
                    <?php
                    $max_visible = 5;
                    $side = 1;
                    $start = max(2, $current_page - $side);
                    $end = min($total_pages - 1, $current_page + $side);
                    if ($current_page <= $side + 2) {
                        $start = 2;
                        $end = min($total_pages - 1, $max_visible);
                    }
                    if ($current_page >= $total_pages - ($side + 1)) {
                        $start = max(2, $total_pages - $max_visible);
                        $end = $total_pages - 1;
                    }
                    $query_params['page'] = 1; ?>
                    <li class="page-item <?= ($current_page == 1) ? 'active' : '' ?>">
                        <a class="loadable page-link" href="?<?= http_build_query($query_params) ?>">1</a>
                    </li>
                    <?php if ($start > 2): ?><li class="page-item disabled"><span class="page-link">…</span></li><?php endif; ?>
                    <?php for ($p = $start; $p <= $end; $p++):
                        $query_params['page'] = $p; ?>
                        <li class="page-item <?= ($current_page == $p) ? 'active' : '' ?>">
                            <a class="loadable page-link" href="?<?= http_build_query($query_params) ?>"><?= $p ?></a>
                        </li>
                    <?php endfor; ?>
                    <?php if ($end < $total_pages - 1): ?><li class="page-item disabled"><span class="page-link">…</span></li><?php endif; ?>
                    <?php if ($total_pages > 1): $query_params['page'] = $total_pages; ?>
                        <li class="page-item <?= ($current_page == $total_pages) ? 'active' : '' ?>">
                            <a class="loadable page-link" href="?<?= http_build_query($query_params) ?>"><?= $total_pages ?></a>
                        </li>
                    <?php endif; ?>

                    <!-- Next -->
                    <li class="page-item <?= ($current_page >= $total_pages) ? 'disabled' : '' ?>">
                        <?php $query_params['page'] = $current_page + 1; ?>
                        <a class="loadable page-link" href="?<?= http_build_query($query_params) ?>">Next &raquo;</a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</section>