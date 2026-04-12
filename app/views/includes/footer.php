        <script>
            const ROLE = <?= json_encode(session_get('user', null)['role'] ?? null) ?>;
            const APP_DEBUG = <?= env('APP_DEBUG', true) ?>;
            const flashData = <?= json_encode(get_flash('flash_notif', null)) ?>;
        </script>

        <!-- Bootstrap Bundle (includes Popper) -->
        <script src="<?= base_url('public/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
        <!-- JQuery -->
        <script src="<?= base_url('public/plugins/jquery/jquery-4.0.0.min.js') ?>"></script>
        <!-- SweetAlert2 -->
        <script src="<?= base_url('public/plugins/sweetalert2/sweetalert2.all.min.js') ?>"></script>
        <!-- Custom Script -->
        <script src="<?= base_url('public/assets/js/app.min.js?v=') . env('APP_VERSION', '1.0.0') ?>"></script>
    </body>
</html>