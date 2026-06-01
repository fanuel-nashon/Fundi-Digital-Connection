@extends('layouts.tradesperson')
@section('title','Dashboard')

@section('content')
<div class="page-header">
    <h4>Welcome back, {{ auth()->user()->name }}</h4>
    <p>Manage your jobs and profile from here</p>
</div>

@php
    $pending  = \App\Models\JobRequest::where('tradesperson_id', auth()->id())->where('status','pending')->count();
    $accepted = \App\Models\JobRequest::where('tradesperson_id', auth()->id())->where('status','accepted')->count();
    $total    = \App\Models\JobRequest::where('tradesperson_id', auth()->id())->count();
    $hasProfile = \App\Models\TradespersonProfile::where('user_id', auth()->id())->exists();
@endphp

<div class="row g-3 mb-4">
    <div class="col-6 col-md-4">
        <div class="card text-center p-3">
            <div class="fw-bold fs-3 text-warning">{{ $pending }}</div>
            <div class="text-muted small">Pending Requests</div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="card text-center p-3">
            <div class="fw-bold fs-3" style="color:#0891b2">{{ $accepted }}</div>
            <div class="text-muted small">Active Jobs</div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="card text-center p-3">
            <div class="fw-bold fs-3 text-success">{{ $total }}</div>
            <div class="text-muted small">Total Jobs</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <a href="{{ route('tradesperson.job-requests.index') }}" class="card text-decoration-none p-4 d-flex flex-row align-items-center gap-3">
            <div class="rounded-3 d-flex align-items-center justify-content-center"
                 style="width:52px;height:52px;background:#eff6ff;flex-shrink:0">
                <i class="bi bi-briefcase-fill fs-4" style="color:#2563eb"></i>
            </div>
            <div>
                <div class="fw-semibold text-dark">Job Requests</div>
                <div class="text-muted small">View and manage incoming requests</div>
            </div>
            @if($pending)<span class="badge bg-warning text-dark ms-auto">{{ $pending }} new</span>@endif
        </a>
    </div>
    <div class="col-md-6">
        @if($hasProfile)
            <a href="{{ route('tradesperson.tradesperson-profile', auth()->id()) }}" class="card text-decoration-none p-4 d-flex flex-row align-items-center gap-3">
        @else
            <a href="{{ route('tradesperson.create-profile') }}" class="card text-decoration-none p-4 d-flex flex-row align-items-center gap-3">
        @endif
            <div class="rounded-3 d-flex align-items-center justify-content-center"
                 style="width:52px;height:52px;background:#f0fdf4;flex-shrink:0">
                <i class="bi bi-person-badge-fill fs-4 text-success"></i>
            </div>
            <div>
                <div class="fw-semibold text-dark">{{ $hasProfile ? 'My Profile' : 'Create Profile' }}</div>
                <div class="text-muted small">{{ $hasProfile ? 'View and update your profile' : 'Set up your tradesperson profile' }}</div>
            </div>
        </a>
    </div>
</div>
@endsection
