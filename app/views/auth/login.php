<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Barangay Cansangaya Household Information System - Login</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url('public/assets/img/favicon.ico') ?>" type="image/x-icon">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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

        <!-- RIGHT PANEL (Professional Minimal) -->
        <main class="right-panel">
            <section class="login-card">

                <header class="login-header mb-4 text-center">
                    <h4 class="fw-semibold mb-1">Authorized Personnel Login</h4>
                    <p class="text-muted small mb-0">Access the Barangay Cansangaya Household System</p>
                </header>

                <form action="<?= site_url('auth/login') ?>" method="post" autocomplete="on">

                    <!-- ROLE SELECTOR -->
                    <div class="role-selector mb-4">
                        <div class="btn-group w-100" role="group" aria-label="Role selector">
                            <input type="radio" class="btn-check" name="role" id="roleAdmin" value="admin" checked>
                            <label class="btn btn-outline-primary" for="roleAdmin">
                                <i class="fa-solid fa-user-shield me-1"></i> Administrator
                            </label>

                            <input type="radio" class="btn-check" name="role" id="roleStaff" value="staff">
                            <label class="btn btn-outline-primary" for="roleStaff">
                                <i class="fa-solid fa-user me-1"></i> Staff
                            </label>
                        </div>
                    </div>

                    <!-- USERNAME -->
                    <div class="form-floating mb-3">
                        <input
                            type="text"
                            name="username"
                            class="form-control"
                            id="username"
                            placeholder="Username"
                            required>
                        <label for="username">
                            <i class="fa-regular fa-user me-1"></i> Username
                        </label>
                    </div>

                    <!-- PASSWORD -->
                    <div class="form-floating mb-3 position-relative">
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            id="password"
                            placeholder="Password"
                            required>
                        <label for="password">
                            <i class="fa-solid fa-lock me-1"></i> Password
                        </label>

                        <button
                            type="button"
                            class="btn btn-sm position-absolute top-50 end-0 translate-middle-y me-2 text-secondary border-0"
                            id="togglePassword"
                            aria-label="Toggle password visibility">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>

                    <!-- OPTIONS -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label small" for="remember">Remember me</label>
                        </div>

                        <a href="<?= site_url('auth/forgot') ?>" class="small text-decoration-none">
                            Forgot password?
                        </a>
                    </div>

                    <!-- SUBMIT -->
                    <button type="submit" class="btn btn-primary w-100 py-2">
                        <i class="fa-solid fa-right-to-bracket me-1"></i> Login
                    </button>

                    <footer class="text-center mt-4 small text-muted">
                        © <span id="year"></span> Barangay Cansangaya
                    </footer>
                </form>
            </section>
        </main>

    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(function() {
            // Footer year
            $("#year").text(new Date().getFullYear());

            // Password toggle
            $("#togglePassword").on("click", function() {
                const $pw = $("#password");
                const isPassword = $pw.attr("type") === "password";

                $pw.attr("type", isPassword ? "text" : "password");

                $(this).html(
                    isPassword ?
                    '<i class="fa-regular fa-eye-slash"></i>' :
                    '<i class="fa-regular fa-eye"></i>'
                );
            });
        });
    </script>
</body>

</html>