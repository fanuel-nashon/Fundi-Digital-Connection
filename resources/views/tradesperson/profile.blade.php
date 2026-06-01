@extends('layouts.tradesperson')
@section('title','My Profile')

@section('content')
<div class="page-header d-flex align-items-start justify-content-between">
    <div>
        <h4>My Profile</h4>
        <p>Your public tradesperson profile</p>
    </div>
    <a href="{{ route('tradesperson.tradesperson-dashboard') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Dashboard
    </a>
</div>

@if($profile)
<div class="row g-4">
    <div class="col-md-4">
        <div class="card text-center p-4">
            <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center fw-bold text-white fs-3"
                 style="width:72px;height:72px;background:#0891b2">
                {{ strtoupper(substr(auth()->user()->name,0,1)) }}
            </div>
            <div class="fw-bold fs-5">{{ auth()->user()->name }}</div>
            <div class="text-muted small mb-2">{{ auth()->user()->location ?? 'Location not set' }}</div>
            <span class="badge" style="background:#e0f2fe;color:#0891b2">{{ ucfirst($profile->category) }}</span>
            <span class="badge ms-1 bg-{{ $profile->availability_status === 'available' ? 'success' : 'secondary' }}">
                {{ ucfirst($profile->availability_status) }}
            </span>
            <div class="text-muted small mt-3">{{ $profile->reviews }} review{{ $profile->reviews !== 1 ? 's' : '' }}</div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header">About You</div>
            <div class="card-body"><p class="mb-0">{{ $profile->bio }}</p></div>
        </div>
    </div>
</div>
@else
<div class="card">
    <div class="card-body text-center py-5">
        <i class="bi bi-person-badge fs-1 text-muted d-block mb-3"></i>
        <h5 class="fw-semibold">No profile yet</h5>
        <p class="text-muted mb-4">Create your profile so customers can find and hire you.</p>
        <a href="{{ route('tradesperson.create-profile') }}" class="btn btn-brand px-4">
            <i class="bi bi-plus-lg me-1"></i>Create Profile
        </a>
    </div>
</div>
@endif
@endsection
