<!-- Cards -->
<section class="panel">
    <div class="panel-body">
        <div class="row g-3 mb-3">
            <!-- Households -->
            <div class="col-md-3">
                <a href="households" class="gov-stat-link loadable">
                    <div class="card gov-stat-card">
                        <div class="gov-stat-header">
                            <i class="fa-solid fa-house"></i>
                            <span>Households</span>
                            <i class="fa-solid fa-arrow-right ms-auto gov-arrow"></i>
                        </div>
                        <div class="gov-stat-body">
                            <h3><?= number_format($total_households ?? 0) ?></h3>
                            <small>Registered family units</small>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Residents -->
            <div class="col-md-3">
                <a href="residents" class="gov-stat-link loadable">
                    <div class="card gov-stat-card">
                        <div class="gov-stat-header">
                            <i class="fa-solid fa-users"></i>
                            <span>Residents</span>
                            <i class="fa-solid fa-arrow-right ms-auto gov-arrow"></i>
                        </div>
                        <div class="gov-stat-body">
                            <h3><?= number_format($total_residents ?? 0) ?></h3>
                            <small>Total population recorded</small>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Programs -->
            <div class="col-md-3">
                <a href="programs" class="gov-stat-link loadable">
                    <div class="card gov-stat-card">
                        <div class="gov-stat-header">
                            <i class="fa-solid fa-hand-holding-heart"></i>
                            <span>Programs</span>
                            <i class="fa-solid fa-arrow-right ms-auto gov-arrow"></i>
                        </div>
                        <div class="gov-stat-body">
                            <h3><?= number_format($total_programs ?? 0) ?></h3>
                            <small>Active programs</small>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Beneficiaries -->
            <div class="col-md-3">
                <a href="programs-beneficiaries" class="gov-stat-link loadable">
                    <div class="card gov-stat-card">
                        <div class="gov-stat-header">
                            <i class="fa-solid fa-user-friends"></i>
                            <span>Beneficiaries</span>
                            <i class="fa-solid fa-arrow-right ms-auto gov-arrow"></i>
                        </div>
                        <div class="gov-stat-body">
                            <h3><?= number_format($total_beneficiaries ?? 0) ?></h3>
                            <small>Registered beneficiaries</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row g-3">
            <!-- Birth Records -->
            <div class="col-md-3">
                <a href="birth-records" class="gov-stat-link loadable">
                    <div class="card gov-stat-card">
                        <div class="gov-stat-header">
                            <i class="fa-solid fa-baby"></i>
                            <span>Birth Records</span>
                            <i class="fa-solid fa-arrow-right ms-auto gov-arrow"></i>
                        </div>
                        <div class="gov-stat-body">
                            <h3><?= number_format($total_birth_records ?? 0) ?></h3>
                            <small>Registered births</small>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Death Records -->
            <div class="col-md-3">
                <a href="death-records" class="gov-stat-link loadable">
                    <div class="card gov-stat-card">
                        <div class="gov-stat-header">
                            <i class="fa-solid fa-cross"></i>
                            <span>Death Records</span>
                            <i class="fa-solid fa-arrow-right ms-auto gov-arrow"></i>
                        </div>
                        <div class="gov-stat-body">
                            <h3><?= number_format($total_death_records ?? 0) ?></h3>
                            <small>Recorded deaths</small>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Migration In -->
            <div class="col-md-3">
                <a href="migration-records" class="gov-stat-link loadable">
                    <div class="card gov-stat-card">
                        <div class="gov-stat-header">
                            <i class="fa-solid fa-right-to-bracket"></i>
                            <span>Migration In</span>
                            <i class="fa-solid fa-arrow-right ms-auto gov-arrow"></i>
                        </div>
                        <div class="gov-stat-body">
                            <h3><?= number_format($total_migration_in_records ?? 0) ?></h3>
                            <small>Residents moved in</small>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Migration Out -->
            <div class="col-md-3">
                <a href="migration-records" class="gov-stat-link loadable">
                    <div class="card gov-stat-card">
                        <div class="gov-stat-header">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>Migration Out</span>
                            <i class="fa-solid fa-arrow-right ms-auto gov-arrow"></i>
                        </div>
                        <div class="gov-stat-body">
                            <h3><?= number_format($total_migration_out_records ?? 0) ?></h3>
                            <small>Residents moved out</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Charts -->
<section class="panel mt-4">
    <div class="panel-header mb-3">
        <h5>
            <i class="fa-solid fa-chart-column me-2"></i>
            Population Analytics
        </h5>
    </div>

    <div class="panel-body">

        <div class="row g-4">

            <!-- Population by Sex -->
            <div class="col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header">
                        <strong>Population by Sex</strong>
                    </div>

                    <div class="card-body">
                        <canvas id="genderChart" height="220"></canvas>
                    </div>
                </div>
            </div>

            <!-- Resident Status -->
            <div class="col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header">
                        <strong>Resident Status</strong>
                    </div>

                    <div class="card-body">
                        <canvas id="residentStatusChart" height="220"></canvas>
                    </div>
                </div>
            </div>

            <!-- Births vs Deaths -->
            <div class="col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header">
                        <strong>Births vs Deaths (<span id="currentYear">Current Year</span>)</strong>
                    </div>

                    <div class="card-body">
                        <canvas id="birthDeathChart" height="220"></canvas>
                    </div>
                </div>
            </div>

            <!-- Employment -->
            <div class="col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header">
                        <strong>Employment Status</strong>
                    </div>

                    <div class="card-body">
                        <canvas id="employmentChart" height="220"></canvas>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- Logs -->
<section class="panel">
    <div class="panel-header d-flex justify-content-between align-items-center mb-3">
        <h5><i class="fa-solid fa-file-lines me-2"></i>System Logs</h5>

        <?php if (session_get('user')['role'] === 'ADMIN' || session_get('user')['role'] === 'SUPER_ADMIN'): ?>
            <div class="d-flex gap-2">
                <!-- Export Logs -->
                <button class="btn btn-success" id="exportLogsBtn">
                    <i class="fa-solid fa-file-export me-1"></i> Export
                </button>

                <!-- Clear Logs -->
                <button class="btn btn-danger" id="clearLogsBtn">
                    <i class="fa-solid fa-trash me-1"></i> Clear Logs
                </button>
            </div>
        <?php endif; ?>
    </div>

    <div class="panel-body mb-3">
        <!-- Simple Logs Search -->
        <form id="logsFilterForm" class="row g-2 mb-3 justify-content-end" action="javascript:void(0)">
            <div class="col-md-4">
                <div class="form-floating">
                    <input type="text" id="search" class="form-control gov-input" placeholder="Search logs" value="<?= esc($search ?? '') ?>">
                    <label>Search logs by User, Action or Description</label>
                </div>
            </div>
            <div class="col-md-3 d-flex">
                <button type="submit" class="btn btn-primary flex-grow-1 me-2">
                    <i class="fa-solid fa-magnifying-glass me-1"></i>Search
                </button>
                <button type="button" class="btn btn-outline-secondary flex-grow-1" id="reset_logs_filter">
                    <i class="fa-solid fa-arrows-rotate me-1"></i>Reset
                </button>
            </div>
        </form>

        <!-- Logs Table -->
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle border rounded">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">#</th>
                        <th>User's Full Name</th>
                        <th>Action</th>
                        <th>Description</th>
                        <th>Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($logs)): ?>
                        <?php $count = ($current_page - 1) * 10 + 1; ?>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td class="text-center"><?= $count ?></td>
                                <td><?= esc($log['full_name']) ?></td>
                                <td><?= esc($log['action']) ?></td>
                                <td><?= esc($log['description'] ?? 'N/A') ?></td>
                                <td><?= date("F d, Y h:i A", strtotime($log['created_at'])) ?></td>
                            </tr>
                            <?php $count++; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="text-center">
                            <td colspan="7">No logs to display.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>