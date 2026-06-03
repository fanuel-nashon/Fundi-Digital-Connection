<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fundi Digital Connection — Find Skilled Tradespeople</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --brand:#f97316; --brand-dark:#ea6c00; }
        body { font-size:.9rem; background:#f8fafc; }

        /* ── Navbar ── */
        .navbar { background:#0f172a; }
        .navbar-brand { font-weight:900; font-size:1.1rem; color:#fff !important; }
        .navbar-brand span { color:var(--brand); }
        .nav-link { color:rgba(255,255,255,.7) !important; font-size:.875rem; }
        .nav-link:hover { color:#fff !important; }

        /* ── Hero ── */
        .hero {
            background:linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            padding:5rem 0 4rem; position:relative; overflow:hidden;
        }
        .hero::before {
            content:''; position:absolute; top:-60px; right:-60px;
            width:350px; height:350px; border-radius:50%;
            background:rgba(249,115,22,.08); pointer-events:none;
        }
        .hero h1 { font-weight:800; font-size:2.6rem; color:#fff; line-height:1.2; }
        .hero h1 span { color:var(--brand); }
        .hero p { color:rgba(255,255,255,.65); font-size:1rem; max-width:520px; }

        /* ── Filter bar ── */
        .filter-bar { background:#fff; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,.1); padding:1rem 1.25rem; }
        .filter-bar .form-control, .filter-bar .form-select { border-color:#e2e8f0; border-radius:8px; font-size:.875rem; }
        .filter-bar .form-control:focus, .filter-bar .form-select:focus { border-color:var(--brand); box-shadow:0 0 0 3px rgba(249,115,22,.12); }

        /* ── Cards ── */
        .card { border:none; border-radius:12px; box-shadow:0 1px 4px rgba(0,0,0,.07); transition:transform .15s, box-shadow .15s; }
        .card:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(0,0,0,.1); }
        .trade-badge { background:#fff7ed; color:#ea580c; font-size:.72rem; border-radius:6px; padding:.2rem .55rem; display:inline-block; }
        .avail-badge { background:#f0fdf4; color:#16a34a; font-size:.72rem; border-radius:6px; padding:.2rem .55rem; }
        .star { color:#f59e0b; font-size:.8rem; }
        .btn-book { background:var(--brand); color:#fff; border:none; border-radius:8px; font-size:.85rem; padding:.5rem 1.1rem; transition:background .15s; }
        .btn-book:hover { background:var(--brand-dark); color:#fff; }

        /* ── CTA banner ── */
        .cta-banner { background:linear-gradient(135deg, #0f172a, #1e293b); border-radius:16px; padding:3rem; }

        /* ── Footer ── */
        footer { background:#0f172a; color:rgba(255,255,255,.5); font-size:.82rem; }

        @media(max-width:768px) { .hero h1 { font-size:1.8rem; } }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">Fundi<span>Digital</span></a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link active" href="{{ route('home') }}">Find Tradespeople</a></li>
            </ul>
            <div class="d-flex gap-2">
                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light">Sign In</a>
                <a href="{{ route('register') }}?role=customer" class="btn btn-sm" style="background:var(--brand);color:#fff;border:none">
                    Register
                </a>
            </div>
        </div>
    </div>
</nav>

{{-- Hero --}}
<section class="hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h1>Find Skilled<br><span>Tradespeople</span><br>Near You</h1>
                <p class="mt-3 mb-4">Browse verified plumbers, electricians, carpenters, welders and masons across Tanzania. Read reviews, check availability, and request a service.</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('register') }}?role=customer"
                       class="btn px-4 py-2 fw-semibold" style="background:var(--brand);color:#fff;border-radius:8px">
                        <i class="bi bi-person-plus me-2"></i>Register as Customer
                    </a>
                    <a href="{{ route('register') }}?role=tradesperson"
                       class="btn btn-outline-light px-4 py-2 fw-semibold" style="border-radius:8px">
                        <i class="bi bi-tools me-2"></i>Post Your Services
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                {{-- Filter bar --}}
                <div class="filter-bar">
                    <form method="GET" action="{{ route('home') }}">
                        <div class="row g-2">
                            <div class="col-sm-5">
                                <select name="category" class="form-select">
                                    <option value="">All Categories</option>
                                    @foreach(['plumbing','electrical','carpentry','welding','masonry'] as $cat)
                                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>
                                            {{ ucfirst($cat) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-5">
                                <input type="text" name="location" class="form-control"
                                       placeholder="Location (e.g. Arusha)" value="{{ request('location') }}">
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" class="btn w-100 fw-semibold"
                                        style="background:var(--brand);color:#fff;border-radius:8px">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                        @if(request()->hasAny(['category','location']))
                            <div class="mt-2">
                                <a href="{{ route('home') }}" class="text-muted small text-decoration-none">
                                    <i class="bi bi-x-circle me-1"></i>Clear filters
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Tradesperson listing --}}
<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h5 class="fw-bold mb-0">Available Tradespeople</h5>
                <p class="text-muted small mb-0">{{ $tradespersons->count() }} professional{{ $tradespersons->count() !== 1 ? 's' : '' }} found</p>
            </div>
        </div>

        @if($tradespersons->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-search fs-1 d-block mb-3"></i>
                <p>No tradespeople found matching your criteria.</p>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">Clear filters</a>
            </div>
        @else
        <div class="row g-4">
            @foreach($tradespersons as $profile)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column p-4">
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white flex-shrink-0"
                                 style="width:46px;height:46px;background:#0891b2;font-size:.95rem">
                                {{ strtoupper(substr($profile->user->name, 0, 1)) }}
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">{{ $profile->user->name }}</div>
                                <div class="text-muted small">
                                    <i class="bi bi-geo-alt me-1"></i>{{ $profile->user->location ?? 'Location not set' }}
                                </div>
                            </div>
                            <span class="avail-badge">Available</span>
                        </div>

                        <span class="trade-badge mb-2 align-self-start">
                            <i class="bi bi-tools me-1"></i>{{ ucfirst($profile->category) }}
                        </span>

                        <p class="text-muted small flex-grow-1 mb-3"
                           style="overflow:hidden;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical">
                            {{ $profile->bio }}
                        </p>

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= round($profile->avg_rating) ? '-fill star' : ' text-muted' }}"
                                       style="font-size:.8rem;{{ $i <= round($profile->avg_rating) ? 'color:#f59e0b' : 'color:#e2e8f0' }}"></i>
                                @endfor
                                <span class="text-muted small ms-1">
                                    {{ $profile->avg_rating > 0 ? $profile->avg_rating : 'No ratings' }}
                                </span>
                            </div>
                            <small class="text-muted">{{ $profile->reviews }} review{{ $profile->reviews !== 1 ? 's' : '' }}</small>
                        </div>

                        {{-- CTA: prompt register if not logged in --}}
                        <a href="{{ route('register') }}?role=customer"
                           class="btn-book w-100 text-center py-2 text-decoration-none d-block">
                            <i class="bi bi-calendar-check me-1"></i>Book Service
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

{{-- CTA section --}}
<section class="py-5" style="background:#fff">
    <div class="container">
        <div class="cta-banner text-center">
            <h4 class="fw-bold text-white mb-2">Are you a skilled tradesperson?</h4>
            <p class="mb-4" style="color:rgba(255,255,255,.65)">
                Register your services on Fundi Digital and connect with customers across Tanzania.
            </p>
            <a href="{{ route('register') }}?role=tradesperson"
               class="btn px-5 py-2 fw-semibold" style="background:var(--brand);color:#fff;border-radius:8px">
                <i class="bi bi-tools me-2"></i>Post My Services
            </a>
        </div>
    </div>
</section>

{{-- Footer --}}
<footer class="py-4">
    <div class="container d-flex align-items-center justify-content-between flex-wrap gap-2">
        <span class="fw-semibold" style="color:#fff">Fundi<span style="color:var(--brand)">Digital</span></span>
        <span>&copy; {{ date('Y') }} Fundi Digital Connection. All rights reserved.</span>
        <a href="{{ route('login') }}" class="text-decoration-none" style="color:rgba(255,255,255,.5)">Sign In</a>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
