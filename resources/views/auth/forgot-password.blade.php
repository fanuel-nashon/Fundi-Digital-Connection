<x-guest-layout>
    <h2>Reset password</h2>
    <p class="sub">Enter your email and we'll send you a reset link</p>

    @if(session('status'))
        <div class="alert alert-success d-flex align-items-center gap-2 mb-3" style="border-radius:8px;font-size:.85rem">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="form-label">Email Address</label>
            <input id="email" type="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required autofocus placeholder="you@example.com">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn-auth mb-3">
            <i class="bi bi-send me-2"></i>Send Reset Link
        </button>

        <p class="text-center text-muted small mb-0">
            Remembered it?
            <a href="{{ route('login') }}" class="text-decoration-none fw-semibold" style="color:#f97316">Back to sign in</a>
        </p>
    </form>

    @if(config('mail.default') === 'log')
        <div class="mt-4 p-3 rounded" style="background:#f8fafc;border:1px dashed #cbd5e1;font-size:.78rem;color:#64748b">
            <i class="bi bi-info-circle me-1"></i>
            <strong>Dev mode:</strong> Reset links are written to
            <code>storage/logs/laravel.log</code> — search for <em>reset-password</em> in the log.
        </div>
    @endif
</x-guest-layout>
