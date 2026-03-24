<section class="panel">
    <!-- PANEL HEADER -->
    <div class="panel-header d-flex justify-content-between align-items-center mb-3">
        <h5><i class="fa-solid fa-house me-2"></i>List of Households</h5>
        <button class="btn gov-btn-primary" data-bs-toggle="modal" data-bs-target="#residentModal">
            <i class="fa-solid fa-plus me-2"></i>Add Resident
        </button>
    </div>

    <!-- PANEL BODY -->
    <div class="panel-body mb-3">
        <!-- FILTERS -->
        <form id="householSearchForm" action="javascript:void(0)" class="row g-2 mb-3">
            <div class="col-md-5 d-flex flex-column">
                <div class="form-floating flex-grow-1">
                    <input type="text" name="search_input" class="form-control gov-input" id="searchUser" placeholder="Search User" value="<?= esc($search_input ?? '') ?>">
                    <label><i class="fa-solid fa-magnifying-glass me-1"></i>Search Purok / Housing Type</label>
                </div>
            </div>
            <div class="col-md-2 d-flex flex-column">
                <div class="form-floating flex-grow-1">
                    <select class="form-select gov-input" name="role" id="filterRole">
                        <option value="">All Comfort Rooms</option>
                        <option value="Owned" <?= ($comfort_room ?? '') === 'Owned' ? 'selected' : '' ?>>Owned</option>
                        <option value="Shared" <?= ($comfort_room ?? '') === 'Shared' ? 'selected' : '' ?>>Shared</option>
                        <option value="None" <?= ($comfort_room ?? '') === 'None' ? 'selected' : '' ?>>None</option>
                    </select>
                    <label><i class="fa-solid fa-toilet me-1"></i>Comfort Room</label>
                </div>
            </div>
            <div class="col-md-2 d-flex flex-column">
                <div class="form-floating flex-grow-1">
                    <select class="form-select gov-input" name="status" id="filterStatus">
                        <option value="">All Water Systems</option>
                        <option value="Level 1" <?= ($status ?? '') === 'Level 1' ? 'selected' : '' ?>>Level 1</option>
                        <option value="Level 2" <?= ($status ?? '') === 'Level 2' ? 'selected' : '' ?>>Level 2</option>
                        <option value="Level 3" <?= ($status ?? '') === 'Level 3' ? 'selected' : '' ?>>Level 3</option>
                    </select>
                    <label><i class="fa-solid fa-water me-1"></i>Water System</label>
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
                        <button type="button" class="btn btn-outline-secondary flex-grow-1" data-url="households" id="reset_filter_button">
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
                        <th>Purok</th>
                        <th>Housing Type</th>
                        <th>Comfort Room</th>
                        <th>Water System</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($households)): ?>
                        <?php $counter = ($current_page - 1) * 10 + 1; ?>
                        <?php foreach ($households as $household): ?>
                            <tr>
                                <td class="text-center"><?= $counter ?></td>
                                <td><?= esc($household['purok']) ?></td>
                                <td><?= esc($household['housing_type']) ?></td>
                                <td><?= esc($household['comfort_room']) ?></td>
                                <td><?= esc($household['water_system']) ?></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-soft btn-household-management btn-edit-household" title="Edit Household"
                                        data-title="UPDATE HOUSEHOLD"
                                        data-submit-text="Save Changes"
                                        data-bs-toggle="modal"
                                        data-bs-target="#householdModal"
                                        data-id="<?= $household['id'] ?>"
                                        data-purok="<?= esc($household['purok']) ?>"
                                        data-housing_type="<?= esc($household['housing_type']) ?>"
                                        data-comfort_room="<?= esc($household['comfort_room']) ?>"
                                        data-water_system="<?= esc($household['water_system']) ?>">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger btn-delete-household" title="Delete Household"
                                        data-id="<?= $household['id'] ?>">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php $counter++; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="text-center">
                            <td colspan="6">No Data Available</td>
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