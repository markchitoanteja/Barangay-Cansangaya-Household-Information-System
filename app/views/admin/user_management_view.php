<section class="panel">
    <!-- PANEL HEADER -->
    <div class="panel-header d-flex justify-content-between align-items-center mb-3">
        <h5><i class="fa-solid fa-users me-2"></i>List of User Accounts</h5>
        <button class="btn gov-btn-primary btn-user-management" data-title="ADD USER ACCOUNT" data-submit-text="Save User" data-bs-toggle="modal" data-bs-target="#userModal">
            <i class="fa-solid fa-plus me-2"></i>Add User Account
        </button>
    </div>

    <!-- PANEL BODY -->
    <div class="panel-body mb-3">
        <!-- FILTERS -->
        <form id="searchForm" action="javascript:void(0)" class="row g-2 mb-3">
            <div class="col-md-5 d-flex flex-column">
                <div class="form-floating flex-grow-1">
                    <input type="text" name="search_input" class="form-control gov-input" id="searchUser" placeholder="Search User" value="<?= esc($search_input ?? '') ?>">
                    <label><i class="fa-solid fa-magnifying-glass me-1"></i>Search Name / Username</label>
                </div>
            </div>

            <div class="col-md-2 d-flex flex-column">
                <div class="form-floating flex-grow-1">
                    <select class="form-select gov-input" name="role" id="filterRole">
                        <option value="">All Roles</option>
                        <option value="ADMIN" <?= ($role ?? '') === 'ADMIN' ? 'selected' : '' ?>>ADMIN</option>
                        <option value="STAFF" <?= ($role ?? '') === 'STAFF' ? 'selected' : '' ?>>STAFF</option>
                    </select>
                    <label><i class="fa-solid fa-user-shield me-1"></i>User Role</label>
                </div>
            </div>

            <div class="col-md-2 d-flex flex-column">
                <div class="form-floating flex-grow-1">
                    <select class="form-select gov-input" name="status" id="filterStatus">
                        <option value="">All Status</option>
                        <option value="1" <?= ($status ?? '') === '1' ? 'selected' : '' ?>>ACTIVE</option>
                        <option value="0" <?= ($status ?? '') === '0' ? 'selected' : '' ?>>DISABLED</option>
                    </select>
                    <label><i class="fa-solid fa-toggle-on me-1"></i>Account Status</label>
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
                        <button type="button" class="btn btn-outline-secondary flex-grow-1" data-url="user-management" id="reset_filter_button">
                            <i class="fa-solid fa-arrows-rotate me-2"></i>Reset
                        </button>
                    </div>
                </div>
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
                        <?php
                        $counter = ($current_page - 1) * 10 + 1;
                        $currentUser = session_get('user');
                        ?>
                        <?php foreach ($users as $user): ?>
                            <?php if ($user['role'] === 'SUPER_ADMIN') continue; ?>

                            <?php
                            // ✅ Role hierarchy logic
                            $canManage = false;

                            if ($currentUser['role'] === 'SUPER_ADMIN') {
                                $canManage = true;
                            } elseif ($currentUser['role'] === 'ADMIN' && $user['role'] === 'STAFF') {
                                $canManage = true;
                            }
                            ?>

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
                                    <?php if ($canManage): ?>

                                        <!-- SECURITY -->
                                        <button class="btn btn-sm btn-outline-warning me-1 btn-security-questions" title="Update Security Questions"
                                            data-bs-toggle="modal"
                                            data-bs-target="#securityQuestionsModal"
                                            data-user_id="<?= $user['id'] ?>"
                                            data-username="<?= esc($user['username']) ?>"
                                            data-security_questions='<?= json_encode($user['security_questions'], JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
                                            <i class="fa-solid fa-shield-halved"></i>
                                        </button>

                                        <!-- EDIT -->
                                        <button class="btn btn-sm btn-outline-primary me-1 btn-user-management btn-edit-user" title="Update User Account"
                                            data-title="UPDATE USER ACCOUNT"
                                            data-submit-text="Save Changes"
                                            data-bs-toggle="modal"
                                            data-bs-target="#userModal"
                                            data-user_id="<?= $user['id'] ?>"
                                            data-full_name="<?= esc($user['full_name']) ?>"
                                            data-username="<?= esc($user['username']) ?>"
                                            data-role="<?= $user['role'] ?>"
                                            data-is_active="<?= $user['is_active'] ?>">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>

                                        <?php if ($user['is_active']): ?>
                                            <button class="btn btn-sm btn-outline-danger disable-user-account" title="Disable User Account"
                                                data-user_id="<?= $user['id'] ?>"
                                                data-username="<?= $user['username'] ?>">
                                                <i class="fa-solid fa-user-slash"></i>
                                            </button>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-outline-success enable-user-account" title="Enable User Account"
                                                data-user_id="<?= $user['id'] ?>"
                                                data-username="<?= $user['username'] ?>">
                                                <i class="fa-solid fa-user-check"></i>
                                            </button>
                                        <?php endif; ?>

                                    <?php else: ?>
                                        <span class="text-muted">No Actions</span>
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