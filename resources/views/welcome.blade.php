<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fundi Digital Connection — Sign In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --brand:#f97316; --brand-dark:#ea6c00; }
        html, body { height:100%; margin:0; font-size:.9rem; }
        body { display:flex; min-height:100vh; background:#f8fafc; }

        /* ── Left panel ── */
        .auth-panel {
            width:380px; flex-shrink:0; background:#0f172a;
            display:flex; flex-direction:column; justify-content:center;
            padding:3rem 2.5rem; position:relative; overflow:hidden;
        }
        .auth-panel::before {
            content:''; position:absolute; top:-80px; right:-80px;
            width:240px; height:240px; border-radius:50%;
            background:rgba(249,115,22,.13); pointer-events:none;
        }
        .auth-panel::after {
            content:''; position:absolute; bottom:-60px; left:-40px;
            width:180px; height:180px; border-radius:50%;
            background:rgba(249,115,22,.07); pointer-events:none;
        }
        .brand-name { font-weight:900; font-size:1.6rem; color:#fff; }
        .brand-name span { color:var(--brand); }
        .brand-sub { color:rgba(255,255,255,.45); font-size:.84rem; margin-bottom:2.5rem; }
        .feature { display:flex; align-items:center; gap:.75rem; margin-bottom:1rem; }
        .feature-icon {
            width:38px; height:38px; border-radius:10px; flex-shrink:0;
            background:rgba(249,115,22,.15); color:var(--brand);
            display:flex; align-items:center; justify-content:center; font-size:1rem;
        }
        .feature-text { color:rgba(255,255,255,.65); font-size:.82rem; line-height:1.4; }

        /* ── Right form ── */
        .auth-form-wrap {
            flex:1; display:flex; align-items:center;
            justify-content:center; padding:2rem;
        }
        .auth-card {
            width:100%; max-width:440px; background:#fff;
            border-radius:16px; box-shadow:0 4px 28px rgba(0,0,0,.09);
            padding:2.5rem;
        }
        .auth-card h2 { font-weight:700; font-size:1.4rem; color:#1e293b; margin-bottom:.3rem; }
        .auth-card .sub { color:#64748b; font-size:.84rem; margin-bottom:1.75rem; }

        .form-label { font-weight:500; color:#374151; font-size:.84rem; margin-bottom:.35rem; }
        .form-control {
            border-radius:8px; border-color:#e2e8f0;
            font-size:.875rem; padding:.6rem .85rem;
        }
        .form-control:focus {
            border-color:var(--brand);
            box-shadow:0 0 0 3px rgba(249,115,22,.15);
        }
        .input-group .btn { border-color:#e2e8f0; color:#64748b; }
        .input-group .btn:hover { background:#f8fafc; }

        .btn-sign-in {
            background:var(--brand); color:#fff; border:none;
            border-radius:8px; padding:.7rem; font-weight:600;
            font-size:.9rem; width:100%; transition:background .15s;
        }
        .btn-sign-in:hover { background:var(--brand-dark); }

        .divider { border-top:1px solid #f1f5f9; margin:1.25rem 0; }

        @media (max-width:768px) { .auth-panel { display:none; } }
    </style>
</head>
<body>

{{-- Left branding panel --}}
<div class="auth-panel">
    <div class="brand-name">Fundi<span>Digital</span></div>
    <div class="brand-sub">Connecting skilled tradespeople with customers across Tanzania</div>

    <div class="feature">
        <div class="feature-icon"><i class="bi bi-search"></i></div>
        <div class="feature-text">Find verified tradespeople by skill, location & rating</div>
    </div>
    <div class="feature">
        <div class="feature-icon"><i class="bi bi-chat-dots"></i></div>
        <div class="feature-text">Secure in-app messaging for every job request</div>
    </div>
    <div class="feature">
        <div class="feature-icon"><i class="bi bi-star-fill"></i></div>
        <div class="feature-text">Real customer ratings and written reviews</div>
    </div>
    <div class="feature">
        <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
        <div class="feature-text">Role-based access for admins, tradespeople & customers</div>
    </div>
</div>

{{-- Right form panel --}}
<div class="auth-form-wrap">
    <div class="auth-card">
        <h2>Welcome back</h2>
        <p class="sub">Sign in to your Fundi Digital account</p>

        {{-- Session / validation errors --}}
        @if(session('status'))
            <div class="alert alert-success d-flex gap-2 align-items-center" style="border-radius:8px;font-size:.84rem">
                <i class="bi bi-check-circle-fill"></i>{{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger d-flex gap-2 align-items-center" style="border-radius:8px;font-size:.84rem">
                <i class="bi bi-exclamation-circle-fill"></i>{{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" required autofocus
                       placeholder="you@example.com" autocomplete="username">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="password" class="form-label mb-0">Password</label>
                    <a href="{{ route('password.request') }}"
                       class="text-decoration-none small fw-medium" style="color:var(--brand)">
                        Forgot password?
                    </a>
                </div>
                <div class="input-group">
                    <input id="password" type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           required autocomplete="current-password" placeholder="••••••••">
                    <button type="button" class="btn btn-outline-secondary px-3"
                            onclick="togglePwd('password', this)" tabindex="-1">
                        <i class="bi bi-eye"></i>
                    </button>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-4 d-flex align-items-center justify-content-between">
                <div class="form-check mb-0">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label small text-muted" for="remember">Keep me signed in</label>
                </div>
            </div>

            <button type="submit" class="btn-sign-in">
                <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
            </button>
        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePwd(id, btn) {
    const inp = document.getElementById(id);
    inp.type = inp.type === 'password' ? 'text' : 'password';
    btn.querySelector('i').className = inp.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>
</body>
</html>
