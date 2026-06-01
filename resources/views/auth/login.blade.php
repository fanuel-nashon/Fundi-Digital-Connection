<x-guest-layout>
    <h2>Welcome back</h2>
    <p class="sub">Sign in to your Fundi Digital account</p>

    <x-auth-session-status class="mb-3" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required autofocus autocomplete="username"
                   placeholder="you@example.com">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="password" class="form-label mb-0">Password</label>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-decoration-none small" style="color:#f97316">Forgot password?</a>
                @endif
            </div>
            <div class="input-group">
                <input id="password" type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       required autocomplete="current-password" placeholder="••••••••">
                <button type="button" class="btn btn-outline-secondary px-3" onclick="togglePwd('password', this)">
                    <i class="bi bi-eye"></i>
                </button>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label small text-muted" for="remember">Keep me signed in</label>
            </div>
        </div>

        <button type="submit" class="btn-auth">Sign In</button>

        <p class="text-center text-muted small mt-3 mb-0">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-decoration-none fw-semibold" style="color:#f97316">Create one</a>
        </p>
    </form>
</x-guest-layout>
