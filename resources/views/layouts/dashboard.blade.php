<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Dashboard - CDMS')</title>
  <link rel="icon" type="image/svg+xml" href="{{ asset('assets/cdms-logo.svg') }}">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root{
      --sky-bg:#eaf5ff;
      --sky-bg-soft:#f5faff;
      --sky-text:#0f2746;
      --sky-muted:#56708f;
      --sky-line:#c7ddf5;
      --sky-card:#ffffff;
      --sky-shadow:0 12px 34px rgba(37, 91, 149, .14);
      --sky-primary:#2786e6;
      --sky-primary-dark:#1f6fbe;
      --sky-primary-soft:#d5eaff;
    }
    body{
      background:
        radial-gradient(1100px 680px at 12% 5%, rgba(87,163,235,.20), transparent 55%),
        radial-gradient(1000px 700px at 88% 12%, rgba(170,212,248,.28), transparent 52%),
        linear-gradient(180deg, var(--sky-bg) 0%, var(--sky-bg-soft) 100%);
      color:var(--sky-text);
    }
    .shell{ min-height: 100vh; }
    .sidebar{
      background: rgba(255,255,255,.86);
      border-right: 1px solid var(--sky-line);
      backdrop-filter: blur(8px);
    }
    .card-glass{
      background: var(--sky-card);
      border: 1px solid var(--sky-line);
      backdrop-filter: blur(6px);
      border-radius: 18px;
      box-shadow: var(--sky-shadow);
    }
    .nav-link{
      color: var(--sky-muted);
      border-radius: 12px;
      padding: .65rem .85rem;
    }
    .nav-link:hover{ color:var(--sky-text); background: #edf6ff; }
    .nav-link.active{ color:#0c3f71; background: var(--sky-primary-soft); border: 1px solid #b7d7f7; }
    .muted{ color: var(--sky-muted); }
    .badge-role{
      background: #eef6ff;
      border: 1px solid #b8d9fb;
      color:#1b5d98;
    }
    .btn{
      border-radius: 11px;
      font-weight: 600;
      border-width: 1px;
    }
    .btn-primary,
    .btn-success,
    .btn-info{
      color: #fff;
      border-color: var(--sky-primary);
      background: linear-gradient(135deg, var(--sky-primary), #52a9f5);
      box-shadow: 0 10px 22px rgba(39,134,230,.25);
    }
    .btn-primary:hover,
    .btn-success:hover,
    .btn-info:hover{
      color:#fff;
      border-color: var(--sky-primary-dark);
      background: linear-gradient(135deg, var(--sky-primary-dark), #469de9);
    }
    .btn-outline-light{
      color: #1d5f99;
      border-color: #9dc7ef;
      background: #f4faff;
    }
    .btn-outline-light:hover{
      color: #0f4d86;
      border-color: #85b8e8;
      background: #e7f3ff;
    }
    .btn-danger{
      background: linear-gradient(135deg, #d85454, #b93d3d);
      border-color: #b93d3d;
      color:#fff;
    }
    .btn-warning{
      background: linear-gradient(135deg, #f2b544, #dc9730);
      border-color: #dc9730;
      color:#1f2f46;
    }
    .form-control, .form-select{
      border-color: #b8d6f1;
      background: #f9fcff;
      color: var(--sky-text);
    }
    .form-control:focus, .form-select:focus{
      border-color: #82b8ea;
      box-shadow: 0 0 0 .2rem rgba(39,134,230,.16);
      background: #fff;
      color: var(--sky-text);
    }
    .table{
      --bs-table-bg: #ffffff;
      --bs-table-color: var(--sky-text);
      --bs-table-border-color: var(--sky-line);
    }
    .alert{
      border-radius: 12px;
      border: 1px solid transparent;
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
    .kpi{
      display:flex; align-items:center; justify-content:space-between;
      padding: 16px 18px;
      border-radius: 16px;
      background: #f8fbff;
      border: 1px solid #d0e5fa;
    }
    a{ color:#1e73bf; }
    a:hover{ color:#14568f; }
  </style>
</head>
<body>

<div class="container-fluid shell">
  <div class="row g-0">

    <!-- Sidebar -->
    <aside class="col-12 col-lg-3 col-xl-2 sidebar p-3 p-lg-4">
      <div class="d-flex align-items-center gap-2 mb-4">
        <img src="{{ asset('assets/cdms-logo.svg') }}" alt="CDMS Logo" style="width:28px;height:28px;">
        <div class="fw-bold">CDMS</div>
      </div>

      <div class="mb-3">
        <div class="fw-semibold">{{ auth()->user()->name }}</div>
        <div class="muted" style="font-size:.9rem;">{{ auth()->user()->email }}</div>
        <span class="badge badge-role mt-2">{{ strtoupper(auth()->user()->role) }}</span>
      </div>

      <nav class="d-grid gap-2 mt-4">
        @yield('sidebar')
      </nav>

      <div class="mt-4">
        <form method="POST" action="/logout">
          @csrf
          <button class="btn btn-outline-light w-100">Logout</button>
        </form>
      </div>

      <div class="muted mt-4" style="font-size:.85rem;">
        &copy; {{ date('Y') }} CDMS
      </div>
    </aside>

    <!-- Main -->
    <main class="col-12 col-lg-9 col-xl-10 p-3 p-lg-4">
      <div class="d-flex flex-wrap align-items-end justify-content-between gap-2 mb-3">
        <div>
          <h3 class="mb-0 fw-bold">@yield('page_title')</h3>
          <div class="muted">@yield('page_subtitle')</div>
        </div>
        <div>
          @yield('top_actions')
        </div>
      </div>

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
          </ul>
        </div>
      @endif

      @php($unreadNotifications = auth()->user()->unreadNotifications()->latest()->limit(5)->get())
      @if($unreadNotifications->count() > 0)
        <div class="card-glass p-3 mb-3" style="border:1px solid #b7d7f7;">
          <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
            <div class="fw-semibold">Notifications ({{ auth()->user()->unreadNotifications()->count() }} unread)</div>
            <form method="POST" action="{{ url('/notifications/read-all') }}">
              @csrf
              <button class="btn btn-outline-light btn-sm">Mark All Read</button>
            </form>
          </div>
          <div class="d-grid gap-2">
            @foreach($unreadNotifications as $n)
              <div class="p-2 rounded" style="background:#f8fbff; border:1px solid #d0e5fa;">
                <div class="fw-semibold">{{ $n->data['title'] ?? 'Notification' }}</div>
                <div class="muted">{{ $n->data['message'] ?? '' }}</div>
                @if(!empty($n->data['url']))
                  <a href="{{ url($n->data['url']) }}" class="small">Open</a>
                @endif
              </div>
            @endforeach
          </div>
        </div>
      @endif

      @yield('content')
    </main>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
