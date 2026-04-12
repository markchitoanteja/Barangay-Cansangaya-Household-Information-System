<section class="panel">
    <div class="panel-body">
        <div class="row g-3">

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

            <!-- Demographics -->
            <div class="col-md-3">
                <a href="demographics" class="gov-stat-link loadable">
                    <div class="card gov-stat-card">
                        <div class="gov-stat-header">
                            <i class="fa-solid fa-chart-column"></i>
                            <span>Demographics</span>
                            <i class="fa-solid fa-arrow-right ms-auto gov-arrow"></i>
                        </div>
                        <div class="gov-stat-body">
                            <h3><?= number_format($total_demographics ?? 0) ?></h3>
                            <small>Population breakdown insights</small>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Health Monitoring -->
            <div class="col-md-3">
                <a href="health-monitoring" class="gov-stat-link loadable">
                    <div class="card gov-stat-card">
                        <div class="gov-stat-header">
                            <i class="fa-solid fa-heart-pulse"></i>
                            <span>Health Monitoring</span>
                            <i class="fa-solid fa-arrow-right ms-auto gov-arrow"></i>
                        </div>
                        <div class="gov-stat-body">
                            <h3><?= number_format($total_health ?? 0) ?></h3>
                            <small>Medical records tracked</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

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
                                <td><?= date("M d, Y h:i A", strtotime($log['created_at'])) ?></td>
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

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <nav aria-label="Logs pagination">
                <ul class="pagination justify-content-center mt-3">
                    <?php $params = $_GET; ?>

                    <!-- Previous button -->
                    <li class="page-item <?= ($current_page <= 1) ? 'disabled' : '' ?>">
                        <?php $params['page'] = $current_page - 1; ?>
                        <a class="page-link loadable" href="?<?= http_build_query($params) ?>">&laquo; Prev</a>
                    </li>

                    <?php
                    $max_visible = 5; // total numbers including current
                    $side = 1;         // pages shown on either side of current

                    $start = max(2, $current_page - $side);
                    $end = min($total_pages - 1, $current_page + $side);

                    // adjust if near the start
                    if ($current_page <= $side + 2) {
                        $start = 2;
                        $end = min($total_pages - 1, $max_visible);
                    }

                    // adjust if near the end
                    if ($current_page >= $total_pages - ($side + 1)) {
                        $start = max(2, $total_pages - $max_visible);
                        $end = $total_pages - 1;
                    }

                    // First page
                    $params['page'] = 1;
                    ?>
                    <li class="page-item <?= ($current_page == 1) ? 'active' : '' ?>">
                        <a class="page-link loadable" href="?<?= http_build_query($params) ?>">1</a>
                    </li>

                    <!-- Ellipsis before start -->
                    <?php if ($start > 2): ?>
                        <li class="page-item disabled"><span class="page-link">…</span></li>
                    <?php endif; ?>

                    <!-- Middle pages -->
                    <?php for ($p = $start; $p <= $end; $p++):
                        $params['page'] = $p;
                    ?>
                        <li class="page-item <?= ($current_page == $p) ? 'active' : '' ?>">
                            <a class="page-link loadable" href="?<?= http_build_query($params) ?>"><?= $p ?></a>
                        </li>
                    <?php endfor; ?>

                    <!-- Ellipsis after end -->
                    <?php if ($end < $total_pages - 1): ?>
                        <li class="page-item disabled"><span class="page-link">…</span></li>
                    <?php endif; ?>

                    <!-- Last page -->
                    <?php if ($total_pages > 1):
                        $params['page'] = $total_pages; ?>
                        <li class="page-item <?= ($current_page == $total_pages) ? 'active' : '' ?>">
                            <a class="page-link loadable" href="?<?= http_build_query($params) ?>"><?= $total_pages ?></a>
                        </li>
                    <?php endif; ?>

                    <!-- Next button -->
                    <li class="page-item <?= ($current_page >= $total_pages) ? 'disabled' : '' ?>">
                        <?php $params['page'] = $current_page + 1; ?>
                        <a class="page-link loadable" href="?<?= http_build_query($params) ?>">Next &raquo;</a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</section>