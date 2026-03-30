<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CDMS | Smart Clothing Donation Management</title>
  <meta name="description" content="CDMS helps teams manage clothing donations, volunteer coordination, inventory tracking, and community support through one professional platform.">
  <link rel="icon" type="image/svg+xml" href="{{ asset('assets/cdms-logo.svg') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root{
      --bg:#f3f6ef;
      --surface:#fffdf8;
      --surface-soft:#f8fbf4;
      --text:#1d2a1f;
      --muted:#617063;
      --line:#d6e0d1;
      --primary:#2f6b3b;
      --primary-dark:#234f2c;
      --accent:#d7e9cb;
      --accent-strong:#9cc487;
      --shadow:0 24px 60px rgba(27, 44, 24, .10);
    }
    html{
      scroll-behavior:smooth;
    }
    body{
      min-height:100vh;
      font-family:"Manrope", sans-serif;
      color:var(--text);
      background:
        radial-gradient(900px 500px at 10% 0%, rgba(191, 219, 174, .35), transparent 55%),
        radial-gradient(700px 420px at 92% 12%, rgba(223, 206, 175, .35), transparent 52%),
        linear-gradient(180deg, #eef4e8 0%, var(--bg) 45%, #f8faf5 100%);
    }
    section{
      scroll-margin-top:92px;
    }
    .nav-shell{
      background:rgba(248, 251, 244, .86);
      border-bottom:1px solid rgba(214, 224, 209, .8);
      backdrop-filter:blur(12px);
    }
    .brand{
      display:inline-flex;
      align-items:center;
      gap:.7rem;
      text-decoration:none;
      color:var(--text);
      font-weight:800;
      letter-spacing:.06em;
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
      border:0;
      color:#fff;
      background:linear-gradient(135deg, var(--primary), #4e8d55);
      box-shadow:0 14px 30px rgba(47, 107, 59, .22);
      font-weight:700;
    }
    .btn-brand:hover,
    .btn-brand:focus{
      color:#fff;
      background:linear-gradient(135deg, var(--primary-dark), #417848);
    }
    .btn-soft{
      border:1px solid var(--line);
      background:rgba(255,255,255,.8);
      color:var(--primary);
      font-weight:700;
    }
    .btn-soft:hover,
    .btn-soft:focus{
      border-color:var(--accent-strong);
      background:#f7fbf2;
      color:var(--primary-dark);
    }
    .eyebrow{
      display:inline-flex;
      align-items:center;
      gap:.45rem;
      padding:.45rem .8rem;
      border:1px solid #cadbc1;
      border-radius:999px;
      background:rgba(255,255,255,.72);
      color:var(--primary-dark);
      font-size:.8rem;
      font-weight:800;
      letter-spacing:.08em;
      text-transform:uppercase;
    }
    .hero-panel{
      position:relative;
      overflow:hidden;
      background:linear-gradient(145deg, rgba(255,255,253,.95), rgba(243, 248, 238, .98));
      border:1px solid rgba(214, 224, 209, .9);
      border-radius:32px;
      box-shadow:var(--shadow);
    }
    .hero-panel::after{
      content:"";
      position:absolute;
      inset:auto -80px -100px auto;
      width:260px;
      height:260px;
      border-radius:50%;
      background:radial-gradient(circle, rgba(156,196,135,.34), transparent 65%);
      pointer-events:none;
    }
    .hero-copy h1{
      font-size:clamp(2.4rem, 4vw, 4.5rem);
      line-height:1.02;
      letter-spacing:-.04em;
    }
    .hero-copy p{
      font-size:1.06rem;
      color:var(--muted);
    }
    .stats-card,
    .feature-card,
    .service-card,
    .contact-card,
    .about-panel{
      height:100%;
      background:rgba(255,255,255,.84);
      border:1px solid var(--line);
      border-radius:24px;
      box-shadow:0 18px 45px rgba(42, 58, 38, .07);
    }
    .stats-card{
      background:linear-gradient(180deg, rgba(249,252,246,.98), rgba(239,246,233,.98));
    }
    .stat-box{
      background:rgba(255,255,255,.78);
      border:1px solid #d6e5ce;
      border-radius:18px;
      padding:1rem;
    }
    .stat-box .value{
      font-size:1.55rem;
      font-weight:800;
      line-height:1;
    }
    .muted{
      color:var(--muted);
    }
    .section-title{
      font-size:clamp(1.9rem, 3vw, 3rem);
      letter-spacing:-.03em;
    }
    .feature-badge,
    .service-icon{
      width:52px;
      height:52px;
      display:inline-flex;
      align-items:center;
      justify-content:center;
      border-radius:16px;
      background:linear-gradient(135deg, #dceccf, #f2e8cb);
      color:var(--primary-dark);
      font-weight:800;
      box-shadow:inset 0 1px 0 rgba(255,255,255,.65);
    }
    .feature-card:hover,
    .service-card:hover,
    .contact-card:hover{
      transform:translateY(-4px);
      transition:transform .25s ease, box-shadow .25s ease;
      box-shadow:0 24px 55px rgba(42, 58, 38, .11);
    }
    .about-panel{
      overflow:hidden;
      background:
        linear-gradient(135deg, rgba(255,255,255,.92), rgba(244,248,239,.95)),
        linear-gradient(120deg, rgba(215,233,203,.3), transparent 45%);
    }
    .metric-strip{
      display:grid;
      grid-template-columns:repeat(3, minmax(0, 1fr));
      gap:1rem;
    }
    .metric-chip{
      padding:1rem;
      border:1px solid #d7e2d1;
      border-radius:20px;
      background:rgba(255,255,255,.78);
    }
    .metric-chip strong{
      display:block;
      font-size:1.3rem;
    }
    .contact-card a{
      color:var(--primary);
      text-decoration:none;
    }
    .contact-card a:hover{
      color:var(--primary-dark);
    }
    .footer{
      border-top:1px solid rgba(214, 224, 209, .9);
      color:var(--muted);
    }
    @media (max-width: 991.98px){
      .metric-strip{
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
        <ul class="navbar-nav mx-auto mb-3 mb-lg-0 gap-lg-2">
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
    <section id="home" class="hero-panel p-4 p-lg-5 mb-5">
      <div class="row g-4 align-items-center">
        <div class="col-12 col-lg-7 hero-copy">
          <span class="eyebrow">Community Donation Platform</span>
          <h1 class="fw-bold mt-3 mb-3">A professional digital front door for clothing donation operations.</h1>
          <p class="mb-4">
            CDMS brings donors, volunteers, administrators, and beneficiaries into one clear workflow so every donation is handled with speed, transparency, and care.
          </p>

          <div class="hero-actions d-flex flex-column flex-sm-row gap-3 mb-3">
            <a href="/register?role=donor" class="btn btn-brand px-4 py-3">Join as Donor</a>
            <a href="/register?role=volunteer" class="btn btn-soft px-4 py-3">Join as Volunteer</a>
            <a href="/register?role=customer" class="btn btn-soft px-4 py-3">Request Support</a>
          </div>

          <div class="d-flex flex-wrap gap-3 muted small">
            <a href="/login?role=donor" class="text-decoration-none">Donor Login</a>
            <a href="/login?role=volunteer" class="text-decoration-none">Volunteer Login</a>
            <a href="/login?role=customer" class="text-decoration-none">Customer Login</a>
          </div>
        </div>

        <div class="col-12 col-lg-5">
          <div class="stats-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <div>
                <h5 class="mb-1 fw-bold">Live Platform Snapshot</h5>
                <p class="muted mb-0">Public numbers from your current system</p>
              </div>
              <span class="eyebrow">Realtime</span>
            </div>

            <div class="row g-3">
              <div class="col-6">
                <div class="stat-box">
                  <div class="muted small mb-2">Donors</div>
                  <div class="value">{{ number_format($publicStats['donors'] ?? 0) }}</div>
                </div>
              </div>
              <div class="col-6">
                <div class="stat-box">
                  <div class="muted small mb-2">Volunteers</div>
                  <div class="value">{{ number_format($publicStats['volunteers'] ?? 0) }}</div>
                </div>
              </div>
              <div class="col-6">
                <div class="stat-box">
                  <div class="muted small mb-2">Donations</div>
                  <div class="value">{{ number_format($publicStats['donations'] ?? 0) }}</div>
                </div>
              </div>
              <div class="col-6">
                <div class="stat-box">
                  <div class="muted small mb-2">Stock Units</div>
                  <div class="value">{{ number_format($publicStats['inventory_stock'] ?? 0) }}</div>
                </div>
              </div>
            </div>

            <div class="mt-4 pt-2">
              <p class="muted mb-0">Designed to present your mission clearly while still connecting visitors directly to the existing donor, volunteer, customer, and admin flows.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="mb-5">
      <div class="row g-4">
        <div class="col-12 col-md-6 col-xl-3">
          <div class="feature-card p-4">
            <div class="feature-badge mb-3">01</div>
            <h5 class="fw-bold">Trusted Intake</h5>
            <p class="muted mb-0">Collect donations and support requests through clean role-based entry points that keep the experience straightforward.</p>
          </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
          <div class="feature-card p-4">
            <div class="feature-badge mb-3">02</div>
            <h5 class="fw-bold">Volunteer Coordination</h5>
            <p class="muted mb-0">Organize pickups, delivery tasks, and assignment visibility so teams always know what needs attention next.</p>
          </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
          <div class="feature-card p-4">
            <div class="feature-badge mb-3">03</div>
            <h5 class="fw-bold">Inventory Accuracy</h5>
            <p class="muted mb-0">Track available clothing stock with a structure that supports better distribution decisions and reduced waste.</p>
          </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
          <div class="feature-card p-4">
            <div class="feature-badge mb-3">04</div>
            <h5 class="fw-bold">Admin Oversight</h5>
            <p class="muted mb-0">Review requests, monitor donations, and manage operations from one system built around accountability.</p>
          </div>
        </div>
      </div>
    </section>

    <section id="services" class="py-3 py-lg-4 mb-5">
      <div class="row align-items-end mb-4">
        <div class="col-12 col-lg-7">
          <span class="eyebrow">Services</span>
          <h2 class="section-title fw-bold mt-3 mb-2">Everything your donation workflow needs in one place.</h2>
          <p class="muted mb-0">The landing page now presents your platform like a professional organization, while still leading people into the existing system without breaking routes or logic.</p>
        </div>
      </div>

      <div class="row g-4">
        <div class="col-12 col-md-6">
          <div class="service-card p-4 p-lg-5">
            <div class="service-icon mb-3">H</div>
            <h4 class="fw-bold">Home Experience</h4>
            <p class="muted mb-0">A polished first impression with clear messaging, trust-building stats, strong calls to action, and mobile-friendly navigation.</p>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="service-card p-4 p-lg-5">
            <div class="service-icon mb-3">S</div>
            <h4 class="fw-bold">Service Visibility</h4>
            <p class="muted mb-0">Highlights for donor management, volunteer operations, inventory tracking, and administrative review in a format that feels business-ready.</p>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="service-card p-4 p-lg-5">
            <div class="service-icon mb-3">A</div>
            <h4 class="fw-bold">About Presentation</h4>
            <p class="muted mb-0">A stronger brand story that explains the purpose of CDMS and helps visitors understand the value behind the platform.</p>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="service-card p-4 p-lg-5">
            <div class="service-icon mb-3">C</div>
            <h4 class="fw-bold">Contact Access</h4>
            <p class="muted mb-0">Dedicated contact details and clear next steps so organizations, volunteers, and donors know how to connect quickly.</p>
          </div>
        </div>
      </div>
    </section>

    <section id="about" class="mb-5">
      <div class="about-panel p-4 p-lg-5">
        <div class="row g-4 align-items-center">
          <div class="col-12 col-lg-7">
            <span class="eyebrow">About</span>
            <h2 class="section-title fw-bold mt-3 mb-3">CDMS is built to make community support feel organized, credible, and scalable.</h2>
            <p class="muted">
              Whether your team is handling incoming donations, validating requests, assigning volunteers, or monitoring inventory, CDMS supports a complete process that is easier to manage and easier to trust.
            </p>
            <p class="muted mb-0">
              This updated landing page focuses on professionalism and clarity, while preserving the existing authentication paths and public statistics already connected to your application.
            </p>
          </div>
          <div class="col-12 col-lg-5">
            <div class="metric-strip">
              <div class="metric-chip">
                <strong>Role-Based</strong>
                <span class="muted">Clear entry points for admins, donors, volunteers, and customers.</span>
              </div>
              <div class="metric-chip">
                <strong>Transparent</strong>
                <span class="muted">Public stats help communicate activity and operational readiness.</span>
              </div>
              <div class="metric-chip">
                <strong>Responsive</strong>
                <span class="muted">Built to feel polished across desktop, tablet, and mobile layouts.</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="contact" class="pb-4">
      <div class="row align-items-end mb-4">
        <div class="col-12 col-lg-7">
          <span class="eyebrow">Contact</span>
          <h2 class="section-title fw-bold mt-3 mb-2">Connect with your team and community from one professional homepage.</h2>
          <p class="muted mb-0">You can replace these sample contact details any time with your organization's real information.</p>
        </div>
      </div>

      <div class="row g-4">
        <div class="col-12 col-md-4">
          <div class="contact-card p-4">
            <h5 class="fw-bold mb-3">Office</h5>
            <p class="muted mb-0">CDMS Operations Center<br>Community Donation Services<br>Clothing Distribution Hub</p>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="contact-card p-4">
            <h5 class="fw-bold mb-3">Reach Us</h5>
            <p class="mb-2"><a href="mailto:support@cdms.local">support@cdms.local</a></p>
            <p class="mb-0"><a href="tel:+910000000000">+91 00000 00000</a></p>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="contact-card p-4">
            <h5 class="fw-bold mb-3">Quick Access</h5>
            <p class="mb-2"><a href="/login?role=admin">Admin Portal</a></p>
            <p class="mb-2"><a href="/register?role=donor">Become a Donor</a></p>
            <p class="mb-0"><a href="/register?role=volunteer">Volunteer Registration</a></p>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer class="footer py-4">
    <div class="container d-flex flex-column flex-md-row justify-content-between gap-2">
      <span>&copy; {{ date('Y') }} CDMS</span>
      <span>Professional Clothing Donation Management Platform</span>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
