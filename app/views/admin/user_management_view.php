<section class="panel">
    <!-- PANEL HEADER -->
    <div class="panel-header d-flex justify-content-between align-items-center mb-3">
        <span></span>
        <button class="btn gov-btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">
            <i class="fa-solid fa-user-plus me-2"></i>Add Staff
        </button>
    </div>

    <!-- PANEL BODY -->
    <div class="panel-body mb-3">
        <!-- FILTERS -->
        <div class="row g-2 mb-3">
            <div class="col-md-4">
                <div class="form-floating">
                    <input type="text" class="form-control gov-input" id="searchUser" placeholder="Search User">
                    <label><i class="fa-solid fa-magnifying-glass me-1"></i>Search Name / Username</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating">
                    <select class="form-select gov-input" id="filterRole">
                        <option value="">All Roles</option>
                        <option value="ADMIN">ADMIN</option>
                        <option value="STAFF">STAFF</option>
                    </select>
                    <label><i class="fa-solid fa-user-shield me-1"></i>User Role</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating">
                    <select class="form-select gov-input" id="filterStatus">
                        <option value="">All Status</option>
                        <option value="ACTIVE">ACTIVE</option>
                        <option value="DISABLED">DISABLED</option>
                    </select>
                    <label><i class="fa-solid fa-toggle-on me-1"></i>Account Status</label>
                </div>
            </div>
            <div class="col-md-2 d-flex align-items-center">
                <button class="btn btn-primary w-100" id="search_filter_button">
                    <i class="fa-solid fa-magnifying-glass me-2"></i>Search
                </button>
            </div>
        </div>

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
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($users): ?>
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
                                    <?php if ($user['is_active'] === 1): ?>
                                        <span class="badge bg-success">ACTIVE</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">DISABLED</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date("F d, Y", strtotime($user['created_at'])) ?></td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-soft me-1" data-bs-toggle="modal" data-bs-target="#userModal"
                                        data-user-id="<?= $user['id'] ?>" data-full-name="<?= esc($user['full_name']) ?>"
                                        data-username="<?= esc($user['username']) ?>" data-role="<?= $user['role'] ?>"
                                        data-status="<?= $user['is_active'] ?>">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <?php if ($user['is_active'] === 1): ?>
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
                    <li class="page-item <?= ($current_page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $current_page - 1 ?>">&laquo; Prev</a>
                    </li>
                    <?php for ($p = 1; $p <= $total_pages; $p++): ?>
                        <li class="page-item <?= ($p == $current_page) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $p ?>"><?= $p ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= ($current_page >= $total_pages) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $current_page + 1 ?>">Next &raquo;</a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</section>