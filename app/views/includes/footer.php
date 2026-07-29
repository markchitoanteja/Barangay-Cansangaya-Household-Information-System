        <script>
            const ROLE = <?= json_encode(session_get('user', null)['role'] ?? null) ?>;
            const APP_DEBUG = <?= env('APP_DEBUG', true) ?>;
            const flashData = <?= json_encode(get_flash('flash_notif', null)) ?>;

            const genderData = <?= $title == 'Dashboard' ? json_encode($gender_data) : 'null' ?>;
            const residentStatus = <?= $title == 'Dashboard' ? json_encode($resident_status) : 'null' ?>;
            const employmentDataRaw = <?= $title == 'Dashboard' ? json_encode($employment_data) : 'null' ?>;
            const birthsRaw = <?= $title == 'Dashboard' ? json_encode($births) : 'null' ?>;
            const deathsRaw = <?= $title == 'Dashboard' ? json_encode($deaths) : 'null' ?>;
        </script>

        <!-- Bootstrap Bundle (includes Popper) -->
        <script src="<?= base_url('public/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
        <!-- JQuery -->
        <script src="<?= base_url('public/plugins/jquery/jquery-4.0.0.min.js') ?>"></script>
        <!-- SweetAlert2 -->
        <script src="<?= base_url('public/plugins/sweetalert2/sweetalert2.all.min.js') ?>"></script>
        <!-- Chart.js -->
        <script src="<?= base_url('public/plugins/chart.js/chart.umd.min.js') ?>"></script>
        <!-- Custom Script -->
        <script src="<?= base_url('public/assets/js/app.min.js?v=') . env('APP_VERSION', '1.0.0') ?>"></script>

        <?php if ($title == 'Dashboard'): ?>
            <!-- Dashboard Script -->
            <script src="<?= base_url('public/assets/js/dashboard.min.js?v=') . env('APP_VERSION', '1.0.0') ?>"></script>
        <?php endif ?>
    </body>

</html>