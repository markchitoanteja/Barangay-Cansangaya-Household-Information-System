<!-- PAGE UNDER DEVELOPMENT -->
<section class="panel gov-dev-panel">

    <div class="panel-header">
        <h5>
            <i class="fa-solid fa-circle-info"></i>
            System Status
        </h5>
    </div>

    <div class="panel-body">

        <div class="gov-status-card">

            <!-- HEADER STRIP -->
            <div class="gov-status-header">
                <span class="gov-status-indicator"></span>
                <span>MODULE DEVELOPMENT STATUS</span>
            </div>

            <!-- BODY -->
            <div class="gov-status-body text-center">

                <div class="gov-icon mb-3">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                </div>

                <h5 class="gov-title">Page Under Active Development</h5>

                <p class="gov-text">
                    This module is currently undergoing system development and validation.
                    Certain features, interfaces, or functions may be temporarily unavailable.
                </p>

                <!-- STATUS GRID -->
                <div class="gov-meta-grid">

                    <div class="gov-meta-item">
                        <div class="label">Status</div>
                        <div class="value text-warning">IN DEVELOPMENT</div>
                    </div>

                    <div class="gov-meta-item">
                        <div class="label">Deployment</div>
                        <div class="value">STAGED RELEASE</div>
                    </div>

                    <div class="gov-meta-item">
                        <div class="label">Last Updated</div>
                        <div class="value">
                            <?php
                            $date = new DateTime(env('APP_LAST_UPDATED'));
                            echo $date->format('F j, Y');
                            ?>
                        </div>
                    </div>

                </div>

                <div class="gov-note mt-3">
                    System updates are applied periodically. Please check again later.
                </div>

            </div>

        </div>

    </div>

</section>