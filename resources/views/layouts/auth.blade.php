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
      --bg:#f4f2ec;
      --bg-soft:#f7f5ef;
      --text:#243126;
      --muted:#6b7769;
      --card:#fffdf9;
      --border:#d8d4c8;
      --primary:#426b4a;
      --primary-dark:#2f5136;
      --soft:#eef0e5;
    }
    body{
      min-height:100vh;
      background:
        radial-gradient(900px 560px at 12% 4%, rgba(221,229,210,.55), transparent 55%),
        radial-gradient(820px 620px at 90% 10%, rgba(231,225,211,.42), transparent 52%),
        linear-gradient(180deg, var(--bg) 0%, var(--bg-soft) 100%);
      color:var(--text);
    }
    .auth-card{
      background: var(--card);
      border: 1px solid var(--border);
      backdrop-filter: blur(6px);
      border-radius: 20px;
      box-shadow: 0 18px 40px rgba(44, 52, 39, .10);
    }
    .muted{ color:var(--muted) !important; }
    .form-control, .form-select{
      background: #faf8f2;
      border: 1px solid var(--border);
      color: var(--text);
    }
    .form-control:focus, .form-select:focus{
      background: #fffdf9;
      border-color: #90ab93;
      box-shadow: 0 0 0 .22rem rgba(66,107,74,.14);
      color: var(--text);
    }
    .form-control::placeholder{ color: #98a396; }
    .brand-wrap{
      display:inline-flex;
      align-items:center;
      gap:.6rem;
      padding:.45rem .8rem;
      border-radius:999px;
      background:#f7f4ed;
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
      background: linear-gradient(135deg, var(--primary), #5b8461);
      box-shadow: 0 10px 22px rgba(66,107,74,.20);
    }
    .btn-primary:hover,
    .btn-success:hover{
      color:#fff;
      border-color: var(--primary-dark);
      background: linear-gradient(135deg, var(--primary-dark), #44694a);
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
    a{ color:var(--primary); }
    a:hover{ color:var(--primary-dark); }
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
