<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') | Fundi Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --brand:#f97316; --brand-dark:#ea6c00;
            --sidebar:#0f172a; --sidebar-hover:rgba(255,255,255,.07);
            --sidebar-border:rgba(255,255,255,.06);
            --bg:#f1f5f9; --card-radius:12px;
        }
        body { background:var(--bg); font-size:.9rem; }
        /* ── Sidebar ── */
        .sidebar {
            width:250px; min-height:100vh; background:var(--sidebar);
            position:fixed; top:0; left:0; display:flex;
            flex-direction:column; z-index:200;
        }
        .sb-brand { padding:1.25rem 1.25rem 1rem; border-bottom:1px solid var(--sidebar-border); }
        .sb-brand .logo {
            width:38px; height:38px; border-radius:10px;
            background:var(--brand); display:flex; align-items:center;
            justify-content:center; color:#fff; font-size:1.1rem; margin-bottom:.6rem;
        }
        .sb-brand .name { color:#fff; font-weight:700; font-size:.95rem; line-height:1.2; }
        .sb-brand .sub  { color:rgba(255,255,255,.35); font-size:.68rem; }
        .sb-section { color:rgba(255,255,255,.3); font-size:.63rem; font-weight:700;
                      letter-spacing:.1em; text-transform:uppercase; padding:.9rem 1.25rem .3rem; }
        .sb-nav { list-style:none; margin:0; padding:0 .6rem; }
        .sb-nav .nav-link {
            color:rgba(255,255,255,.6); padding:.55rem .85rem; border-radius:8px;
            display:flex; align-items:center; gap:.55rem; font-size:.84rem;
            transition:all .15s; margin-bottom:2px;
        }
        .sb-nav .nav-link i { width:18px; font-size:.95rem; }
        .sb-nav .nav-link:hover  { color:#fff; background:var(--sidebar-hover); }
        .sb-nav .nav-link.active { color:#fff; background:var(--brand); }
        .sb-footer {
            margin-top:auto; padding:.85rem 1rem;
            border-top:1px solid var(--sidebar-border);
        }
        .sb-avatar {
            width:32px; height:32px; border-radius:50%;
            background:var(--brand); color:#fff; font-weight:700;
            display:flex; align-items:center; justify-content:center; font-size:.78rem; flex-shrink:0;
        }
        /* ── Main ── */
        .main { margin-left:250px; min-height:100vh; }
        .topbar {
            background:#fff; padding:.85rem 1.5rem;
            border-bottom:1px solid #e2e8f0;
            display:flex; align-items:center; justify-content:space-between;
            position:sticky; top:0; z-index:100;
        }
        .topbar-title { font-weight:600; color:#1e293b; }
        .content { padding:1.5rem; }
        /* ── Cards ── */
        .card { border:none; border-radius:var(--card-radius);
                box-shadow:0 1px 4px rgba(0,0,0,.06); }
        .card-header { background:#fff; border-bottom:1px solid #f1f5f9;
                       font-weight:600; font-size:.88rem; padding:.85rem 1.1rem;
                       border-radius:var(--card-radius) var(--card-radius) 0 0 !important; }
        /* ── Stat cards ── */
        .stat { border-radius:var(--card-radius); padding:1.2rem 1.4rem; color:#fff; }
        .stat-orange { background:linear-gradient(135deg,#f97316,#ea580c); }
        .stat-blue   { background:linear-gradient(135deg,#3b82f6,#2563eb); }
        .stat-green  { background:linear-gradient(135deg,#22c55e,#16a34a); }
        .stat-purple { background:linear-gradient(135deg,#a855f7,#7c3aed); }
        .stat-cyan   { background:linear-gradient(135deg,#06b6d4,#0891b2); }
        .stat .num   { font-size:2rem; font-weight:700; line-height:1; }
        .stat .lbl   { font-size:.78rem; opacity:.85; margin-top:.2rem; }
        .stat .ico   { font-size:2.2rem; opacity:.25; }
        /* ── Buttons ── */
        .btn-brand { background:var(--brand); color:#fff; border:none; }
        .btn-brand:hover { background:var(--brand-dark); color:#fff; }
        /* ── Table ── */
        .table thead th { background:#f8fafc; font-size:.78rem; font-weight:600;
                          text-transform:uppercase; letter-spacing:.04em; color:#64748b; }
        /* ── Badge ── */
        .badge-role-admin       { background:#fef2f2; color:#dc2626; }
        .badge-role-tradesperson{ background:#fffbeb; color:#d97706; }
        .badge-role-customer    { background:#f0fdf4; color:#16a34a; }
    </style>
    @yield('styles')
</head>
<body>

<aside class="sidebar">
    <div class="sb-brand">
        <div class="logo"><i class="bi bi-tools"></i></div>
        <div class="name">Fundi Digital</div>
        <div class="sub">Admin Control Panel</div>
    </div>

    <div class="sb-section">Main</div>
    <ul class="sb-nav">
        <li><a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a></li>
    </ul>

    <div class="sb-section">Management</div>
    <ul class="sb-nav">
        <li><a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> Users
        </a></li>
    </ul>

    <div class="sb-footer">
        <div class="d-flex align-items-center gap-2 mb-2">
            <div class="sb-avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
            <div>
                <div class="text-white small fw-semibold" style="line-height:1.2">{{ auth()->user()->name }}</div>
                <div style="color:rgba(255,255,255,.35);font-size:.68rem">Administrator</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm w-100 text-start"
                    style="color:rgba(255,255,255,.5);background:rgba(255,255,255,.06);border:none">
                <i class="bi bi-box-arrow-right me-1"></i> Sign out
            </button>
        </form>
    </div>
</aside>

<div class="main">
    <div class="topbar">
        <span class="topbar-title">@yield('page-title', 'Dashboard')</span>
        <span class="text-muted small"><i class="bi bi-shield-check text-success me-1"></i>Admin Session</span>
    </div>

    <!-- Toast -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index:9999">
        @if(session('success'))
        <div id="toast-ok" class="toast align-items-center text-bg-success border-0 show">
            <div class="d-flex">
                <div class="toast-body"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        @endif
        @if(session('error'))
        <div id="toast-err" class="toast align-items-center text-bg-danger border-0 show">
            <div class="d-flex">
                <div class="toast-body"><i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        @endif
    </div>

    <div class="content">@yield('content')</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.toast').forEach(t => setTimeout(() => bootstrap.Toast.getOrCreateInstance(t).hide(), 4500));

function togglePwd(id, btn) {
    const inp = document.getElementById(id);
    const ico = btn.querySelector('i');
    inp.type = inp.type === 'password' ? 'text' : 'password';
    ico.className = inp.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}

function swalDelete(formId, name) {
    Swal.fire({
        title: 'Delete ' + (name || 'this record') + '?',
        text: 'This cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, delete',
    }).then(r => { if (r.isConfirmed) document.getElementById(formId).submit(); });
}
</script>
@yield('scripts')
</body>
</html>
