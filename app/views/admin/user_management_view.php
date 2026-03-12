<section class="panel">
    <!-- PANEL HEADER -->
    <div class="panel-header d-flex justify-content-between align-items-center mb-3">
        <span></span>
        <button class="btn gov-btn-primary btn-user-management" data-title="ADD USER ACCOUNT" data-bs-toggle="modal" data-bs-target="#userModal">
            <i class="fa-solid fa-user-plus me-2"></i>Add Staff
        </button>
    </div>

    <!-- PANEL BODY -->
    <div class="panel-body mb-3">
        <!-- FILTERS -->
        <form id="searchForm" action="javascript:void(0)" class="row g-2 mb-3">
            <div class="col-md-4 d-flex flex-column">
                <div class="form-floating flex-grow-1">
                    <input type="text" name="search_input" class="form-control gov-input" id="searchUser" placeholder="Search User" value="<?= esc($search_input ?? '') ?>">
                    <label><i class="fa-solid fa-magnifying-glass me-1"></i>Search Name / Username</label>
                </div>
            </div>

            <div class="col-md-3 d-flex flex-column">
                <div class="form-floating flex-grow-1">
                    <select class="form-select gov-input" name="role" id="filterRole">
                        <option value="">All Roles</option>
                        <option value="ADMIN" <?= ($role ?? '') === 'ADMIN' ? 'selected' : '' ?>>ADMIN</option>
                        <option value="STAFF" <?= ($role ?? '') === 'STAFF' ? 'selected' : '' ?>>STAFF</option>
                    </select>
                    <label><i class="fa-solid fa-user-shield me-1"></i>User Role</label>
                </div>
            </div>

            <div class="col-md-3 d-flex flex-column">
                <div class="form-floating flex-grow-1">
                    <select class="form-select gov-input" name="status" id="filterStatus">
                        <option value="">All Status</option>
                        <option value="1" <?= ($status ?? '') === '1' ? 'selected' : '' ?>>ACTIVE</option>
                        <option value="0" <?= ($status ?? '') === '0' ? 'selected' : '' ?>>DISABLED</option>
                    </select>
                    <label><i class="fa-solid fa-toggle-on me-1"></i>Account Status</label>
                </div>
            </div>

            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1" id="search_filter_button">
                    <i class="fa-solid fa-magnifying-glass me-2"></i>Search
                </button>
                <a href="user-management" class="btn btn-outline-secondary flex-grow-1 loadable">
                    <i class="fa-solid fa-arrows-rotate me-2"></i>Reset
                </a>
            </div>
        </form>

        <!-- USERS TABLE -->
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle border rounded">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">#</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Date Created</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php $counter = ($current_page - 1) * 10 + 1; ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td class="text-center"><?= $counter ?></td>
                                <td><?= esc($user['full_name']) ?></td>
                                <td><?= esc($user['username']) ?></td>
                                <td>
                                    <?php if ($user['role'] === 'ADMIN'): ?>
                                        <span class="badge bg-primary">ADMIN</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">STAFF</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($user['is_active'] == 1): ?>
                                        <span class="badge bg-success">ACTIVE</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">DISABLED</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date("F d, Y", strtotime($user['created_at'])) ?></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-soft me-1 btn-user-management" data-title="UPDATE USER ACCOUNT" data-bs-toggle="modal" data-bs-target="#userModal"
                                        data-user-id="<?= $user['id'] ?>" data-full-name="<?= esc($user['full_name']) ?>"
                                        data-username="<?= esc($user['username']) ?>" data-role="<?= $user['role'] ?>"
                                        data-status="<?= $user['is_active'] ?>">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <?php if ($user['is_active'] == 1): ?>
                                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#disableUserModal"
                                            data-user-id="<?= $user['id'] ?>">
                                            <i class="fa-solid fa-user-slash"></i>
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#enableUserModal"
                                            data-user-id="<?= $user['id'] ?>">
                                            <i class="fa-solid fa-user-check"></i>
                                        </button>
                                    <?php endif; ?>
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

        <!-- PAGINATION -->
        <?php if ($total_pages > 1): ?>
            <nav aria-label="User pagination">
                <ul class="pagination justify-content-center mt-3">
                    <?php
                    // Keep search filters in pagination links
                    $query_params = $_GET;
                    ?>
                    <li class="page-item <?= ($current_page <= 1) ? 'disabled' : '' ?>">
                        <?php $query_params['page'] = $current_page - 1; ?>
                        <a class="loadable page-link" href="?<?= http_build_query($query_params) ?>">&laquo; Prev</a>
                    </li>
                    <?php for ($p = 1; $p <= $total_pages; $p++): ?>
                        <?php $query_params['page'] = $p; ?>
                        <li class="page-item <?= ($p == $current_page) ? 'active' : '' ?>">
                            <a class="loadable page-link" href="?<?= http_build_query($query_params) ?>"><?= $p ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= ($current_page >= $total_pages) ? 'disabled' : '' ?>">
                        <?php $query_params['page'] = $current_page + 1; ?>
                        <a class="loadable page-link" href="?<?= http_build_query($query_params) ?>">Next &raquo;</a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</section>