<!-- Loading Overlay -->
<div id="loadingOverlay" class="loading-overlay d-none" role="status" aria-live="polite" aria-busy="true">
    <div class="loading-modal">
        <div class="loading-bar"></div>

        <div class="loading-body">
            <div class="loading-seal" aria-hidden="true">
                <img src="<?= base_url('public/assets/img/') . $system_information['official_logo'] . '?v=' . env('APP_VERSION') ?>" alt="Barangay Cansangaya Logo">
            </div>

            <div class="loading-text">
                <div class="loading-title">Please wait</div>
                <div class="loading-sub">Processing your request…</div>

                <div class="loading-progress" aria-hidden="true">
                    <span></span>
                </div>

                <div class="loading-note">
                    Barangay <?= ucfirst($system_information['barangay_name']) ?> Household Information System
                </div>
            </div>
        </div>
    </div>
</div>