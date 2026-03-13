<section class="panel">
    <div class="panel-header d-flex justify-content-between align-items-center mb-3">
        <h5><i class="fa-solid fa-file-lines me-2"></i>System Logs</h5>

        <?php if (session_get('user')['role'] === 'ADMIN'): ?>
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
                    <li class="page-item <?= ($current_page <= 1) ? 'disabled' : '' ?>">
                        <?php $params['page'] = $current_page - 1; ?>
                        <a class="page-link" href="?<?= http_build_query($params) ?>">&laquo; Prev</a>
                    </li>
                    <?php for ($p = 1; $p <= $total_pages; $p++): ?>
                        <?php $params['page'] = $p; ?>
                        <li class="page-item <?= ($p == $current_page) ? 'active' : '' ?>">
                            <a class="page-link" href="?<?= http_build_query($params) ?>"><?= $p ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= ($current_page >= $total_pages) ? 'disabled' : '' ?>">
                        <?php $params['page'] = $current_page + 1; ?>
                        <a class="page-link" href="?<?= http_build_query($params) ?>">Next &raquo;</a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</section>