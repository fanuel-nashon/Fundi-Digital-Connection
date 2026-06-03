@extends('layouts.tradesperson')
@section('title', 'Job Requests')

@section('content')
<div class="page-header d-flex align-items-start justify-content-between">
    <div>
        <h4>Job Requests</h4>
        <p>Accept, track progress, and manage your service jobs</p>
    </div>
    <a href="{{ route('tradesperson.tradesperson-dashboard') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Dashboard
    </a>
</div>

{{-- ── Pending ── --}}
<h6 class="section-label">
    Pending <span class="badge badge-pending ms-1">{{ $jobRequests->where('status','pending')->count() }}</span>
</h6>

@forelse($jobRequests->where('status','pending') as $job)
<div class="card mb-3 {{ $job->isOverdue() ? 'border-danger border-2' : '' }}">
    @if($job->isOverdue())
        <div class="px-3 pt-2 pb-0">
            <span class="badge bg-danger"><i class="bi bi-exclamation-triangle me-1"></i>OVERDUE — deadline was {{ $job->deadline->format('M d, Y') }}</span>
        </div>
    @endif
    <div class="card-body">
        <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap">
            <div class="d-flex align-items-center gap-3">
                <div class="avatar-circle bg-primary">{{ strtoupper(substr($job->customer->name,0,1)) }}</div>
                <div>
                    <div class="fw-semibold">{{ $job->customer->name }}</div>
                    <div class="text-muted small">
                        {{ $job->customer->location ?? '' }}
                        · Scheduled: {{ $job->scheduled_date->format('M d, Y') }}
                        @if($job->deadline)
                            · <span class="{{ $job->isOverdue() ? 'text-danger fw-semibold' : 'text-muted' }}">
                                Deadline: {{ $job->deadline->format('M d, Y') }}
                              </span>
                        @endif
                    </div>
                    <p class="mb-0 mt-1 small text-muted">{{ $job->description }}</p>
                </div>
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
<div class="card mb-4"><div class="card-body text-center text-muted py-4"><i class="bi bi-inbox fs-2 d-block mb-2"></i>No pending requests</div></div>
@endforelse

{{-- ── Active (accepted / in_progress) ── --}}
<h6 class="section-label mt-4">
    Active <span class="badge badge-accepted ms-1">{{ $jobRequests->whereIn('status',['accepted','in_progress'])->count() }}</span>
</h6>

@forelse($jobRequests->whereIn('status',['accepted','in_progress']) as $job)
<div class="card mb-3 {{ $job->isOverdue() ? 'border-danger border-2' : 'border-start border-primary border-3' }}">
    @if($job->isOverdue())
        <div class="px-3 pt-2 pb-0">
            <span class="badge bg-danger"><i class="bi bi-exclamation-triangle me-1"></i>OVERDUE — deadline was {{ $job->deadline->format('M d, Y') }}</span>
        </div>
    @endif
    <div class="card-body">
        <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap">
            <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <div class="avatar-circle bg-info">{{ strtoupper(substr($job->customer->name,0,1)) }}</div>
                    <div>
                        <div class="fw-semibold">{{ $job->customer->name }}</div>
                        <div class="text-muted small">
                            Scheduled: {{ $job->scheduled_date->format('M d, Y') }}
                            @if($job->deadline)
                                · <span class="{{ $job->isOverdue() ? 'text-danger fw-semibold' : '' }}">
                                    Deadline: {{ $job->deadline->format('M d, Y') }}
                                  </span>
                            @endif
                        </div>
                    </div>
                </div>
                <p class="small text-muted mb-3">{{ Str::limit($job->description, 100) }}</p>

                {{-- Progress bar --}}
                <div class="mb-1 d-flex align-items-center justify-content-between">
                    <span class="small fw-medium text-muted">Progress</span>
                    <span class="small fw-bold" style="color:#0891b2">{{ $job->progress }}%</span>
                </div>
                <div class="progress mb-3" style="height:8px;border-radius:4px">
                    <div class="progress-bar" role="progressbar"
                         style="width:{{ $job->progress }}%;background:#0891b2"
                         aria-valuenow="{{ $job->progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                {{-- Update progress form --}}
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <form method="POST" action="{{ route('tradesperson.job-requests.progress', $job->id) }}"
                          class="d-flex align-items-center gap-2">
                        @csrf @method('PATCH')
                        <select name="progress" class="form-select form-select-sm" style="max-width:200px">
                            @foreach([0 => 'Not Started', 25 => 'Started (25%)', 50 => 'Halfway (50%)', 75 => 'Almost Done (75%)', 100 => 'Done — Mark Complete'] as $val => $label)
                                <option value="{{ $val }}" {{ $job->progress == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-sm btn-brand">Update</button>
                    </form>
                    <a href="{{ route('tradesperson.messages.index', $job->id) }}"
                       class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-chat-dots me-1"></i>Messages
                        @if($job->messages->count() > 0)
                            <span class="badge bg-primary bg-opacity-25 text-primary ms-1" style="font-size:.65rem">
                                {{ $job->messages->count() }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@empty
<p class="text-muted small mb-4">No active jobs.</p>
@endforelse

{{-- ── History ── --}}
<h6 class="section-label mt-4">History</h6>

@forelse($jobRequests->whereIn('status',['complete','reviewed','declined']) as $job)
<div class="card mb-2" style="opacity:.75">
    <div class="card-body py-2 d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <span class="fw-medium small">{{ $job->customer->name }}</span>
            <span class="text-muted small ms-2">· {{ $job->scheduled_date->format('M d, Y') }}</span>
            <span class="text-muted small ms-2">· {{ Str::limit($job->description,40) }}</span>
        </div>
        <div class="d-flex align-items-center gap-2">
            @if(in_array($job->status, ['complete','reviewed']))
                <div class="progress" style="width:60px;height:6px;border-radius:3px">
                    <div class="progress-bar bg-success" style="width:{{ $job->progress }}%"></div>
                </div>
            @endif
            <span class="badge badge-{{ $job->status }}">{{ ucfirst($job->status) }}</span>
        </div>
    </div>
</div>
@empty
<p class="text-muted small">No history yet.</p>
@endforelse

@push('styles')
<style>
.section-label { text-transform:uppercase; color:#94a3b8; font-weight:700; font-size:.7rem; letter-spacing:.08em; margin-bottom:.75rem; }
.avatar-circle { width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:.8rem; flex-shrink:0; }
</style>
@endpush
@endsection
