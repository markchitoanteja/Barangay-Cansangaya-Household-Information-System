<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Barangay Household Information System - <?= isset($title) ? $title : 'Unknown Page' ?></title>

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
                    <h6>Barangay HIS</h6>
                    <small>Brgy. Cansangaya</small>
                </div>
            </div>

            <div class="nav-section">System Navigation</div>
            <nav class="nav flex-column side-nav">
                <a class="nav-link <?= ($title == 'Dashboard') ? 'active' : '' ?>" href="dashboard"><i class="fa-solid fa-gauge"></i> Dashboard</a>
                <a class="nav-link <?= ($title == 'Households') ? 'active' : '' ?>" href="households"><i class="fa-solid fa-house"></i> Households</a>
                <a class="nav-link <?= ($title == 'Residents') ? 'active' : '' ?>" href="residents"><i class="fa-solid fa-users"></i> Residents</a>
                <a class="nav-link <?= ($title == 'Demographics') ? 'active' : '' ?>" href="demographics"><i class="fa-solid fa-chart-column"></i> Demographics</a>
                <a class="nav-link <?= ($title == 'Housing & Facilities') ? 'active' : '' ?>" href="housing_facilities"><i class="fa-solid fa-building"></i> Housing & Facilities</a>
                <a class="nav-link <?= ($title == 'Livelihood') ? 'active' : '' ?>" href="livelihood"><i class="fa-solid fa-briefcase"></i> Livelihood</a>
                <a class="nav-link <?= ($title == 'Social Sectors') ? 'active' : '' ?>" href="social_sectors"><i class="fa-solid fa-hand-holding-heart"></i> Social Sectors</a>
                <a class="nav-link <?= ($title == 'Health Monitoring') ? 'active' : '' ?>" href="health_monitoring"><i class="fa-solid fa-heart-pulse"></i> Health Monitoring</a>
                <a class="nav-link <?= ($title == 'Reports') ? 'active' : '' ?>" href="reports"><i class="fa-solid fa-file-lines"></i> Reports</a>
                <a class="nav-link <?= ($title == 'User Management') ? 'active' : '' ?>" href="user_management"><i class="fa-solid fa-id-badge"></i> User Management</a>
                <a class="nav-link <?= ($title == 'Settings') ? 'active' : '' ?>" href="settings"><i class="fa-solid fa-gear"></i> Settings</a>
                <a class="nav-link btn_logout" href="javascript:void(0)"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
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
                    <button type="button" id="openCalendarModal" class="pill pill-btn" data-bs-toggle="modal" data-bs-target="#calendarModal">
                        <i class="fa-solid fa-calendar-days"></i>
                        <span id="todayText">Today</span>
                    </button>

                    <!-- User Dropdown -->
                    <div class="dropdown">
                        <button class="btn user-chip d-flex align-items-center gap-2"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">

                            <img src="<?= base_url('public/assets/img/user-avatar.png') ?>"
                                alt="User"
                                class="user-chip__avatar">

                            <span class="user-chip__name d-none d-md-inline">
                                <?= isset($user) ? esc($user['full_name']) : 'Default User' ?>
                            </span>

                            <i class="fa-solid fa-chevron-down user-chip__chev"></i>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end shadow user-menu">
                            <li>
                                <a class="dropdown-item" href="account_settings">
                                    <i class="fa-solid fa-user-gear me-2"></i> Account Settings
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="about_us">
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