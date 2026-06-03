@extends('layouts.admin')
@section('title', 'Pending Registrations')
@section('page-title', 'Pending Registrations')

@section('content')
@if($pending->isEmpty())
    <div class="card text-center py-5">
        <div class="card-body">
            <i class="bi bi-person-check fs-1 text-muted d-block mb-3"></i>
            <h5 class="fw-semibold">All clear</h5>
            <p class="text-muted mb-0">No pending registrations at the moment.</p>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <span><i class="bi bi-hourglass-split me-2 text-warning"></i>Awaiting Approval
                <span class="badge bg-warning text-dark ms-1">{{ $pending->count() }}</span>
            </span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr><th>Name</th><th>Email</th><th>Role</th><th>Location</th><th>Details</th><th>Applied</th><th class="text-end">Actions</th></tr>
                </thead>
                <tbody>
                    @foreach($pending as $user)
                    <tr>
                        <td class="fw-medium">{{ $user->name }}</td>
                        <td class="text-muted small">{{ $user->email }}</td>
                        <td><span class="badge badge-role-{{ $user->role }}">{{ ucfirst($user->role) }}</span></td>
                        <td class="text-muted small">{{ $user->location ?? '—' }}</td>
                        <td class="small text-muted">
                            @if($user->tradespersonProfile)
                                <span class="badge bg-light text-dark border">{{ ucfirst($user->tradespersonProfile->category) }}</span>
                                <div class="mt-1" style="max-width:220px">{{ Str::limit($user->tradespersonProfile->bio, 60) }}</div>
                            @else
                                Customer
                            @endif
                        </td>
                        <td class="text-muted small">{{ $user->created_at->diffForHumans() }}</td>
                        <td class="text-end">
                            <form method="POST" action="{{ route('admin.registrations.approve', $user->id) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-success me-1">
                                    <i class="bi bi-check-lg me-1"></i>Approve
                                </button>
                            </form>

                            <button class="btn btn-sm btn-outline-danger"
                                    onclick="showRejectModal({{ $user->id }}, '{{ addslashes($user->name) }}')">
                                <i class="bi bi-x-lg me-1"></i>Reject
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

{{-- Reject modal --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:12px;border:none">
            <form method="POST" id="reject-form">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-bold">Reject Registration</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small mb-3">Rejecting <strong id="reject-name"></strong>. An email will be sent to notify them.</p>
                    <label class="form-label fw-medium">Reason <span class="text-muted fw-normal">(optional)</span></label>
                    <textarea name="reason" rows="3" class="form-control"
                              placeholder="e.g. Incomplete information, unable to verify credentials..."></textarea>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Send Rejection</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function showRejectModal(id, name) {
    document.getElementById('reject-name').textContent = name;
    document.getElementById('reject-form').action = `/admin/registrations/${id}/reject`;
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}
</script>
@endsection
