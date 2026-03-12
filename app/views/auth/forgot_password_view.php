<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Forgot Password | <?= env('APP_NAME') ?></title>

    <link rel="shortcut icon" href="<?= base_url('public/assets/img/favicon.ico') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= base_url('public/plugins/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/plugins/fontawesome/css/all.min.css?v=') . env('APP_VERSION', '1.0.0') ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/css/login.css?v=') . env('APP_VERSION', '1.0.0') ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/css/forgot_password.css?v=') . env('APP_VERSION', '1.0.0') ?>">
</head>

<body>
    <div class="auth-wrapper">
        <!-- LEFT PANEL -->
        <aside class="left-panel">
            <div class="logo">
                <img src="<?= base_url('public/assets/img/logo.png') ?>" alt="Barangay Logo">
            </div>
            <h1 class="system-title">
                Barangay Cansangaya<br>
                <span>Household Information System</span>
            </h1>
            <p class="system-desc">
                A digital system designed to manage household records, improve barangay services,
                and streamline administrative tasks.
            </p>
            <div class="feature">
                <i class="fa-solid fa-house"></i>
                <div>
                    <strong>Household Records</strong><br>
                    Maintain organized household data for residents.
                </div>
            </div>
            <div class="feature">
                <i class="fa-solid fa-file-lines"></i>
                <div>
                    <strong>Digital Documentation</strong><br>
                    Quick access to certificates and official records.
                </div>
            </div>
            <div class="feature">
                <i class="fa-solid fa-shield-halved"></i>
                <div>
                    <strong>Secure System</strong><br>
                    Protected login access for barangay staff and administrators.
                </div>
            </div>
        </aside>

        <!-- RIGHT PANEL -->
        <main class="right-panel">
            <div class="login">
                <section class="alert alert-danger alert-section text-center d-none" role="alert" id="forgot_alert"></section>

                <section class="login-card">
                    <header class="login-header mb-4 text-center">
                        <h4 class="fw-semibold mb-1">Forgot Password</h4>
                        <p class="text-muted small mb-0">Verify your identity and reset your password</p>
                    </header>

                    <!-- STEP 1 -->
                    <form id="forgot_step1_form" class="step-section">
                        <div class="role-selector mb-4">
                            <div class="btn-group w-100" role="group" aria-label="Role selector">
                                <input type="radio" class="btn-check" name="role" id="fp_role_admin" value="ADMIN" checked>
                                <label class="btn btn-outline-primary" for="fp_role_admin">
                                    <i class="fa-solid fa-user-shield me-1"></i> Administrator
                                </label>

                                <input type="radio" class="btn-check" name="role" id="fp_role_staff" value="STAFF">
                                <label class="btn btn-outline-primary" for="fp_role_staff">
                                    <i class="fa-solid fa-user me-1"></i> Staff
                                </label>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="fp_username" placeholder="Username" required>
                            <label for="fp_username">
                                <i class="fa-regular fa-user me-1"></i> Username
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2" id="fp_load_questions_btn">
                            <i class="fa-solid fa-circle-question me-1"></i> Continue
                        </button>

                        <div class="text-center mt-3">
                            <a href="<?= base_url('login') ?>" class="back-link">
                                <i class="fa-solid fa-arrow-left me-1"></i> Back to Login
                            </a>
                        </div>
                    </form>

                    <!-- STEP 2 -->
                    <form id="forgot_step2_form" class="step-section d-none">
                        <input type="hidden" id="fp_user_id">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Answer the following security questions</label>

                            <div id="security_questions_container"></div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="fa-solid fa-shield me-1"></i> Verify Answers
                        </button>

                        <button type="button" class="btn btn-light w-100 py-2 mt-2" id="back_to_step1">
                            <i class="fa-solid fa-arrow-left me-1"></i> Back
                        </button>
                    </form>

                    <!-- STEP 3 -->
                    <form id="forgot_step3_form" class="step-section d-none">
                        <input type="hidden" id="fp_verified_user_id">

                        <div class="form-floating mb-3 position-relative">
                            <input
                                type="password"
                                class="form-control"
                                id="fp_new_password"
                                placeholder="New Password"
                                required>
                            <label for="fp_new_password">
                                <i class="fa-solid fa-lock me-1"></i> New Password
                            </label>
                            <button
                                type="button"
                                class="btn btn-sm position-absolute top-50 end-0 translate-middle-y me-2 text-secondary border-0 toggle-password"
                                data-target="#fp_new_password"
                                aria-label="Toggle new password visibility">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>

                        <div class="form-floating mb-3 position-relative">
                            <input
                                type="password"
                                class="form-control"
                                id="fp_confirm_password"
                                placeholder="Confirm Password"
                                required>
                            <label for="fp_confirm_password">
                                <i class="fa-solid fa-lock me-1"></i> Confirm Password
                            </label>
                            <button
                                type="button"
                                class="btn btn-sm position-absolute top-50 end-0 translate-middle-y me-2 text-secondary border-0 toggle-password"
                                data-target="#fp_confirm_password"
                                aria-label="Toggle confirm password visibility">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="fa-solid fa-key me-1"></i> Reset Password
                        </button>
                    </form>

                    <footer class="text-center mt-4 small text-muted">
                        © <span id="year"></span> Barangay Cansangaya
                    </footer>
                </section>
            </div>
        </main>
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

    <!-- Global JavaScript Variables -->
    <script>
        const BASE_URL = "<?= base_url() ?>";
        const APP_DEBUG = <?= env('APP_DEBUG', true) ?>;
    </script>

    <script src="<?= base_url('public/plugins/jquery/jquery-4.0.0.min.js') ?>"></script>
    <script src="<?= base_url('public/plugins/sweetalert2/sweetalert2.all.min.js') ?>"></script>
    <script src="<?= base_url('public/assets/js/forgot_password.min.js?v=') . env('APP_VERSION', '1.0.0') ?>"></script>
</body>

</html>