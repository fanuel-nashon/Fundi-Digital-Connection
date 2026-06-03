<x-guest-layout>
    <h2>Create account</h2>
    <p class="sub">Join Fundi Digital Connection as a <strong>{{ ucfirst($role) }}</strong></p>

    <form method="POST" action="{{ route('register') }}" id="reg-form">
        @csrf
        <input type="hidden" name="role" value="{{ $role }}">

        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}" required autofocus placeholder="e.g. Asha Said">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required placeholder="you@example.com">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Location</label>
            <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                   value="{{ old('location') }}" required placeholder="e.g. Dar es Salaam">
            @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        @if($role === 'tradesperson')
        <div class="mb-3">
            <label class="form-label">Trade Category</label>
            <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                <option value="">— Select your trade —</option>
                @foreach(['plumbing','electrical','carpentry','welding','masonry'] as $cat)
                    <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                @endforeach
            </select>
            @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Bio <span class="text-muted fw-normal small">— describe your skills & experience</span></label>
            <textarea name="bio" rows="3" class="form-control @error('bio') is-invalid @enderror"
                      placeholder="e.g. 8 years experience in residential plumbing across Dar es Salaam..." required>{{ old('bio') }}</textarea>
            @error('bio')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        @endif

        <div class="alert mb-4 p-3" style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;font-size:.82rem">
            <i class="bi bi-info-circle-fill text-success me-2"></i>
            Your application will be reviewed by an admin. You will receive your <strong>login credentials by email</strong> once approved.
        </div>

        <button type="submit" class="btn-auth">
            <i class="bi bi-send me-2"></i>Submit Application
        </button>

        <p class="text-center text-muted small mt-3 mb-0">
            Already have an account?
            <a href="{{ route('login') }}" class="text-decoration-none fw-semibold" style="color:#f97316">Sign in</a>
        </p>
    </form>
</x-guest-layout>
