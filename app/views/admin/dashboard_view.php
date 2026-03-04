<!-- DASHBOARD (VIEW-ONLY) -->
<section class="panel">

    <div class="panel-header">
        <h5><i class="fa-solid fa-gauge"></i> Dashboard Overview</h5>

        <!-- view-only global search (redirects or filters later via JS/server) -->
        <div class="d-flex gap-2 align-items-center">
            <div class="input-group input-group-sm" style="max-width: 340px;">
                <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" class="form-control" placeholder="Search">
            </div>
        </div>
    </div>

    <div class="panel-body">
        <!-- INFO STRIP -->
        <div class="row g-3 mb-3">
            <div class="col-12 col-xl-8">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between flex-wrap gap-2">
                            <div>
                                <div class="text-muted small">Barangay</div>
                                <div class="fw-semibold">Brgy. Cansangaya</div>
                            </div>
                            <div>
                                <div class="text-muted small">As of Date</div>
                                <div class="fw-semibold">2026-03-04</div>
                            </div>
                            <div>
                                <div class="text-muted small">Last Sync</div>
                                <div class="fw-semibold">Today, 09:12 AM</div>
                            </div>
                            <div>
                                <div class="text-muted small">Data Status</div>
                                <span class="badge text-bg-success">Active</span>
                            </div>
                        </div>
                        <hr class="my-3">
                        <div class="text-muted small">
                            View-only dashboard for monitoring barangay household and resident statistics. For data updates,
                            proceed to the respective module pages.
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="fw-semibold mb-2"><i class="fa-solid fa-link me-1"></i> Quick Redirects</div>
                        <div class="d-grid gap-2">
                            <a href="#" class="btn btn-soft btn-sm text-start">
                                <i class="fa-solid fa-house me-2"></i> Households Module
                            </a>
                            <a href="#" class="btn btn-soft btn-sm text-start">
                                <i class="fa-solid fa-users me-2"></i> Residents Module
                            </a>
                            <a href="#" class="btn btn-soft btn-sm text-start">
                                <i class="fa-solid fa-chart-column me-2"></i> Demographics Module
                            </a>
                            <a href="#" class="btn btn-soft btn-sm text-start">
                                <i class="fa-solid fa-file-lines me-2"></i> Reports Module
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SUMMARY CARDS (ALL CLICKABLE / REDIRECT ONLY) -->
        <div class="row g-3 mb-4">

            <div class="col-12 col-md-6 col-xl-3">
                <a href="#" class="text-decoration-none">
                    <div class="card shadow-sm border-0 dashboard-card h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">Total Households</small>
                                <h4 class="fw-bold mb-0">1,284</h4>
                                <small class="text-muted">Registered families</small>
                            </div>
                            <i class="fa-solid fa-house fa-xl text-primary"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <a href="#" class="text-decoration-none">
                    <div class="card shadow-sm border-0 dashboard-card h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">Total Residents</small>
                                <h4 class="fw-bold mb-0">5,932</h4>
                                <small class="text-muted">All ages</small>
                            </div>
                            <i class="fa-solid fa-users fa-xl text-success"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <a href="#" class="text-decoration-none">
                    <div class="card shadow-sm border-0 dashboard-card h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">Senior Citizens</small>
                                <h4 class="fw-bold mb-0">624</h4>
                                <small class="text-muted">60+ years old</small>
                            </div>
                            <i class="fa-solid fa-person-cane fa-xl text-warning"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <a href="#" class="text-decoration-none">
                    <div class="card shadow-sm border-0 dashboard-card h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">Blotter Cases</small>
                                <h4 class="fw-bold mb-0">24</h4>
                                <small class="text-muted">This quarter</small>
                            </div>
                            <i class="fa-solid fa-scale-balanced fa-xl text-danger"></i>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <!-- TABLE SECTION: RECENT RESIDENTS (VIEW ONLY) -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-transparent">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h6 class="mb-0">
                            <i class="fa-solid fa-clock-rotate-left me-1"></i>
                            Recently Updated Residents
                        </h6>
                        <small class="text-muted">Latest updates recorded in the system</small>
                    </div>

                    <!-- table search + filters (view-only) -->
                    <div class="d-flex gap-2 align-items-center">
                        <div class="input-group input-group-sm" style="max-width: 260px;">
                            <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
                            <input type="text" class="form-control" placeholder="Search name, purok...">
                        </div>

                        <select class="form-select form-select-sm" style="max-width: 180px;">
                            <option selected>Filter: Purok (All)</option>
                            <option>Purok 1</option>
                            <option>Purok 2</option>
                            <option>Purok 3</option>
                            <option>Zone 4</option>
                            <option>Zone 5</option>
                        </select>

                        <a href="#" class="btn btn-soft btn-sm text-nowrap">
                            <i class="fa-solid fa-arrow-right me-1"></i> Open Residents
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width:60px;">#</th>
                                <th>Name</th>
                                <th>Household</th>
                                <th>Address</th>
                                <th>Updated</th>
                                <th class="text-end" style="width:120px;">View</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>01</td>
                                <td class="fw-semibold">Juan Dela Cruz</td>
                                <td><span class="badge text-bg-primary">HH-1021</span></td>
                                <td>123 A. Street</td>
                                <td>2026-03-04</td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-sm btn-soft">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>
                            </tr>

                            <tr>
                                <td>02</td>
                                <td class="fw-semibold">Maria Clara</td>
                                <td><span class="badge text-bg-primary">HH-0877</span></td>
                                <td>Purok 2</td>
                                <td>2026-03-03</td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-sm btn-soft">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>
                            </tr>

                            <tr>
                                <td>03</td>
                                <td class="fw-semibold">Pedro Penduko</td>
                                <td><span class="badge text-bg-primary">HH-0543</span></td>
                                <td>Zone 5</td>
                                <td>2026-03-02</td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-sm btn-soft">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- PAGINATION -->
            <div class="card-footer bg-transparent d-flex justify-content-between align-items-center flex-wrap gap-2">
                <small class="text-muted">Showing 1 to 3 of 56 entries</small>

                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#">Prev</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

    </div>

</section>