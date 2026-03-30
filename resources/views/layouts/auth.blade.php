<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'CDMS')</title>
  <meta name="description" content="Secure CDMS authentication for donors, volunteers, customers, and admins.">
  <link rel="icon" type="image/svg+xml" href="{{ asset('assets/cdms-logo.svg') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root{
      --bg:#eaf5ff;
      --bg-soft:#f6fbff;
      --text:#112b4b;
      --muted:#5f7c9d;
      --card:#ffffff;
      --border:#c7ddf5;
      --primary:#2786e6;
      --primary-dark:#1f6fbe;
    }
    body{
      min-height:100vh;
      background:
        radial-gradient(1000px 640px at 14% 6%, rgba(107,178,245,.24), transparent 55%),
        radial-gradient(960px 680px at 86% 14%, rgba(171,212,247,.30), transparent 52%),
        linear-gradient(180deg, var(--bg) 0%, var(--bg-soft) 100%);
      color:var(--text);
    }
    .auth-card{
      background: var(--card);
      border: 1px solid var(--border);
      backdrop-filter: blur(6px);
      border-radius: 20px;
      box-shadow: 0 16px 38px rgba(37, 91, 149, .16);
    }
    .muted{ color:var(--muted) !important; }
    .form-control, .form-select{
      background: #f9fcff;
      border: 1px solid #b8d6f1;
      color: var(--text);
    }
    .form-control:focus, .form-select:focus{
      background: #fff;
      border-color: #82b8ea;
      box-shadow: 0 0 0 .22rem rgba(39,134,230,.16);
      color: var(--text);
    }
    .form-control::placeholder{ color: #88a4c2; }
    .brand-wrap{
      display:inline-flex;
      align-items:center;
      gap:.6rem;
      padding:.45rem .8rem;
      border-radius:999px;
      background:#f2f9ff;
      border:1px solid var(--border);
      text-decoration:none;
      color:var(--text);
    }
    .brand-wrap img{ width:28px; height:28px; }
    .btn{
      border-radius: 11px;
      font-weight: 600;
    }
    .btn-primary,
    .btn-success{
      color:#fff;
      border-color: var(--primary);
      background: linear-gradient(135deg, var(--primary), #52a9f5);
      box-shadow: 0 10px 22px rgba(39,134,230,.25);
    }
    .btn-primary:hover,
    .btn-success:hover{
      color:#fff;
      border-color: var(--primary-dark);
      background: linear-gradient(135deg, var(--primary-dark), #469de9);
    }
    .alert-success{
      color:#1a5f3d;
      background:#e8f8ef;
      border-color:#bfe8cf;
    }
    .alert-danger{
      color:#7e2f36;
      background:#fdeef0;
      border-color:#f3c5cb;
    }
    .alert-warning{
      color:#6d571d;
      background:#fff4dc;
      border-color:#efd69a;
    }
    a{ color:#1e73bf; }
    a:hover{ color:#14568f; }
  </style>
</head>
<body>

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-lg-7 col-xl-6">
        <div class="text-center mb-4">
          <a class="brand-wrap" href="/">
            <img src="{{ asset('assets/cdms-logo.svg') }}" alt="CDMS Logo">
            <span class="fw-semibold">CDMS</span>
          </a>
          <h1 class="mt-3 mb-1 fw-bold" style="letter-spacing:-.02em;">@yield('heading')</h1>
          <p class="muted mb-0">@yield('subheading')</p>
        </div>

        <div class="auth-card p-4 p-md-5">
          @yield('content')
        </div>

        <p class="text-center muted mt-4 mb-0" style="font-size:.9rem;">
          &copy; {{ date('Y') }} CDMS. Secure and transparent operations.
        </p>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
