<section class="panel">
    <!-- PANEL HEADER -->
    <div class="panel-header d-flex justify-content-between align-items-center mb-3">
        <h5><i class="fa-solid fa-house me-2"></i>List of Socio-Economic Profiles</h5>
        <button class="btn gov-btn-primary" data-bs-toggle="modal" data-bs-target="#socioEconomicModal">
            <i class="fa-solid fa-plus me-2"></i>Add Socio-Economic Profile
        </button>
    </div>

    <!-- PANEL BODY -->
    <div class="panel-body mb-3">
        <!-- FILTERS -->
        <form id="socioEconomicSearchForm" action="javascript:void(0)" class="row g-2 mb-3">
            <div class="col-md-5 d-flex flex-column">
                <div class="form-floating flex-grow-1">
                    <input type="text" name="search_input" class="form-control gov-input" id="search_input" placeholder="Search User" value="<?= esc($search_input ?? '') ?>">
                    <label><i class="fa-solid fa-magnifying-glass me-1"></i>Search Resident First Name / Last Name</label>
                </div>
            </div>
            <div class="col-md-2 d-flex flex-column">
                <div class="form-floating flex-grow-1">
                    <select class="form-select gov-input" name="employment_status" id="employment_status">
                        <option value="">All Status</option>
                        <option value="Employed" <?= ($employment_status ?? '') === 'Employed' ? 'selected' : '' ?>>Employed</option>
                        <option value="Unemployed" <?= ($employment_status ?? '') === 'Unemployed' ? 'selected' : '' ?>>Unemployed</option>
                        <option value="Self-employed" <?= ($employment_status ?? '') === 'Self-employed' ? 'selected' : '' ?>>Self-employed</option>
                        <option value="Student" <?= ($employment_status ?? '') === 'Student' ? 'selected' : '' ?>>Student</option>
                        <option value="Retired" <?= ($employment_status ?? '') === 'Retired' ? 'selected' : '' ?>>Retired</option>
                    </select>
                    <label><i class="fa-solid fa-briefcase me-1"></i>Employment Status</label>
                </div>
            </div>
            <div class="col-md-2 d-flex flex-column">
                <div class="form-floating flex-grow-1">
                    <select class="form-select gov-input" name="education_level" id="education_level">
                        <option value="">All Levels</option>
                        <option value="None" <?= ($education_level ?? '') === 'None' ? 'selected' : '' ?>>None</option>
                        <option value="Elementary" <?= ($education_level ?? '') === 'Elementary' ? 'selected' : '' ?>>Elementary</option>
                        <option value="High School" <?= ($education_level ?? '') === 'High School' ? 'selected' : '' ?>>High School</option>
                        <option value="Senior High" <?= ($education_level ?? '') === 'Senior High' ? 'selected' : '' ?>>Senior High</option>
                        <option value="College" <?= ($education_level ?? '') === 'College' ? 'selected' : '' ?>>College</option>
                        <option value="Postgraduate" <?= ($education_level ?? '') === 'Postgraduate' ? 'selected' : '' ?>>Postgraduate</option>
                    </select>
                    <label><i class="fa-solid fa-water me-1"></i>Education Level</label>
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
                        <button type="button" class="btn btn-outline-secondary flex-grow-1" data-url="socio-economic" id="reset_filter_button">
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
                        <th>Occupation</th>
                        <th>Employment Status</th>
                        <th>Monthly Income</th>
                        <th>Education Level</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($socio_economic_profiles)): ?>
                        <?php $counter = ($current_page - 1) * 10 + 1; ?>

                        <?php foreach ($socio_economic_profiles as $profile): ?>
                            <tr>
                                <td class="text-center"><?= esc($counter++) ?></td>
                                <td>
                                    <?= esc(
                                        $profile['first_name']
                                            . (!empty($profile['middle_name']) ? ' ' . strtoupper(substr($profile['middle_name'], 0, 1)) . '.' : '')
                                            . ' ' . $profile['last_name']
                                    ) ?><br>
                                    <small class="text-muted">Household: <?= esc($profile['household_name']) ?></small>
                                </td>
                                <td><?= esc($profile['occupation'] ?? 'N/A') ?></td>
                                <td><?= esc($profile['employment_status'] ?? 'N/A') ?></td>
                                <td><?= isset($profile['monthly_income']) ? '₱' . number_format($profile['monthly_income'], 2) : 'N/A' ?></td>
                                <td><?= esc($profile['education_level'] ?? 'N/A') ?></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-soft btn-view-socio-economic-profile"
                                        title="View Socio-Economic Profile"
                                        data-bs-toggle="modal"
                                        data-bs-target="#view_socio_economic_modal"
                                        data-profile='<?= json_encode($profile) ?>'>
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-soft btn-edit-socio-economic-profile"
                                        title="Edit Socio-Economic Profile"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editSocioEconomicModal"
                                        data-profile='<?= json_encode($profile) ?>'>
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No Data Available</td>
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