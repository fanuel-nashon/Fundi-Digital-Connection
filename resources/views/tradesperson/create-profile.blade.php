@extends('layouts.tradesperson')
@section('title','Create Profile')

@section('content')
<div class="page-header d-flex align-items-start justify-content-between">
    <div><h4>Create Your Profile</h4><p>Customers will see this information</p></div>
    <a href="{{ route('tradesperson.tradesperson-dashboard') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Dashboard
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header"><i class="bi bi-person-badge me-2 text-muted"></i>Profile Details</div>
            <div class="card-body p-4">
                <form action="{{ route('tradesperson.store-profile') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-medium">Trade Category</label>
                        <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                            <option value="">— Select Category —</option>
                            @foreach(['plumbing','electrical','carpentry','welding','masonry'] as $cat)
                                <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                            @endforeach
                        </select>
                        @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Bio</label>
                        <textarea name="bio" rows="4" class="form-control @error('bio') is-invalid @enderror"
                                  placeholder="Describe your skills, experience and what makes you stand out..." required>{{ old('bio') }}</textarea>
                        @error('bio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-medium">Availability Status</label>
                        <select name="availability_status" class="form-select @error('availability_status') is-invalid @enderror" required>
                            <option value="available"   {{ old('availability_status','available') === 'available'   ? 'selected' : '' }}>Available</option>
                            <option value="unavailable" {{ old('availability_status') === 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                        </select>
                        @error('availability_status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-brand px-4"><i class="bi bi-check-lg me-1"></i>Save Profile</button>
                        <a href="{{ route('tradesperson.tradesperson-dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
