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