        <!-- ABOUT US MODAL -->
        <div class="modal fade" id="aboutUsModal" tabindex="-1" aria-labelledby="aboutUsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content gov-modal">

                    <div class="modal-header gov-modal-header">
                        <div class="d-flex align-items-center gap-3">
                            <img src="<?= base_url('public/assets/img/logo.png') ?>" alt="Barangay Logo" class="gov-modal-logo">
                            <div>
                                <h5 class="modal-title mb-0" id="aboutUsModalLabel">OFFICE INFORMATION</h5>
                                <small class="gov-modal-subtitle">Barangay Cansangaya Household Information System</small>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body gov-modal-body">
                        <div class="text-center mb-4">
                            <h4 class="mb-1">BARANGAY CANSANGAYA</h4>
                            <p class="mb-0 text-muted">Household Information System (HIS)</p>
                        </div>

                        <div class="gov-section">
                            <div class="gov-section__label">System Overview</div>
                            <p class="mb-0">
                                The Barangay Household Information System (HIS) is an official information management platform
                                developed to facilitate the recording, maintenance, and retrieval of household and resident data
                                of Barangay Cansangaya.
                            </p>
                        </div>

                        <div class="gov-section">
                            <div class="gov-section__label">Purpose</div>
                            <p class="mb-0">
                                This system is intended to support barangay operations by providing an organized and reliable
                                digital repository of demographic, housing, livelihood, social sector, and health-related records.
                                It aims to improve administrative efficiency, strengthen data-based planning, and assist in the
                                delivery of public service programs and community interventions.
                            </p>
                        </div>

                        <div class="gov-section">
                            <div class="gov-section__label">Core Functions</div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="info-card">
                                        <h6 class="mb-1">Resident and Household Registry</h6>
                                        <p class="mb-0">Centralized recording and updating of household and resident profiles.</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-card">
                                        <h6 class="mb-1">Community Data Monitoring</h6>
                                        <p class="mb-0">Tracking of demographic, housing, social, livelihood, and health indicators.</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-card">
                                        <h6 class="mb-1">Reporting Support</h6>
                                        <p class="mb-0">Generation of summarized records and reports for barangay reference and planning.</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-card">
                                        <h6 class="mb-1">Controlled User Access</h6>
                                        <p class="mb-0">Access management for authorized personnel based on user roles and responsibilities.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="gov-section">
                            <div class="gov-section__label">Data Privacy and Security</div>
                            <p class="mb-0">
                                All records maintained in this system shall be accessed only by authorized users and handled in
                                accordance with applicable data privacy, confidentiality, and records management policies of the office.
                            </p>
                        </div>

                        <div class="gov-meta">
                            <div class="row">
                                <div class="col-md-6 mb-2 mb-md-0">
                                    <strong>Office:</strong> Barangay Cansangaya
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <strong>System Version:</strong> <?= env('APP_VERSION', '1.0.0') ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer gov-modal-footer">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ACCOUNT SETTINGS MODAL -->
        <div class="modal fade" id="accountSettingsModal" tabindex="-1" aria-labelledby="accountSettingsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content gov-modal">

                    <div class="modal-header gov-modal-header">
                        <div class="d-flex align-items-center gap-3">
                            <img src="<?= base_url('public/assets/img/logo.png') ?>" alt="Barangay Logo" class="gov-modal-logo">
                            <div>
                                <h5 class="modal-title mb-0" id="accountSettingsModalLabel">ACCOUNT SETTINGS</h5>
                                <small class="gov-modal-subtitle">Barangay Cansangaya Household Information System</small>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="javascript:void(0)" id="accountSettingsForm">
                        <div class="modal-body gov-modal-body">
                            <div class="gov-section">
                                <div class="gov-section__label">Account Information</div>
                                <div class="settings-profile">
                                    <img src="<?= base_url('public/assets/img/user-avatar.png') ?>" alt="User Avatar" class="settings-profile__avatar">
                                    <div>
                                        <h6 class="mb-1"><?= isset($user) ? esc($user['full_name']) : 'Default User' ?></h6>
                                        <div class="text-muted small mb-1"><?= isset($user) ? esc($user['role']) : 'STAFF' ?></div>
                                        <div class="text-muted small">Authorized system user</div>
                                    </div>
                                </div>
                                <div class="row g-3 mt-1">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control gov-input" id="account_settings_full_name" value="<?= isset($user) ? esc($user['full_name']) : '' ?>" placeholder="Full Name" required>
                                            <label for="account_settings_full_name">
                                                <i class="fa-regular fa-user me-1"></i> Full Name
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control gov-input" id="account_settings_username" value="<?= isset($user) && isset($user['username']) ? esc($user['username']) : '' ?>" placeholder="Username" required>
                                            <label for="account_settings_username">
                                                <i class="fa-regular fa-user me-1"></i> Username
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control gov-input" id="account_settings_role" value="<?= isset($user) ? esc($user['role']) : '' ?>" placeholder="User Role" readonly>
                                            <label for="account_settings_role">
                                                <i class="fa-solid fa-id-badge me-1"></i> User Role
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control gov-input" id="account_settings_created_at" value="<?= isset($user) && isset($user['created_at']) ? esc(date('F d, Y h:i A', strtotime($user['created_at']))) : '' ?>" placeholder="Date Created" readonly>
                                            <label for="account_settings_created_at">
                                                <i class="fa-regular fa-calendar me-1"></i> Date Created
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="gov-section">
                                <div class="gov-section__label">Change Password</div>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="form-floating position-relative">
                                            <input type="password" class="form-control gov-input gov-input--password" id="account_settings_current_password" placeholder="Current Password">
                                            <label for="account_settings_current_password">
                                                <i class="fa-solid fa-lock me-1"></i> Current Password
                                            </label>
                                            <button type="button" class="btn btn-sm password-toggle toggle-password" data-target="#current_password" aria-label="Toggle password visibility">
                                                <i class="fa-regular fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating position-relative">
                                            <input type="password" class="form-control gov-input gov-input--password" id="account_settings_new_password" placeholder="New Password">
                                            <label for="account_settings_new_password">
                                                <i class="fa-solid fa-lock me-1"></i> New Password
                                            </label>
                                            <button type="button" class="btn btn-sm password-toggle toggle-password" data-target="#new_password" aria-label="Toggle password visibility">
                                                <i class="fa-regular fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating position-relative">
                                            <input type="password" class="form-control gov-input gov-input--password" id="account_settings_confirm_password" placeholder="Confirm Password">
                                            <label for="account_settings_confirm_password">
                                                <i class="fa-solid fa-lock me-1"></i> Confirm Password
                                            </label>
                                            <button type="button" class="btn btn-sm password-toggle toggle-password" data-target="#confirm_password" aria-label="Toggle password visibility">
                                                <i class="fa-regular fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="settings-note mt-3">
                                    Password updates should only be performed by the authorized account holder.
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer gov-modal-footer">
                            <input type="hidden" value="<?= $user["id"] ?>" id="account_settings_user_id">

                            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn gov-btn-primary px-4">
                                <i class="fa-solid fa-floppy-disk me-2"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- CALENDAR MODAL -->
        <div class="modal fade" id="calendarModal" tabindex="-1" aria-labelledby="calendarModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content gov-modal">

                    <div class="modal-header gov-modal-header">
                        <div class="d-flex align-items-center gap-3">
                            <img src="<?= base_url('public/assets/img/logo.png') ?>" alt="Barangay Logo" class="gov-modal-logo">
                            <div>
                                <h5 class="modal-title mb-0" id="calendarModalLabel">OFFICIAL CALENDAR</h5>
                                <small class="gov-modal-subtitle">Barangay Cansangaya Household Information System</small>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body gov-modal-body">
                        <div class="calendar-panel">
                            <div class="calendar-panel__top">
                                <div>
                                    <div class="calendar-panel__label">Current Date Reference</div>
                                    <div class="calendar-panel__today" id="calendarTodayText">Today</div>
                                </div>

                                <div class="calendar-nav">
                                    <button class="btn btn-sm calendar-nav__btn" type="button" id="prevMonthBtn">
                                        <i class="fa-solid fa-chevron-left"></i>
                                    </button>

                                    <div class="calendar-nav__title" id="calendarTitle">Current Month</div>

                                    <button class="btn btn-sm calendar-nav__btn" type="button" id="nextMonthBtn">
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="calendar-weekdays">
                                <div>Sun</div>
                                <div>Mon</div>
                                <div>Tue</div>
                                <div>Wed</div>
                                <div>Thu</div>
                                <div>Fri</div>
                                <div>Sat</div>
                            </div>

                            <div class="calendar-days-grid" id="calendarDays"></div>
                        </div>
                    </div>

                    <div class="modal-footer gov-modal-footer">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading Overlay -->
        <div id="loadingOverlay" class="loading-overlay d-none" role="status" aria-live="polite" aria-busy="true">
            <div class="loading-modal">
                <div class="loading-bar"></div>

                <div class="loading-body">
                    <div class="loading-seal" aria-hidden="true">
                        <img src="<?= base_url('public/assets/img/logo.png') ?>" alt="Barangay Cansangaya Logo">
                    </div>

                    <div class="loading-text">
                        <div class="loading-title">Please wait</div>
                        <div class="loading-sub">Processing your request…</div>

                        <div class="loading-progress" aria-hidden="true">
                            <span></span>
                        </div>

                        <div class="loading-note">
                            Barangay Cansangaya Household Information System
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            const USER_ID = <?= json_encode($user["id"]) ?>;
            const APP_DEBUG = <?= env('APP_DEBUG', true) ?>;
            const flashData = <?= json_encode(get_flash('flash_notif', null)) ?>;
        </script>

        <!-- Bootstrap Bundle (includes Popper) -->
        <script src="<?= base_url('public/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
        <!-- JQuery -->
        <script src="<?= base_url('public/plugins/jquery/jquery-4.0.0.min.js') ?>"></script>
        <!-- SweetAlert2 -->
        <script src="<?= base_url('public/plugins/sweetalert2/sweetalert2.all.min.js') ?>"></script>
        <!-- Custom Script -->
        <script src="<?= base_url('public/assets/js/app.js?v=') . env('APP_VERSION', '1.0.0') ?>"></script>
    </body>
</html>