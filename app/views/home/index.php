<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Barangay Information Management System - Archives</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Icons (Bootstrap Icons) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <style>
    :root{
      --sidebar-w: 260px;
      --sidebar-bg: #0b3a6e;
      --sidebar-bg-2: #082c53;
      --sidebar-accent: #f7c948;
      --content-bg: #f5f7fb;
    }

    body{
      background: var(--content-bg);
    }

    /* App shell */
    .app{
      min-height: 100vh;
      display: grid;
      grid-template-columns: var(--sidebar-w) 1fr;
    }

    /* Sidebar */
    .sidebar{
      background: linear-gradient(180deg, var(--sidebar-bg), var(--sidebar-bg-2));
      color: #fff;
      padding: 18px 14px;
      position: sticky;
      top: 0;
      height: 100vh;
      overflow-y: auto;
    }
    .brand{
      display: flex;
      gap: 12px;
      align-items: center;
      padding: 10px 10px 14px;
      border-bottom: 1px solid rgba(255,255,255,.12);
      margin-bottom: 12px;
    }
    .brand-badge{
      width: 54px;
      height: 54px;
      border-radius: 50%;
      background: #ffffff;
      display: grid;
      place-items: center;
      border: 3px solid var(--sidebar-accent);
      overflow: hidden;
    }
    .brand-badge img{
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .brand h6{
      margin: 0;
      font-weight: 700;
      line-height: 1.1;
    }
    .brand small{
      opacity: .8;
    }

    .nav-section{
      margin-top: 10px;
      font-size: .75rem;
      letter-spacing: .08em;
      text-transform: uppercase;
      opacity: .75;
      padding: 8px 10px;
    }

    .side-nav .nav-link{
      color: rgba(255,255,255,.86);
      border-radius: 10px;
      padding: 10px 12px;
      display: flex;
      align-items: center;
      gap: 10px;
      transition: .15s ease;
    }
    .side-nav .nav-link:hover{
      background: rgba(255,255,255,.10);
      color: #fff;
    }
    .side-nav .nav-link.active{
      background: rgba(247,201,72,.18);
      border: 1px solid rgba(247,201,72,.35);
      color: #fff;
    }
    .side-nav .bi{
      font-size: 1.05rem;
      width: 1.4rem;
      text-align: center;
      opacity: .95;
    }

    .sidebar-footer{
      margin-top: 14px;
      padding: 10px;
      border-top: 1px solid rgba(255,255,255,.12);
      opacity: .9;
      font-size: .9rem;
    }

    /* Main */
    .main{
      padding: 18px 18px 28px;
    }

    .topbar{
      background: #fff;
      border-radius: 14px;
      padding: 14px 16px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 8px 22px rgba(16,24,40,.06);
    }
    .topbar .title{
      margin: 0;
      font-weight: 800;
      letter-spacing: .02em;
    }
    .topbar .subtitle{
      margin: 0;
      color: #6b7280;
      font-size: .9rem;
    }
    .pill{
      background: #f3f4f6;
      border: 1px solid #e5e7eb;
      padding: 8px 12px;
      border-radius: 999px;
      display: flex;
      align-items: center;
      gap: 8px;
      color: #374151;
    }

    .panel{
      margin-top: 16px;
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 8px 22px rgba(16,24,40,.06);
      overflow: hidden;
    }
    .panel-header{
      padding: 14px 16px;
      border-bottom: 1px solid #eef2f7;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
    }
    .panel-header h5{
      margin: 0;
      font-weight: 800;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .panel-body{
      padding: 14px 16px 16px;
    }

    .filters{
      display: grid;
      grid-template-columns: 1.1fr 1fr 1fr 1fr;
      gap: 10px;
    }
    @media (max-width: 1200px){
      .filters{ grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 768px){
      .app{ grid-template-columns: 1fr; }
      .sidebar{ position: relative; height: auto; }
      .filters{ grid-template-columns: 1fr; }
    }

    .table thead th{
      background: #f8fafc;
      color: #334155;
      font-weight: 700;
      border-bottom: 1px solid #eef2f7;
    }

    .btn-soft{
      background: #f3f4f6;
      border: 1px solid #e5e7eb;
      color: #111827;
    }
    .btn-soft:hover{
      background: #e9edf2;
    }

    .actions-bar{
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      justify-content: flex-end;
      padding: 12px 16px;
      border-top: 1px solid #eef2f7;
      background: #fff;
    }
  </style>
</head>

<body>
  <div class="app">

    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="brand">
        <div class="brand-badge">
          <!-- Replace with your logo -->
          <img src="https://via.placeholder.com/120x120.png?text=LOGO" alt="Barangay Logo">
        </div>
        <div>
          <h6>Barangay IMS</h6>
          <small>Management System</small>
        </div>
      </div>

      <div class="nav-section">System Navigation</div>
      <nav class="nav flex-column side-nav">
        <a class="nav-link" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a class="nav-link" href="#"><i class="bi bi-people"></i> Residents</a>
        <a class="nav-link" href="#"><i class="bi bi-file-earmark-text"></i> Certificates</a>
        <a class="nav-link" href="#"><i class="bi bi-exclamation-triangle"></i> Blotter</a>
        <a class="nav-link" href="#"><i class="bi bi-house-door"></i> Households</a>
        <a class="nav-link" href="#"><i class="bi bi-person-badge"></i> Officials</a>
        <a class="nav-link active" href="#"><i class="bi bi-archive"></i> Archives</a>
        <a class="nav-link" href="#"><i class="bi bi-gear"></i> Settings</a>
        <a class="nav-link" href="#"><i class="bi bi-box-arrow-right"></i> Logout</a>
      </nav>

      <div class="sidebar-footer">
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-shield-check"></i>
          <div>
            <div class="fw-semibold">Admin</div>
            <div class="opacity-75" style="font-size:.85rem;">admin@barangay.local</div>
          </div>
        </div>
      </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main">

      <!-- TOP BAR -->
      <div class="topbar">
        <div>
          <p class="subtitle">Barangay Information Management System</p>
          <h4 class="title">ARCHIVES</h4>
        </div>

        <div class="d-flex gap-2 align-items-center">
          <div class="pill">
            <i class="bi bi-calendar3"></i>
            <span id="todayText">Today</span>
          </div>
          <button class="btn btn-soft rounded-pill">
            <i class="bi bi-bell"></i>
          </button>
          <button class="btn btn-primary rounded-pill">
            <i class="bi bi-plus-lg me-1"></i> New
          </button>
        </div>
      </div>

      <!-- PANEL -->
      <section class="panel">
        <div class="panel-header">
          <h5><i class="bi bi-archive"></i> Archived Records</h5>
          <div class="d-flex gap-2">
            <button class="btn btn-soft btn-sm"><i class="bi bi-arrow-clockwise me-1"></i> Refresh</button>
            <button class="btn btn-soft btn-sm"><i class="bi bi-download me-1"></i> Export</button>
          </div>
        </div>

        <div class="panel-body">

          <!-- FILTERS / SEARCH -->
          <div class="filters mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-search"></i></span>
              <input type="text" class="form-control" placeholder="Search name, ID, address...">
            </div>

            <select class="form-select">
              <option selected>Record Type (All)</option>
              <option>Residents</option>
              <option>Certificates</option>
              <option>Blotter</option>
              <option>Households</option>
            </select>

            <select class="form-select">
              <option selected>Status (All)</option>
              <option>Archived</option>
              <option>Deleted</option>
              <option>Restored</option>
            </select>

            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
              <input type="date" class="form-control">
            </div>
          </div>

          <!-- TABLE -->
          <div class="table-responsive">
            <table class="table align-middle">
              <thead>
                <tr>
                  <th style="width: 54px;">#</th>
                  <th>Name</th>
                  <th>Type</th>
                  <th>Address</th>
                  <th>Archived At</th>
                  <th class="text-end" style="width: 170px;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>01</td>
                  <td class="fw-semibold">Juan Dela Cruz</td>
                  <td><span class="badge text-bg-primary">Resident</span></td>
                  <td>123 A. Street</td>
                  <td>2026-03-04</td>
                  <td class="text-end">
                    <button class="btn btn-sm btn-soft"><i class="bi bi-eye"></i></button>
                    <button class="btn btn-sm btn-success"><i class="bi bi-arrow-counterclockwise"></i></button>
                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash3"></i></button>
                  </td>
                </tr>
                <tr>
                  <td>02</td>
                  <td class="fw-semibold">Maria Clara</td>
                  <td><span class="badge text-bg-warning">Certificate</span></td>
                  <td>Purok 2</td>
                  <td>2026-02-20</td>
                  <td class="text-end">
                    <button class="btn btn-sm btn-soft"><i class="bi bi-eye"></i></button>
                    <button class="btn btn-sm btn-success"><i class="bi bi-arrow-counterclockwise"></i></button>
                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash3"></i></button>
                  </td>
                </tr>
                <tr>
                  <td>03</td>
                  <td class="fw-semibold">Pedro Penduko</td>
                  <td><span class="badge text-bg-danger">Blotter</span></td>
                  <td>Zone 5</td>
                  <td>2026-01-10</td>
                  <td class="text-end">
                    <button class="btn btn-sm btn-soft"><i class="bi bi-eye"></i></button>
                    <button class="btn btn-sm btn-success"><i class="bi bi-arrow-counterclockwise"></i></button>
                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash3"></i></button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- PAGINATION (optional) -->
          <div class="d-flex justify-content-between align-items-center mt-2">
            <small class="text-muted">Showing 1 to 3 of 3 entries</small>
            <nav>
              <ul class="pagination pagination-sm mb-0">
                <li class="page-item disabled"><a class="page-link" href="#">Prev</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
              </ul>
            </nav>
          </div>
        </div>

        <!-- BOTTOM ACTION BUTTONS (like your screenshot) -->
        <div class="actions-bar">
          <button class="btn btn-primary"><i class="bi bi-printer me-1"></i> Print</button>
          <button class="btn btn-soft"><i class="bi bi-filetype-pdf me-1"></i> PDF</button>
          <button class="btn btn-soft"><i class="bi bi-file-earmark-spreadsheet me-1"></i> Excel</button>
          <button class="btn btn-danger"><i class="bi bi-trash3 me-1"></i> Empty Archive</button>
        </div>
      </section>

    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // simple date pill
    const d = new Date();
    document.getElementById("todayText").textContent =
      d.toLocaleDateString(undefined, { weekday: "short", year: "numeric", month: "short", day: "numeric" });
  </script>
</body>
</html>