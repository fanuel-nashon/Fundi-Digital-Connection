@extends('layouts.admin')
@section('title','Create User')
@section('page-title','Create New User')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Back to Users
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header"><i class="bi bi-person-plus me-2 text-muted"></i>User Details</div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-medium">Full Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" placeholder="Jane Doe" required autofocus>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Email Address</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" placeholder="jane@example.com" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Password</label>
                            <div class="input-group">
                                <input type="password" id="pw1" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="••••••••" required oninput="checkStrength('pw1')">
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePwd('pw1',this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mt-1">
                                <div class="bg-light rounded" style="height:4px">
                                    <div id="str-bar" class="strength-bar" style="width:0"></div>
                                </div>
                                <span id="str-txt" class="small text-muted"></span>
                            </div>
                            <div class="text-muted" style="font-size:.72rem;margin-top:.2rem">
                                Min 8 chars · uppercase · number · symbol
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" id="pw2" name="password_confirmation"
                                       class="form-control" placeholder="••••••••" required>
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePwd('pw2',this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Role</label>
                            <select name="roles[]" class="form-select @error('roles') is-invalid @enderror" required>
                                <option value="">— Select Role —</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ old('roles.0') == $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('roles')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Location <span class="text-muted fw-normal">(optional)</span></label>
                            <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                                   value="{{ old('location') }}" placeholder="e.g. Dar es Salaam">
                            @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-brand px-4">
                            <i class="bi bi-person-check me-1"></i>Create User
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function checkStrength(id) {
    const v = document.getElementById(id).value;
    let s = 0;
    if (v.length >= 8) s++; if (/[A-Z]/.test(v)) s++; if (/[0-9]/.test(v)) s++; if (/[^A-Za-z0-9]/.test(v)) s++;
    const map=[['0','secondary',''],['25%','danger','Weak'],['50%','warning','Fair'],['75%','info','Good'],['100%','success','Strong ✓']];
    const bar=document.getElementById('str-bar'), txt=document.getElementById('str-txt');
    bar.style.width=map[s][0]; bar.className=`strength-bar bg-${map[s][1]}`;
    txt.textContent=map[s][2]; txt.className=`small text-${map[s][1]}`;
}
</script>
@endsection
