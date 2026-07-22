<!-- PAGINATION -->
<?php if ($total_pages > 1): ?>
    <nav aria-label="Household pagination">
        <ul class="pagination justify-content-center mt-3">
            <?php $query_params = $_GET; ?>

            <!-- Previous -->
            <li class="page-item <?= ($current_page <= 1) ? 'disabled' : '' ?>">
                <?php $query_params['page'] = $current_page - 1; ?>
                <a class="loadable page-link" href="?<?= http_build_query($query_params) ?>">&laquo; Prev</a>
            </li>

            <!-- Pages -->
            <?php
            $max_visible = 5;
            $side = 1;
            $start = max(2, $current_page - $side);
            $end = min($total_pages - 1, $current_page + $side);
            if ($current_page <= $side + 2) {
                $start = 2;
                $end = min($total_pages - 1, $max_visible);
            }
            if ($current_page >= $total_pages - ($side + 1)) {
                $start = max(2, $total_pages - $max_visible);
                $end = $total_pages - 1;
            }
            $query_params['page'] = 1; ?>
            <li class="page-item <?= ($current_page == 1) ? 'active' : '' ?>">
                <a class="loadable page-link" href="?<?= http_build_query($query_params) ?>">1</a>
            </li>
            <?php if ($start > 2): ?>
                <li class="page-item disabled"><span class="page-link">…</span></li>
            <?php endif; ?>
            <?php for ($p = $start; $p <= $end; $p++):
                $query_params['page'] = $p; ?>
                <li class="page-item <?= ($current_page == $p) ? 'active' : '' ?>">
                    <a class="loadable page-link" href="?<?= http_build_query($query_params) ?>">
                        <?= $p ?>
                    </a>
                </li>
            <?php endfor; ?>
            <?php if ($end < $total_pages - 1): ?>
                <li class="page-item disabled"><span class="page-link">…</span></li>
            <?php endif; ?>
            <?php if ($total_pages > 1):
                $query_params['page'] = $total_pages; ?>
                <li class="page-item <?= ($current_page == $total_pages) ? 'active' : '' ?>">
                    <a class="loadable page-link" href="?<?= http_build_query($query_params) ?>">
                        <?= $total_pages ?>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Next -->
            <li class="page-item <?= ($current_page >= $total_pages) ? 'disabled' : '' ?>">
                <?php $query_params['page'] = $current_page + 1; ?>
                <a class="loadable page-link" href="?<?= http_build_query($query_params) ?>">Next &raquo;</a>
            </li>
        </ul>
    </nav>
<?php endif; ?>

</div>
</section>