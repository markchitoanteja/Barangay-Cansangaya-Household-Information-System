<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Barangay Cansangaya Household Information System - Login</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url('public/assets/img/favicon.ico') ?>" type="image/x-icon">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= base_url('public/plugins/bootstrap/css/bootstrap.min.css') ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('public/plugins/fontawesome/css/all.min.css?v=') . env('APP_VERSION', '1.0.0') ?>">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('public/assets/css/login.css?v=') . env('APP_VERSION', '1.0.0') ?>">
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
                <section class="alert alert-danger alert-section text-center d-none" role="alert" id="login_alert">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i>
                    Invalid username or password. Please try again.
                </section>
                <section class="login-card">
                    <header class="login-header mb-4 text-center">
                        <h4 class="fw-semibold mb-1">Authorized Personnel Login</h4>
                        <p class="text-muted small mb-0">Access the Barangay Cansangaya Household System</p>
                    </header>
                    <form action="javascript:void(0)" autocomplete="on" id="login_form">
                        <!-- ROLE SELECTOR -->
                        <div class="role-selector mb-4">
                            <div class="btn-group w-100" role="group" aria-label="Role selector">
                                <input type="radio" class="btn-check" name="role" id="login_role_admin" value="admin" checked>
                                <label class="btn btn-outline-primary" for="login_role_admin">
                                    <i class="fa-solid fa-user-shield me-1"></i> Administrator
                                </label>

                                <input type="radio" class="btn-check" name="role" id="login_role_staff" value="staff">
                                <label class="btn btn-outline-primary" for="login_role_staff">
                                    <i class="fa-solid fa-user me-1"></i> Staff
                                </label>
                            </div>
                        </div>

                        <!-- USERNAME -->
                        <div class="form-floating mb-3">
                            <input
                                type="text" class="form-control" id="login_username" placeholder="Username" required>
                            <label for="login_username">
                                <i class="fa-regular fa-user me-1"></i> Username
                            </label>
                        </div>

                        <!-- PASSWORD -->
                        <div class="form-floating mb-3 position-relative">
                            <input type="password" class="form-control" id="login_password" placeholder="Password" required>
                            <label for="login_password">
                                <i class="fa-solid fa-lock me-1"></i> Password
                            </label>
                            <button type="button" class="btn btn-sm position-absolute top-50 end-0 translate-middle-y me-2 text-secondary border-0" id="togglePassword" aria-label="Toggle password visibility">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>

                        <!-- OPTIONS -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="login_remember">
                                <label class="form-check-label small" for="login_remember">Remember me</label>
                            </div>

                            <a href="javascript:void(0)" class="small text-decoration-none">
                                Forgot password?
                            </a>
                        </div>

                        <!-- SUBMIT -->
                        <button type="submit" class="btn btn-primary w-100 py-2" id="login_submit">
                            <i class="fa-solid fa-right-to-bracket me-1"></i> Login
                        </button>

                        <footer class="text-center mt-4 small text-muted">
                            © <span id="year"></span> Barangay Cansangaya
                        </footer>
                    </form>
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

    <script>
        const flashData = <?= json_encode(get_flash('login_notif', null)) ?>;
    </script>

    <!-- jQuery -->
    <script src="<?= base_url('public/plugins/jquery/jquery-4.0.0.min.js') ?>"></script>
    <!-- SweetAlert2 -->
    <script src="<?= base_url('public/plugins/sweetalert2/sweetalert2.all.min.js') ?>"></script>
    <!-- Custom Script -->
    <script src="<?= base_url('public/assets/js/login.js?v=') . env('APP_VERSION', '1.0.0') ?>"></script>
</body>

</html>