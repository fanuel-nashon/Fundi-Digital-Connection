<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Fundi Digital') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --brand:#f97316; }
        html, body { height:100%; margin:0; }
        body { display:flex; min-height:100vh; font-size:.9rem; background:#f8fafc; }
        .auth-panel {
            width:360px; flex-shrink:0; background:#0f172a;
            display:flex; flex-direction:column; justify-content:center;
            padding:3rem 2.5rem; position:relative; overflow:hidden;
        }
        .auth-panel::before {
            content:''; position:absolute; top:-80px; right:-80px;
            width:220px; height:220px; border-radius:50%; background:rgba(249,115,22,.12);
        }
        .auth-panel::after {
            content:''; position:absolute; bottom:-60px; left:-40px;
            width:160px; height:160px; border-radius:50%; background:rgba(249,115,22,.07);
        }
        .auth-logo { font-weight:900; font-size:1.5rem; color:#fff; margin-bottom:.5rem; }
        .auth-logo span { color:var(--brand); }
        .auth-tagline { color:rgba(255,255,255,.45); font-size:.84rem; line-height:1.6; margin-bottom:2rem; }
        .auth-feature { display:flex; align-items:center; gap:.7rem; margin-bottom:.85rem; }
        .auth-feature .ico {
            width:34px; height:34px; border-radius:8px; flex-shrink:0;
            background:rgba(249,115,22,.15); color:var(--brand);
            display:flex; align-items:center; justify-content:center; font-size:.95rem;
        }
        .auth-feature .lbl { color:rgba(255,255,255,.65); font-size:.8rem; }
        .auth-form-wrap {
            flex:1; display:flex; align-items:center;
            justify-content:center; padding:2rem;
        }
        .auth-card {
            width:100%; max-width:420px; background:#fff;
            border-radius:16px; box-shadow:0 4px 24px rgba(0,0,0,.08); padding:2.25rem;
        }
        .auth-card h2 { font-weight:700; font-size:1.3rem; color:#1e293b; margin-bottom:.25rem; }
        .auth-card .sub { color:#64748b; font-size:.82rem; margin-bottom:1.5rem; }
        .form-label { font-weight:500; color:#374151; font-size:.83rem; }
        .form-control { border-radius:8px; border-color:#e2e8f0; font-size:.875rem; }
        .form-control:focus { border-color:var(--brand); box-shadow:0 0 0 3px rgba(249,115,22,.12); }
        .btn-auth { background:var(--brand); color:#fff; border:none; border-radius:8px;
                    padding:.65rem; font-weight:600; width:100%; transition:background .15s; }
        .btn-auth:hover { background:#ea6c00; color:#fff; }
        .strength-bar { height:4px; border-radius:2px; transition:all .25s; }
        @media(max-width:767px){ .auth-panel { display:none; } }
    </style>
</head>
<body>

<div class="auth-panel">
    <div class="auth-logo">Fundi<span>Digital</span></div>
    <p class="auth-tagline">Connecting skilled tradespeople with customers across Tanzania.</p>
    <div class="auth-feature"><div class="ico"><i class="bi bi-search"></i></div><div class="lbl">Find verified tradespeople by skill & location</div></div>
    <div class="auth-feature"><div class="ico"><i class="bi bi-chat-dots"></i></div><div class="lbl">Secure messaging for every job request</div></div>
    <div class="auth-feature"><div class="ico"><i class="bi bi-star"></i></div><div class="lbl">Honest ratings & written reviews</div></div>
    <div class="auth-feature"><div class="ico"><i class="bi bi-shield-check"></i></div><div class="lbl">Secure role-based access control</div></div>
</div>

<div class="auth-form-wrap">
    <div class="auth-card">
        {{ $slot }}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePwd(id, btn) {
    const inp = document.getElementById(id);
    inp.type = inp.type === 'password' ? 'text' : 'password';
    btn.querySelector('i').className = inp.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
function checkStrength(id) {
    const v = document.getElementById(id).value;
    let s = 0;
    if (v.length >= 8) s++;
    if (/[A-Z]/.test(v)) s++;
    if (/[0-9]/.test(v)) s++;
    if (/[^A-Za-z0-9]/.test(v)) s++;
    const bar = document.getElementById('str-bar');
    const txt = document.getElementById('str-txt');
    if (!bar) return;
    const map=[['0','secondary',''],['25%','danger','Weak'],['50%','warning','Fair'],['75%','info','Good'],['100%','success','Strong ✓']];
    bar.style.width=map[s][0]; bar.className=`strength-bar bg-${map[s][1]}`;
    txt.textContent=map[s][2]; txt.className=`small text-${map[s][1]}`;
}
</script>
</body>
</html>
