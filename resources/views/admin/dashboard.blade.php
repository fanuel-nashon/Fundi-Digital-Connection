@extends('layouts.admin')
@section('title','Dashboard')
@section('page-title','Dashboard Overview')

@section('content')
{{-- Stat cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat stat-orange d-flex align-items-center justify-content-between">
            <div><div class="num">{{ $stats['total'] }}</div><div class="lbl">Total Users</div></div>
            <i class="bi bi-people-fill ico"></i>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat stat-blue d-flex align-items-center justify-content-between">
            <div><div class="num">{{ $stats['tradespeople'] }}</div><div class="lbl">Tradespeople</div></div>
            <i class="bi bi-tools ico"></i>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat stat-green d-flex align-items-center justify-content-between">
            <div><div class="num">{{ $stats['customers'] }}</div><div class="lbl">Customers</div></div>
            <i class="bi bi-person-check-fill ico"></i>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat stat-cyan d-flex align-items-center justify-content-between">
            <div><div class="num">{{ $stats['pending_jobs'] }}</div><div class="lbl">Pending Jobs</div></div>
            <i class="bi bi-hourglass-split ico"></i>
        </div>
    </div>
    @if($stats['pending_accounts'] > 0)
    <div class="col-12">
        <a href="{{ route('admin.registrations.index') }}" class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none"
           style="background:#fffbeb;border:1px solid #fde68a">
            <i class="bi bi-person-exclamation fs-4 text-warning"></i>
            <div>
                <div class="fw-semibold text-dark">{{ $stats['pending_accounts'] }} account{{ $stats['pending_accounts'] > 1 ? 's' : '' }} awaiting approval</div>
                <div class="text-muted small">Click to review and approve registrations</div>
            </div>
            <i class="bi bi-arrow-right ms-auto text-warning"></i>
        </a>
    </div>
    @endif
</div>

{{-- Recent users --}}
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span><i class="bi bi-clock-history me-2 text-muted"></i>Recent Users</span>
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-brand">
            <i class="bi bi-plus-lg me-1"></i>Add User
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr><th>Name</th><th>Email</th><th>Role</th><th>Location</th><th>Joined</th></tr>
            </thead>
            <tbody>
                @foreach($recentUsers as $u)
                <tr>
                    <td class="fw-medium">{{ $u->name }}</td>
                    <td class="text-muted small">{{ $u->email }}</td>
                    <td>
                        <span class="badge badge-role-{{ $u->role }} text-capitalize">{{ $u->role }}</span>
                    </td>
                    <td class="text-muted small">{{ $u->location ?? '—' }}</td>
                    <td class="text-muted small">{{ $u->created_at->format('M d, Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white text-center">
        <a href="{{ route('admin.users.index') }}" class="text-decoration-none small" style="color:#f97316">
            View all {{ $stats['total'] }} users →
        </a>
    </div>
</div>
@endsection
