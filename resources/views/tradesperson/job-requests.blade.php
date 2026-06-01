@extends('layouts.tradesperson')
@section('title','Job Requests')

@section('content')
<div class="page-header d-flex align-items-start justify-content-between">
    <div>
        <h4>Job Requests</h4>
        <p>Accept or decline service requests from customers</p>
    </div>
    <a href="{{ route('tradesperson.tradesperson-dashboard') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Dashboard
    </a>
</div>

{{-- Pending --}}
<h6 class="text-uppercase text-muted fw-bold mb-3" style="font-size:.7rem;letter-spacing:.08em">
    Pending <span class="badge badge-pending ms-1">{{ $jobRequests->where('status','pending')->count() }}</span>
</h6>

@forelse($jobRequests->where('status','pending') as $job)
<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex flex-column flex-md-row align-items-start justify-content-between gap-3">
            <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center fw-bold text-primary"
                         style="width:34px;height:34px;font-size:.8rem;flex-shrink:0">
                        {{ strtoupper(substr($job->customer->name,0,1)) }}
                    </div>
                    <div>
                        <div class="fw-semibold">{{ $job->customer->name }}</div>
                        <div class="text-muted" style="font-size:.75rem">{{ $job->customer->location ?? '' }} · Scheduled: {{ $job->scheduled_date->format('M d, Y') }}</div>
                    </div>
                </div>
                <p class="mb-0 mt-2 text-muted small">{{ $job->description }}</p>
            </div>
            <div class="d-flex gap-2 flex-shrink-0">
                <form method="POST" action="{{ route('tradesperson.job-requests.accept', $job->id) }}">
                    @csrf @method('PATCH')
                    <button class="btn btn-success btn-sm px-3"><i class="bi bi-check-lg me-1"></i>Accept</button>
                </form>
                <form method="POST" action="{{ route('tradesperson.job-requests.decline', $job->id) }}">
                    @csrf @method('PATCH')
                    <button class="btn btn-outline-danger btn-sm px-3"><i class="bi bi-x-lg me-1"></i>Decline</button>
                </form>
            </div>
        </div>
    </div>
</div>
@empty
<div class="card mb-4">
    <div class="card-body text-center text-muted py-4">
        <i class="bi bi-inbox fs-2 d-block mb-2"></i>No pending requests
    </div>
</div>
@endforelse

{{-- Active --}}
<h6 class="text-uppercase text-muted fw-bold mb-3 mt-4" style="font-size:.7rem;letter-spacing:.08em">
    Active <span class="badge badge-accepted ms-1">{{ $jobRequests->where('status','accepted')->count() }}</span>
</h6>

@forelse($jobRequests->where('status','accepted') as $job)
<div class="card mb-3" style="border-left:3px solid #2563eb">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <div class="fw-semibold">{{ $job->customer->name }}</div>
                <div class="text-muted small">Scheduled: {{ $job->scheduled_date->format('M d, Y') }}</div>
                <p class="mb-0 mt-1 text-muted small">{{ Str::limit($job->description, 80) }}</p>
            </div>
            <span class="badge badge-accepted">Accepted</span>
        </div>
    </div>
</div>
@empty
<p class="text-muted small mb-4">No active jobs.</p>
@endforelse

{{-- History --}}
<h6 class="text-uppercase text-muted fw-bold mb-3 mt-4" style="font-size:.7rem;letter-spacing:.08em">History</h6>

@forelse($jobRequests->whereIn('status',['complete','reviewed','declined']) as $job)
<div class="card mb-2" style="opacity:.75">
    <div class="card-body py-2 d-flex align-items-center justify-content-between">
        <div>
            <span class="fw-medium small">{{ $job->customer->name }}</span>
            <span class="text-muted small ms-2">· {{ $job->scheduled_date->format('M d, Y') }}</span>
            <span class="text-muted small ms-2">· {{ Str::limit($job->description,40) }}</span>
        </div>
        <span class="badge badge-{{ $job->status }}">{{ ucfirst($job->status) }}</span>
    </div>
</div>
@empty
<p class="text-muted small">No history yet.</p>
@endforelse
@endsection
