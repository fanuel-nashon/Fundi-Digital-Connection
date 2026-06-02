@extends('layouts.tradesperson')
@section('title', 'Notifications')

@section('content')
<div class="page-header d-flex align-items-start justify-content-between">
    <div><h4>Notifications</h4><p>Overdue job alerts and system messages</p></div>
    <div class="d-flex gap-2">
        <form method="POST" action="{{ route('tradesperson.notifications.read-all') }}">
            @csrf @method('PATCH')
            <button class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-check-all me-1"></i>Mark all read
            </button>
        </form>
        <a href="{{ route('tradesperson.tradesperson-dashboard') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Dashboard
        </a>
    </div>
</div>

@if($notifications->isEmpty())
    <div class="card text-center py-5">
        <div class="card-body">
            <i class="bi bi-bell-slash fs-1 text-muted d-block mb-3"></i>
            <h5 class="fw-semibold">All caught up</h5>
            <p class="text-muted mb-0">You have no notifications.</p>
        </div>
    </div>
@else
    @foreach($notifications as $notification)
    <div class="card mb-2 {{ is_null($notification->read_at) ? 'border-start border-danger border-3' : '' }}">
        <div class="card-body py-3 d-flex align-items-start gap-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0
                        {{ is_null($notification->read_at) ? 'bg-danger' : 'bg-secondary' }} bg-opacity-10"
                 style="width:38px;height:38px">
                <i class="bi bi-exclamation-triangle {{ is_null($notification->read_at) ? 'text-danger' : 'text-secondary' }}"></i>
            </div>
            <div class="flex-grow-1">
                <p class="mb-1 small fw-medium" style="color:#1e293b">{{ $notification->data['message'] }}</p>
                <span class="text-muted" style="font-size:.75rem">
                    <i class="bi bi-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                </span>
            </div>
            @if(is_null($notification->read_at))
                <span class="badge bg-danger" style="font-size:.65rem">New</span>
            @endif
        </div>
    </div>
    @endforeach

    <div class="mt-3">{{ $notifications->links() }}</div>
@endif
@endsection
