<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Fundi Digital')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --brand:#0891b2; --brand-dark:#0e7490; --bg:#f1f5f9; --card-radius:12px; }
        body { background:var(--bg); font-size:.9rem; }
        .navbar { background:#0f172a; }
        .navbar-brand { font-weight:800; font-size:1.1rem; color:#fff !important; }
        .navbar-brand span { color:var(--brand); }
        .nav-link { color:rgba(255,255,255,.7) !important; font-size:.875rem; }
        .nav-link:hover, .nav-link.active { color:#fff !important; }
        .navbar-toggler { border-color:rgba(255,255,255,.2); }
        .btn-brand { background:var(--brand); color:#fff; border:none; border-radius:8px; }
        .btn-brand:hover { background:var(--brand-dark); color:#fff; }
        .card { border:none; border-radius:var(--card-radius); box-shadow:0 1px 4px rgba(0,0,0,.06); }
        .card-header { background:#fff; border-bottom:1px solid #f1f5f9; font-weight:600;
                       border-radius:var(--card-radius) var(--card-radius) 0 0 !important; }
        .page-header { margin-bottom:1.5rem; }
        .page-header h4 { font-weight:700; color:#1e293b; margin-bottom:.25rem; }
        .page-header p  { color:#64748b; font-size:.84rem; margin:0; }
        .badge-pending  { background:#fffbeb; color:#d97706; }
        .badge-accepted { background:#eff6ff; color:#2563eb; }
        .badge-complete { background:#f0fdf4; color:#16a34a; }
        .badge-reviewed { background:#f8fafc; color:#64748b; }
        .badge-declined { background:#fef2f2; color:#dc2626; }
    </style>
    @yield('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('tradesperson.tradesperson-dashboard') }}">
            Fundi<span>Digital</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tradesperson.tradesperson-dashboard') ? 'active' : '' }}"
                       href="{{ route('tradesperson.tradesperson-dashboard') }}">
                        <i class="bi bi-grid me-1"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tradesperson.job-requests.*') ? 'active' : '' }}"
                       href="{{ route('tradesperson.job-requests.index') }}">
                        <i class="bi bi-briefcase me-1"></i>Job Requests
                        @php $pending = \App\Models\JobRequest::where('tradesperson_id', auth()->id())->where('status','pending')->count(); @endphp
                        @if($pending) <span class="badge bg-warning text-dark ms-1">{{ $pending }}</span> @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tradesperson.tradesperson-profile') ? 'active' : '' }}"
                       href="{{ route('tradesperson.tradesperson-profile', auth()->id()) }}">
                        <i class="bi bi-person-badge me-1"></i>My Profile
                    </a>
                </li>
            </ul>
            <div class="d-flex align-items-center gap-3">
                <span class="text-white-50 small d-none d-md-inline">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm" style="background:rgba(255,255,255,.1);color:rgba(255,255,255,.7)">
                        <i class="bi bi-box-arrow-right me-1"></i>Sign out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Toast -->
<div class="position-fixed top-0 end-0 p-3" style="z-index:9999">
    @if(session('success'))
    <div class="toast align-items-center text-bg-success border-0 show">
        <div class="d-flex">
            <div class="toast-body"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
    @endif
    @if(session('error'))
    <div class="toast align-items-center text-bg-danger border-0 show">
        <div class="d-flex">
            <div class="toast-body"><i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
    @endif
</div>

<div class="container py-4">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.toast').forEach(t => setTimeout(() => bootstrap.Toast.getOrCreateInstance(t).hide(), 4500));
function togglePwd(id, btn) {
    const inp = document.getElementById(id);
    inp.type = inp.type === 'password' ? 'text' : 'password';
    btn.querySelector('i').className = inp.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>
@yield('scripts')
</body>
</html>
