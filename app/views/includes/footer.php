        <!-- Calendar Modal -->
        <div class="modal fade" id="calendarModal" tabindex="-1" aria-labelledby="calendarModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="calendarModalLabel">Calendar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Display-only calendar placeholder -->
                        <div class="calendar-shell">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <button class="btn btn-sm btn-light" type="button" disabled>
                                    <i class="fa-solid fa-chevron-left"></i>
                                </button>

                                <div class="fw-semibold" id="calendarTitle">Current Month</div>

                                <button class="btn btn-sm btn-light" type="button" disabled>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </button>
                            </div>

                            <div class="calendar-grid">
                                <!-- headers -->
                                <div class="calendar-grid-head">Sun</div>
                                <div class="calendar-grid-head">Mon</div>
                                <div class="calendar-grid-head">Tue</div>
                                <div class="calendar-grid-head">Wed</div>
                                <div class="calendar-grid-head">Thu</div>
                                <div class="calendar-grid-head">Fri</div>
                                <div class="calendar-grid-head">Sat</div>

                                <!-- JS will render day cells here -->
                                <div id="calendarDays" class="calendar-days"></div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>

            </main>
        </div>

        <!-- Loading Overlay -->
        <div id="loadingOverlay" class="loading-overlay d-none" role="status" aria-live="polite" aria-busy="true">
            <div class="loading-modal">
                <div class="loading-bar"></div>

                <div class="loading-body">
                    <div class="loading-seal" aria-hidden="true">
                        <img src="<?= base_url('public/assets/img/logo.png') ?>" alt="Barangay Cansangaya Logo">
                    </div>

                    <div class="loading-text">
                        <div class="loading-title">Please wait</div>
                        <div class="loading-sub">Processing your request…</div>

                        <div class="loading-progress" aria-hidden="true">
                            <span></span>
                        </div>

                        <div class="loading-note">
                            Barangay Cansangaya Household Information System
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap Bundle (includes Popper) -->
        <script src="<?= base_url('public/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
        <!-- JQuery -->
        <script src="<?= base_url('public/plugins/jquery/jquery-4.0.0.min.js') ?>"></script>
        <!-- SweetAlert2 -->
        <script src="<?= base_url('public/plugins/sweetalert2/sweetalert2.all.min.js') ?>"></script>
        <!-- Custom Script -->
        <script src="<?= base_url('public/assets/js/app.js?v=') . env('APP_VERSION', '1.0.0') ?>"></script>
    </body>
</html>