<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CDMS | Premium Donation Operations</title>
  <meta name="description" content="CDMS is a premium platform to manage clothing donations, volunteers, inventory, and requests with precision.">
  <link rel="icon" type="image/svg+xml" href="{{ asset('assets/cdms-logo.svg') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root{
      --bg:#eaf5ff;
      --bg-soft:#f6fbff;
      --text:#0f2746;
      --muted:#56708f;
      --card:#ffffff;
      --line:#c7ddf5;
      --primary:#2786e6;
      --primary-dark:#1f6fbe;
      --primary-soft:#d5eaff;
    }
    body{
      min-height:100vh;
      color:var(--text);
      background:
        radial-gradient(1100px 680px at 12% 5%, rgba(87,163,235,.20), transparent 55%),
        radial-gradient(1000px 700px at 88% 12%, rgba(170,212,248,.28), transparent 52%),
        linear-gradient(180deg, var(--bg) 0%, var(--bg-soft) 100%);
    }
    .nav-shell{
      background:rgba(255,255,255,.9);
      border-bottom:1px solid var(--line);
      backdrop-filter:blur(8px);
    }
    .brand{
      display:inline-flex;
      align-items:center;
      gap:.6rem;
      text-decoration:none;
      color:var(--text);
      font-weight:700;
      letter-spacing:.04em;
    }
    .brand img{ width:34px; height:34px; }
    .top-actions{
      position:absolute;
      right:0;
      top:50%;
      transform:translateY(-50%);
    }
    .hero{
      border:1px solid var(--line);
      background:linear-gradient(145deg, #ffffff, #f4faff);
      border-radius:26px;
      box-shadow:0 18px 44px rgba(37, 91, 149, .16);
    }
    .glass{
      border:1px solid var(--line);
      background:var(--card);
      border-radius:18px;
    }
    .muted{ color:var(--muted); }
    .pill{
      border:1px solid #b7d7f7;
      background:var(--primary-soft);
      color:#165a96;
      border-radius:999px;
      padding:.35rem .75rem;
      font-size:.78rem;
      letter-spacing:.06em;
      text-transform:uppercase;
    }
    .kpi{
      border:1px solid #d0e5fa;
      border-radius:14px;
      background:#f8fbff;
      padding:.95rem 1rem;
    }
    .kpi b{ font-size:1.2rem; }
    .feature-icon{
      width:32px;
      height:32px;
      border-radius:10px;
      display:inline-flex;
      align-items:center;
      justify-content:center;
      font-weight:700;
      color:#0a1220;
      background:linear-gradient(135deg,var(--primary),#74b8f4);
    }
    .btn-luxe{
      background:linear-gradient(135deg,var(--primary),#52a9f5);
      color:#fff;
      border:0;
      font-weight:600;
      box-shadow:0 10px 22px rgba(39,134,230,.25);
    }
    .btn-luxe:hover{ color:#fff; background:linear-gradient(135deg,var(--primary-dark),#469de9); }
    .btn-outline-light{
      color:#1d5f99;
      border-color:#9dc7ef;
      background:#f4faff;
      font-weight:600;
    }
    .btn-outline-light:hover{
      color:#0f4d86;
      border-color:#85b8e8;
      background:#e7f3ff;
    }
    .footer{
      border-top:1px solid var(--line);
      color:var(--muted);
    }
    a{ color:#1e73bf; }
    a:hover{ color:#14568f; }
  </style>
</head>
<body>

  <nav class="navbar nav-shell sticky-top">
    <div class="container py-2 position-relative justify-content-center">
      <a class="brand mx-auto" href="/">
        <img src="{{ asset('assets/cdms-logo.svg') }}" alt="CDMS Logo">
        <span>CDMS</span>
      </a>
      <div class="d-none d-md-flex gap-2 top-actions">
        <a href="/login?role=admin" class="btn btn-outline-light btn-sm">Admin</a>
        <a href="/register?role=donor" class="btn btn-luxe btn-sm">Get Started</a>
      </div>
    </div>
  </nav>

  <main class="container py-5">
    <section class="hero p-4 p-lg-5 mb-4">
      <div class="row g-4 align-items-center">
        <div class="col-12 col-lg-7">
          <h1 class="fw-bold mt-3 mb-3" style="letter-spacing:-.02em;">Professional donation management with a refined experience</h1>
          <p class="muted mb-4">
            Coordinate donors, volunteers, inventory, and customer requests in one elegant and reliable system.
          </p>
          <div class="d-flex flex-wrap gap-2">
            <a href="/register?role=donor" class="btn btn-luxe px-4">Join as Donor</a>
            <a href="/register?role=volunteer" class="btn btn-outline-light px-4">Join as Volunteer</a>
            <a href="/register?role=customer" class="btn btn-outline-light px-4">Join as Customer</a>
          </div>
          <div class="mt-3 muted">
            <a class="text-decoration-none" href="/login?role=donor">Donor Login</a> |
            <a class="text-decoration-none" href="/login?role=volunteer">Volunteer Login</a> |
            <a class="text-decoration-none" href="/login?role=customer">Customer Login</a>
          </div>
        </div>

        <div class="col-12 col-lg-5">
          <div class="glass p-3 p-md-4">
            <h6 class="fw-semibold mb-3">Live Overview</h6>
            <div class="row g-2">
              <div class="col-6"><div class="kpi"><div class="muted small">Donors</div><b>{{ number_format($publicStats['donors'] ?? 0) }}</b></div></div>
              <div class="col-6"><div class="kpi"><div class="muted small">Volunteers</div><b>{{ number_format($publicStats['volunteers'] ?? 0) }}</b></div></div>
              <div class="col-6"><div class="kpi"><div class="muted small">Donations</div><b>{{ number_format($publicStats['donations'] ?? 0) }}</b></div></div>
              <div class="col-6"><div class="kpi"><div class="muted small">Stock Units</div><b>{{ number_format($publicStats['inventory_stock'] ?? 0) }}</b></div></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="row g-3">
      <div class="col-12 col-md-6 col-xl-3">
        <div class="glass p-4 h-100">
          <div class="feature-icon mb-2">D</div>
          <h6 class="fw-semibold">Donor Management</h6>
          <p class="muted mb-0">Smooth donation submission and end-to-end status tracking.</p>
        </div>
      </div>
      <div class="col-12 col-md-6 col-xl-3">
        <div class="glass p-4 h-100">
          <div class="feature-icon mb-2">V</div>
          <h6 class="fw-semibold">Volunteer Tasks</h6>
          <p class="muted mb-0">Structured pickup and delivery assignment workflow.</p>
        </div>
      </div>
      <div class="col-12 col-md-6 col-xl-3">
        <div class="glass p-4 h-100">
          <div class="feature-icon mb-2">I</div>
          <h6 class="fw-semibold">Inventory Control</h6>
          <p class="muted mb-0">Real-time quantity visibility by category and size.</p>
        </div>
      </div>
      <div class="col-12 col-md-6 col-xl-3">
        <div class="glass p-4 h-100">
          <div class="feature-icon mb-2">A</div>
          <h6 class="fw-semibold">Admin Oversight</h6>
          <p class="muted mb-0">Unified decision-making across donations and requests.</p>
        </div>
      </div>
    </section>
  </main>

  <footer class="footer py-4 mt-3">
    <div class="container d-flex flex-wrap justify-content-between gap-2">
      <span>&copy; {{ date('Y') }} CDMS</span>
      <span>Premium Clothing Donation Management</span>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
