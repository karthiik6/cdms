<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CDMS | Smart Clothing Donation Management</title>
  <meta name="description" content="CDMS helps manage clothing donations, volunteers, inventory, and support requests from one simple platform.">
  <link rel="icon" type="image/svg+xml" href="{{ asset('assets/cdms-logo.svg') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root{
      --bg:#f6f8f3;
      --white:#ffffff;
      --text:#1f2b20;
      --muted:#657267;
      --line:#d8e0d3;
      --primary:#2f6b3b;
      --primary-dark:#25552f;
      --soft:#eef4e9;
    }
    html{
      scroll-behavior:smooth;
    }
    body{
      min-height:100vh;
      font-family:"Manrope", sans-serif;
      color:var(--text);
      background:var(--bg);
    }
    section{
      scroll-margin-top:88px;
    }
    .nav-shell{
      background:rgba(255,255,255,.94);
      border-bottom:1px solid var(--line);
    }
    .brand{
      display:inline-flex;
      align-items:center;
      gap:.65rem;
      color:var(--text);
      text-decoration:none;
      font-weight:800;
      letter-spacing:.05em;
    }
    .brand img{
      width:38px;
      height:38px;
    }
    .nav-link{
      color:var(--muted);
      font-weight:600;
    }
    .nav-link:hover,
    .nav-link:focus{
      color:var(--primary);
    }
    .btn-brand{
      background:var(--primary);
      border-color:var(--primary);
      color:#fff;
      font-weight:700;
    }
    .btn-brand:hover,
    .btn-brand:focus{
      background:var(--primary-dark);
      border-color:var(--primary-dark);
      color:#fff;
    }
    .btn-soft{
      background:var(--white);
      border:1px solid var(--line);
      color:var(--primary);
      font-weight:700;
    }
    .btn-soft:hover,
    .btn-soft:focus{
      background:var(--soft);
      color:var(--primary-dark);
    }
    .hero,
    .card-simple{
      background:var(--white);
      border:1px solid var(--line);
      border-radius:20px;
    }
    .hero{
      padding:2rem;
    }
    .muted{
      color:var(--muted);
    }
    .section-title{
      font-size:clamp(1.8rem, 3vw, 2.8rem);
      letter-spacing:-.03em;
    }
    .mini-label{
      color:var(--primary);
      font-size:.82rem;
      font-weight:800;
      letter-spacing:.08em;
      text-transform:uppercase;
    }
    .stats-grid{
      display:grid;
      grid-template-columns:repeat(2, minmax(0, 1fr));
      gap:1rem;
    }
    .stat-box{
      padding:1rem;
      border:1px solid var(--line);
      border-radius:16px;
      background:var(--soft);
    }
    .stat-box strong{
      display:block;
      font-size:1.5rem;
      line-height:1.1;
    }
    .info-card{
      height:100%;
      padding:1.5rem;
    }
    .footer{
      border-top:1px solid var(--line);
      color:var(--muted);
    }
    .contact-link{
      color:var(--primary);
      text-decoration:none;
    }
    .contact-link:hover{
      color:var(--primary-dark);
    }
    @media (max-width: 991.98px){
      .hero{
        padding:1.5rem;
      }
    }
    @media (max-width: 575.98px){
      .stats-grid{
        grid-template-columns:1fr;
      }
      .hero-actions .btn{
        width:100%;
      }
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg nav-shell sticky-top">
    <div class="container py-2">
      <a class="brand" href="#home">
        <img src="{{ asset('assets/cdms-logo.svg') }}" alt="CDMS Logo">
        <span>CDMS</span>
      </a>

      <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#landingNav" aria-controls="landingNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="landingNav">
        <ul class="navbar-nav mx-auto mb-3 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
          <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
          <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
        </ul>

        <div class="d-flex flex-column flex-lg-row gap-2">
          <a href="/login?role=admin" class="btn btn-soft">Admin Login</a>
          <a href="/register?role=donor" class="btn btn-brand">Get Started</a>
        </div>
      </div>
    </div>
  </nav>

  <main class="container py-4 py-lg-5">
    <section id="home" class="hero mb-5">
      <div class="row g-4 align-items-center">
        <div class="col-12 col-lg-7">
          <div class="mini-label mb-2">Home</div>
          <p class="muted mb-4">
            Welcome to CDMS. Manage donations, volunteer support, and clothing distribution from one place.
          </p>

          <div class="hero-actions d-flex flex-column flex-sm-row gap-3 mb-3">
            <a href="/register?role=donor" class="btn btn-brand px-4 py-3">Join as Donor</a>
            <a href="/register?role=volunteer" class="btn btn-soft px-4 py-3">Join as Volunteer</a>
            <a href="/register?role=customer" class="btn btn-soft px-4 py-3">Request Support</a>
          </div>

          <div class="d-flex flex-wrap gap-3 small">
            <a href="/login?role=donor" class="contact-link">Donor Login</a>
            <a href="/login?role=volunteer" class="contact-link">Volunteer Login</a>
            <a href="/login?role=customer" class="contact-link">Customer Login</a>
          </div>
        </div>

        <div class="col-12 col-lg-5">
          <div class="card-simple p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <div>
                <h5 class="fw-bold mb-1">Live Update</h5>
                <p class="muted mb-0">Current system totals</p>
              </div>
              <span class="mini-label">Active</span>
            </div>

            <div class="stats-grid">
              <div class="stat-box">
                <span class="muted small">Donors</span>
                <strong>{{ number_format($publicStats['donors'] ?? 0) }}</strong>
              </div>
              <div class="stat-box">
                <span class="muted small">Volunteers</span>
                <strong>{{ number_format($publicStats['volunteers'] ?? 0) }}</strong>
              </div>
              <div class="stat-box">
                <span class="muted small">Donations</span>
                <strong>{{ number_format($publicStats['donations'] ?? 0) }}</strong>
              </div>
              <div class="stat-box">
                <span class="muted small">Stock Units</span>
                <strong>{{ number_format($publicStats['inventory_stock'] ?? 0) }}</strong>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="services" class="mb-5">
      <div class="row mb-4">
        <div class="col-12 col-lg-8">
          <div class="mini-label mb-2">Services</div>
          <h2 class="section-title fw-bold mb-2">Core features presented more clearly.</h2>
          <p class="muted mb-0">The page stays professional, but with a simpler structure that is easier to scan.</p>
        </div>
      </div>

      <div class="row g-4">
        <div class="col-12 col-md-6 col-xl-3">
          <div class="card-simple info-card">
            <h5 class="fw-bold mb-2">Donation Flow</h5>
            <p class="muted mb-0">Donors can register, submit donations, and follow the process with less confusion.</p>
          </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
          <div class="card-simple info-card">
            <h5 class="fw-bold mb-2">Volunteer Tasks</h5>
            <p class="muted mb-0">Volunteers can manage pickups and assigned work through the existing system.</p>
          </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
          <div class="card-simple info-card">
            <h5 class="fw-bold mb-2">Inventory Tracking</h5>
            <p class="muted mb-0">Stock information remains visible and supports better planning for distribution.</p>
          </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
          <div class="card-simple info-card">
            <h5 class="fw-bold mb-2">Admin Control</h5>
            <p class="muted mb-0">Admins can review donations, requests, and operations from one platform.</p>
          </div>
        </div>
      </div>
    </section>

    <section id="about" class="mb-5">
      <div class="card-simple p-4 p-lg-5">
        <div class="mini-label mb-2">About</div>
        <h2 class="section-title fw-bold mb-3">CDMS supports organized and transparent community service.</h2>
        <p class="muted mb-0">
          This landing page explains your platform in a simpler way while keeping the current routes, live data, and role-based access exactly as they already work in your application.
        </p>
      </div>
    </section>

    <section id="contact" class="mb-4">
      <div class="row mb-4">
        <div class="col-12 col-lg-8">
          <div class="mini-label mb-2">Contact</div>
          <h2 class="section-title fw-bold mb-2">Make it easy for visitors to reach your team.</h2>
          <p class="muted mb-0">You can replace the sample contact details below with your real information later.</p>
        </div>
      </div>

      <div class="row g-4">
        <div class="col-12 col-md-4">
          <div class="card-simple info-card">
            <h5 class="fw-bold mb-2">Office</h5>
            <p class="muted mb-0">CDMS Operations Center<br>Community Donation Services<br>Clothing Distribution Hub</p>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="card-simple info-card">
            <h5 class="fw-bold mb-2">Reach Us</h5>
            <p class="mb-2"><a href="mailto:support@cdms.local" class="contact-link">support@cdms.local</a></p>
            <p class="mb-0"><a href="tel:+910000000000" class="contact-link">+91 00000 00000</a></p>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="card-simple info-card">
            <h5 class="fw-bold mb-2">Quick Access</h5>
            <p class="mb-2"><a href="/login?role=admin" class="contact-link">Admin Portal</a></p>
            <p class="mb-2"><a href="/register?role=donor" class="contact-link">Become a Donor</a></p>
            <p class="mb-0"><a href="/register?role=volunteer" class="contact-link">Volunteer Registration</a></p>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer class="footer py-4">
    <div class="container d-flex flex-column flex-md-row justify-content-between gap-2">
      <span>&copy; {{ date('Y') }} CDMS</span>
      <span>Clothing Donation Management Platform</span>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
