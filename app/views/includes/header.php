<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title><?= isset($title) ? $title : 'Unknown Page' ?> | <?= env('APP_NAME') ?></title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url('public/assets/img/favicon.ico') ?>" type="image/x-icon">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= base_url('public/plugins/bootstrap/css/bootstrap.min.css') ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('public/plugins/fontawesome/css/all.min.css') ?>">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('public/assets/css/app.css?v=') . env('APP_VERSION', '1.0.0') ?>">
</head>

<body>
    <div class="app">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="brand">
                <div class="brand-badge">
                    <!-- Replace with your logo -->
                    <img src="<?= base_url('public/assets/img/logo.png') ?>" alt="Barangay Logo">
                </div>
                <div>
                    <!-- <h6>Barangay HIS</h6> -->
                    <h6>Barangay Fucker</h6>
                    <small>Brgy. Cansangaya</small>
                </div>
            </div>

            <div class="nav-section">System Navigation</div>
            <nav class="nav flex-column side-nav">
                <!-- Accessible by ADMIN and STAFF -->
                <a class="nav-link loadable <?= ($title == 'Dashboard') ? 'active' : '' ?>" href="dashboard">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <span><i class="fa-solid fa-gauge"></i> Dashboard</span>
                    </div>
                </a>
                <a class="nav-link loadable <?= ($title == 'Households') ? 'active' : '' ?>" href="households">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <span><i class="fa-solid fa-house"></i> Households</span>
                        <i class="fa-solid fa-exclamation-triangle text-danger" title="Page in development"></i>
                    </div>
                </a>
                <a class="nav-link loadable <?= ($title == 'Residents') ? 'active' : '' ?>" href="residents">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <span><i class="fa-solid fa-users"></i> Residents</span>
                        <i class="fa-solid fa-exclamation-triangle text-danger" title="Page in development"></i>
                    </div>
                </a>
                <a class="nav-link loadable <?= ($title == 'Demographics') ? 'active' : '' ?>" href="demographics">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <span><i class="fa-solid fa-chart-column"></i> Demographics</span>
                        <i class="fa-solid fa-exclamation-triangle text-danger" title="Page in development"></i>
                    </div>
                </a>
                <a class="nav-link loadable <?= ($title == 'Housing & Facilities') ? 'active' : '' ?>" href="housing-and-facilities">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <span><i class="fa-solid fa-building"></i> Housing & Facilities</span>
                        <i class="fa-solid fa-exclamation-triangle text-danger" title="Page in development"></i>
                    </div>
                </a>
                <a class="nav-link loadable <?= ($title == 'Livelihood') ? 'active' : '' ?>" href="livelihood">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <span><i class="fa-solid fa-briefcase"></i> Livelihood</span>
                        <i class="fa-solid fa-exclamation-triangle text-danger" title="Page in development"></i>
                    </div>
                </a>
                <a class="nav-link loadable <?= ($title == 'Social Sectors') ? 'active' : '' ?>" href="social-sectors">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <span><i class="fa-solid fa-hand-holding-heart"></i> Social Sectors</span>
                        <i class="fa-solid fa-exclamation-triangle text-danger" title="Page in development"></i>
                    </div>
                </a>
                <a class="nav-link loadable <?= ($title == 'Health Monitoring') ? 'active' : '' ?>" href="health-monitoring">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <span><i class="fa-solid fa-heart-pulse"></i> Health Monitoring</span>
                        <i class="fa-solid fa-exclamation-triangle text-danger" title="Page in development"></i>
                    </div>
                </a>
                <a class="nav-link loadable <?= ($title == 'Reports') ? 'active' : '' ?>" href="reports">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <span><i class="fa-solid fa-file-lines"></i> Reports</span>
                        <i class="fa-solid fa-exclamation-triangle text-danger" title="Page in development"></i>
                    </div>
                </a>

                <!-- ADMIN ONLY -->
                <?php if (isset($user) && $user['role'] === 'ADMIN'): ?>
                    <a class="nav-link loadable <?= ($title == 'User Management') ? 'active' : '' ?>" href="user-management">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <span><i class="fa-solid fa-id-badge"></i> User Management</span>
                        </div>
                    </a>
                <?php endif; ?>

                <a class="nav-link btn_logout <?= ($title == 'Logout') ? 'active' : '' ?>" href="javascript:void(0)">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <span><i class="fa-solid fa-right-from-bracket"></i> Logout</span>
                    </div>
                </a>
            </nav>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="main">
            <!-- TOP BAR -->
            <div class="topbar">
                <div>
                    <p class="subtitle">Barangay Cansangaya Household Information System</p>
                    <h4 class="title"><?= isset($title) ? strtoupper($title) : 'UNKNOWN PAGE' ?></h4>
                </div>

                <div class="d-flex gap-2 align-items-center">
                    <?php if (isset($user) && $user['role'] === 'ADMIN'): ?>
                        <!-- Update System Button Placeholder -->
                        <div id="updateSystemWrapper"></div>
                    <?php endif; ?>

                    <!-- Calendar -->
                    <button type="button" id="openCalendarModal" class="pill pill-btn" data-bs-toggle="modal" data-bs-target="#calendarModal">
                        <i class="fa-solid fa-calendar-days"></i>
                        <span id="todayText">Today</span>
                    </button>

                    <!-- User Dropdown -->
                    <div class="dropdown">
                        <button class="btn user-chip d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?= base_url('public/assets/img/user-avatar.png') ?>" alt="User" class="user-chip__avatar">
                            <span class="user-chip__name d-none d-md-inline">
                                <?= isset($user) ? esc($user['full_name']) : 'Default User' ?>
                            </span>
                            <i class="fa-solid fa-chevron-down user-chip__chev"></i>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end shadow user-menu">
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#accountSettingsModal">
                                    <i class="fa-solid fa-user-gear me-2"></i> Account Settings
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item btn-security-questions" href="javascript:void(0)"
                                    data-bs-toggle="modal"
                                    data-bs-target="#securityQuestionsModal"
                                    data-user_id="<?= $user['id'] ?>"
                                    data-username="<?= esc($user['username']) ?>"
                                    data-security_questions='<?= json_encode($security_questions, JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
                                    <i class="fa-solid fa-shield-halved me-2"></i> Update Security Questions
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#aboutUsModal">
                                    <i class="fa-solid fa-circle-info me-2"></i> About Us
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item text-danger btn_logout" href="javascript:void(0)">
                                    <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
