<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $pageTitle ?? 'CDMS | Smart Clothing Donation Management' }}</title>
  <meta name="description" content="{{ $pageDescription ?? 'CDMS helps manage clothing donations, volunteers, inventory, and support requests from one simple platform.' }}">
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
    body{
      min-height:100vh;
      font-family:"Manrope", sans-serif;
      color:var(--text);
      background:var(--bg);
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
    .nav-link:focus,
    .nav-link.active{
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
      <a class="brand" href="/">
        <img src="{{ asset('assets/cdms-logo.svg') }}" alt="CDMS Logo">
        <span>CDMS</span>
      </a>

      <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#landingNav" aria-controls="landingNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="landingNav">
        <ul class="navbar-nav mx-auto mb-3 mb-lg-0">
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('marketing.home') ? 'active' : '' }}" href="/">Home</a></li>
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('marketing.services') ? 'active' : '' }}" href="/services">Services</a></li>
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('marketing.about') ? 'active' : '' }}" href="/about">About</a></li>
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('marketing.contact') ? 'active' : '' }}" href="/contact">Contact</a></li>
        </ul>

        <div class="d-flex flex-column flex-lg-row gap-2">
          <a href="/login?role=admin" class="btn btn-soft">Admin Login</a>
          <a href="/register?role=donor" class="btn btn-brand">Get Started</a>
        </div>
      </div>
    </div>
  </nav>

  <main class="container py-4 py-lg-5">
    @yield('content')
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
