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
        :root { --brand:#f97316; --brand-dark:#ea6c00; --bg:#f1f5f9; --card-radius:12px; }
        body { background:var(--bg); font-size:.9rem; }
        .navbar { background:#fff; box-shadow:0 1px 4px rgba(0,0,0,.07); }
        .navbar-brand { font-weight:800; font-size:1.1rem; color:#1e293b !important; }
        .navbar-brand span { color:var(--brand); }
        .nav-link { color:#475569 !important; font-size:.875rem; }
        .nav-link:hover, .nav-link.active { color:var(--brand) !important; }
        .btn-brand { background:var(--brand); color:#fff; border:none; border-radius:8px; }
        .btn-brand:hover { background:var(--brand-dark); color:#fff; }
        .card { border:none; border-radius:var(--card-radius); box-shadow:0 1px 4px rgba(0,0,0,.06); }
        .card-header { background:#fff; border-bottom:1px solid #f1f5f9; font-weight:600;
                       border-radius:var(--card-radius) var(--card-radius) 0 0 !important; }
        .badge-cat { background:#fff7ed; color:#ea580c; font-size:.72rem; }
        .star-gold { color:#f59e0b; }
        .star-empty { color:#e2e8f0; }
        .page-header { margin-bottom:1.5rem; }
        .page-header h4 { font-weight:700; color:#1e293b; margin-bottom:.25rem; }
        .page-header p  { color:#64748b; font-size:.84rem; margin:0; }
        /* Availability badges */
        .avail-yes { background:#f0fdf4; color:#16a34a; }
        .avail-no  { background:#f8fafc; color:#94a3b8; }
    </style>
    @yield('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('customer.dashboard') }}">
            Fundi<span>Digital</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active fw-semibold' : '' }}"
                       href="{{ route('customer.dashboard') }}">
                        <i class="bi bi-search me-1"></i>Find Tradesperson
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('customer.my-requests') ? 'active fw-semibold' : '' }}"
                       href="{{ route('customer.my-requests') }}">
                        <i class="bi bi-briefcase me-1"></i>My Requests
                        @php
                            $activeCount = \App\Models\JobRequest::where('customer_id', auth()->id())
                                ->whereIn('status', ['pending','accepted','complete'])->count();
                        @endphp
                        @if($activeCount)
                            <span class="badge bg-warning text-dark ms-1" style="font-size:.65rem">{{ $activeCount }}</span>
                        @endif
                    </a>
                </li>
            </ul>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted small d-none d-md-inline">
                    <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                </span>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-secondary">
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
