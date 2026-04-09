<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title><?= isset($title) ? $title : 'Unknown Page' ?> | Barangay <?= ucfirst($system_information['barangay_name']) ?> Household Information System</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url('public/assets/img/') . $system_information['official_logo'] . "?v=" . env('APP_VERSION', '1.0.0') ?>" type="image/x-icon">
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
                    <img src="<?= base_url('public/assets/img/') . $system_information['official_logo'] . "?v=" . env('APP_VERSION', '1.0.0') ?>" alt="Barangay Logo">
                </div>
                <div>
                    <h6>Barangay test</h6>
                    <small>Brgy. <?= ucfirst($system_information['barangay_name']) ?></small>
                </div>
            </div>

            <div class="nav-section">System Navigation</div>
            <nav class="nav flex-column side-nav">

                <!-- ADMIN + STAFF -->
                <a class="nav-link loadable <?= ($title == 'Dashboard') ? 'active' : '' ?>" href="dashboard" title="Dashboard">
                    <i class="fa-solid fa-gauge"></i>
                    <span class="nav-text">Dashboard</span>
                </a>

                <a class="nav-link loadable <?= ($title == 'Households') ? 'active' : '' ?>" href="households" title="Households">
                    <i class="fa-solid fa-house"></i>
                    <span class="nav-text">Households</span>
                </a>

                <a class="nav-link loadable <?= ($title == 'Residents') ? 'active' : '' ?>" href="residents" title="Residents">
                    <i class="fa-solid fa-users"></i>
                    <span class="nav-text">Residents</span>
                    <span class="nav-end">
                        <i class="fa-solid fa-exclamation-triangle text-danger" title="Page in development"></i>
                    </span>
                </a>

                <a class="nav-link loadable <?= ($title == 'Demographics') ? 'active' : '' ?>" href="demographics" title="Demographics">
                    <i class="fa-solid fa-chart-column"></i>
                    <span class="nav-text">Demographics</span>
                    <span class="nav-end">
                        <i class="fa-solid fa-exclamation-triangle text-danger" title="Page in development"></i>
                    </span>
                </a>

                <a class="nav-link loadable <?= ($title == 'Housing & Facilities') ? 'active' : '' ?>" href="housing-and-facilities" title="Housing & Facilities">
                    <i class="fa-solid fa-building"></i>
                    <span class="nav-text">Housing & Facilities</span>
                    <span class="nav-end">
                        <i class="fa-solid fa-exclamation-triangle text-danger" title="Page in development"></i>
                    </span>
                </a>

                <a class="nav-link loadable <?= ($title == 'Livelihood') ? 'active' : '' ?>" href="livelihood" title="Livelihood">
                    <i class="fa-solid fa-briefcase"></i>
                    <span class="nav-text">Livelihood</span>
                    <span class="nav-end">
                        <i class="fa-solid fa-exclamation-triangle text-danger" title="Page in development"></i>
                    </span>
                </a>

                <a class="nav-link loadable <?= ($title == 'Social Sectors') ? 'active' : '' ?>" href="social-sectors" title="Social Sectors">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                    <span class="nav-text">Social Sectors</span>
                    <span class="nav-end">
                        <i class="fa-solid fa-exclamation-triangle text-danger" title="Page in development"></i>
                    </span>
                </a>

                <a class="nav-link loadable <?= ($title == 'Health Monitoring') ? 'active' : '' ?>" href="health-monitoring" title="Health Monitoring">
                    <i class="fa-solid fa-heart-pulse"></i>
                    <span class="nav-text">Health Monitoring</span>
                    <span class="nav-end">
                        <i class="fa-solid fa-exclamation-triangle text-danger" title="Page in development"></i>
                    </span>
                </a>

                <a class="nav-link loadable <?= ($title == 'Reports') ? 'active' : '' ?>" href="reports" title="Reports">
                    <i class="fa-solid fa-file-lines"></i>
                    <span class="nav-text">Reports</span>
                    <span class="nav-end">
                        <i class="fa-solid fa-exclamation-triangle text-danger" title="Page in development"></i>
                    </span>
                </a>

                <!-- ADMIN ONLY -->
                <?php if (isset($user) && ($user['role'] === 'ADMIN' || $user['role'] === 'SUPER_ADMIN')): ?>
                    <a class="nav-link loadable <?= ($title == 'User Management') ? 'active' : '' ?>" href="user-management" title="User Management">
                        <i class="fa-solid fa-id-badge"></i>
                        <span class="nav-text">User Management</span>
                    </a>
                <?php endif; ?>

                <a class="nav-link btn_logout <?= ($title == 'Logout') ? 'active' : '' ?>" href="javascript:void(0)" title="Logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span class="nav-text">Logout</span>
                </a>
            </nav>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="main">
            <!-- TOP BAR -->
            <div class="topbar">
                <div class="d-flex align-items-center gap-2">
                    <!-- ✅ Sidebar Toggle Button -->
                    <button class="sidebar-toggle" id="sidebarToggle">
                        <i class="fa-solid fa-bars"></i>
                    </button>

                    <div>
                        <p class="subtitle">Barangay <?= ucfirst($system_information['barangay_name']) ?> Household Information System</p>
                        <h4 class="title"><?= isset($title) ? strtoupper($title) : 'UNKNOWN PAGE' ?></h4>
                    </div>
                </div>

                <div class="d-flex gap-2 align-items-center">
                    <!-- System Update -->
                    <?php if (isset($user) && ($user['role'] === 'ADMIN' || $user['role'] === 'SUPER_ADMIN')): ?>
                        <div class="dropdown d-none" id="drpdwn_updates">
                            <button id="btnCheckUpdates" class="pill pill-btn position-relative" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-rotate"></i>

                                <!-- Badge -->
                                <span id="updateBadge" class="update-badge d-none">0</span>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end shadow notification-dropdown">
                                <li class="p-3 border-bottom fw-bold">
                                    System Updates
                                </li>

                                <li id="updateStatus" class="p-3 text-muted">
                                    Checking for updates...
                                </li>

                                <li class="p-2 border-top text-center">
                                    <button id="btnUpdateSystem" class="btn btn-sm btn-primary w-100">
                                        Apply Updates
                                    </button>
                                </li>
                            </ul>
                        </div>
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
                            <?php if ($user['role'] === 'SUPER_ADMIN'): ?>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#systemInfoModal">
                                        <i class="fa-solid fa-server me-2"></i> Update System Information
                                    </a>
                                </li>
                            <?php endif ?>
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