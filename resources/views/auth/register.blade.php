<x-guest-layout>
    <h2>Create account</h2>
    <p class="sub">Join Fundi Digital Connection</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input id="name" type="text" name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}" required autofocus placeholder="John Doe">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input id="email" type="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required placeholder="you@example.com">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <input id="password" type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       required autocomplete="new-password" placeholder="••••••••"
                       oninput="checkStrength('password')">
                <button type="button" class="btn btn-outline-secondary px-3" onclick="togglePwd('password', this)">
                    <i class="bi bi-eye"></i>
                </button>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mt-2">
                <div class="bg-light rounded" style="height:4px">
                    <div id="str-bar" class="strength-bar" style="width:0"></div>
                </div>
                <span id="str-txt" class="small text-muted"></span>
                <span class="small text-muted float-end">Min 8 chars, uppercase, number & symbol</span>
            </div>
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <div class="input-group">
                <input id="password_confirmation" type="password" name="password_confirmation"
                       class="form-control" required autocomplete="new-password" placeholder="••••••••">
                <button type="button" class="btn btn-outline-secondary px-3" onclick="togglePwd('password_confirmation', this)">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn-auth">Create Account</button>

        <p class="text-center text-muted small mt-3 mb-0">
            Already have an account?
            <a href="{{ route('login') }}" class="text-decoration-none fw-semibold" style="color:#f97316">Sign in</a>
        </p>
    </form>
</x-guest-layout>
