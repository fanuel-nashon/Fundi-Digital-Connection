@extends('layouts.customer')
@section('title', 'My Requests')

@section('content')
<div class="page-header d-flex align-items-start justify-content-between">
    <div>
        <h4 class="fw-bold mb-1">My Requests</h4>
        <p class="text-muted small mb-0">Track all your service requests and ongoing jobs</p>
    </div>
    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-plus-lg me-1"></i>Find Tradesperson
    </a>
</div>

@if($requests->isEmpty())
    <div class="card text-center py-5">
        <div class="card-body">
            <i class="bi bi-briefcase fs-1 text-muted d-block mb-3"></i>
            <h5 class="fw-semibold">No requests yet</h5>
            <p class="text-muted mb-4">You haven't requested any services yet. Browse tradespeople to get started.</p>
            <a href="{{ route('home') }}" class="btn btn-brand px-4">
                <i class="bi bi-search me-1"></i>Browse Tradespeople
            </a>
        </div>
    </div>
@else
    {{-- Active jobs (pending / accepted / in_progress) --}}
    @php $active = $requests->whereIn('status', ['pending', 'accepted', 'in_progress']); @endphp
    @if($active->count())
    <h6 class="text-uppercase fw-bold text-muted mb-3" style="font-size:.7rem;letter-spacing:.08em">
        Active <span class="badge bg-primary ms-1">{{ $active->count() }}</span>
    </h6>

    @foreach($active as $job)
    @php
        $borderColor = match($job->status) {
            'accepted'    => '#2563eb',
            'in_progress' => '#0891b2',
            default       => '#f59e0b',
        };
    @endphp
    <div class="card mb-3" style="border-left:3px solid {{ $borderColor }}">
        <div class="card-body">
            <div class="d-flex align-items-start justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white"
                         style="width:42px;height:42px;background:#0891b2;flex-shrink:0">
                        {{ strtoupper(substr($job->tradesperson->name ?? '?', 0, 1)) }}
                    </div>
                    <div>
                        <div class="fw-semibold">{{ $job->tradesperson->name ?? '—' }}</div>
                        <div class="text-muted small">
                            {{ ucfirst($job->tradesperson->tradespersonProfile->category ?? '') }}
                            &middot; Scheduled: {{ $job->scheduled_date->format('M d, Y') }}
                            @if($job->deadline)
                                &middot; <span class="{{ $job->isOverdue() ? 'text-danger fw-semibold' : '' }}">
                                    Deadline: {{ $job->deadline->format('M d, Y') }}
                                </span>
                            @endif
                        </div>
                        @if($job->isOverdue())
                            <span class="badge bg-danger mt-1"><i class="bi bi-exclamation-triangle me-1"></i>OVERDUE</span>
                        @endif
                        @if($job->status === 'in_progress' || $job->progress > 0)
                            <div class="mt-2">
                                <div class="d-flex justify-content-between small mb-1">
                                    <span class="text-muted">Work progress</span>
                                    <span class="fw-semibold" style="color:#2563eb">{{ $job->progress }}%</span>
                                </div>
                                <div class="progress" style="height:8px;border-radius:4px;background:#e2e8f0">
                                    <div class="progress-bar"
                                         style="width:{{ $job->progress }}%;background:linear-gradient(90deg,#2563eb,#0891b2);border-radius:4px;transition:width .4s ease">
                                    </div>
                                </div>
                            </div>
                        @endif
                        <p class="mb-0 mt-1 small text-muted">{{ Str::limit($job->description, 80) }}</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end gap-2">
                    @php
                        $badgeMap = [
                            'pending'     => ['warning',  'clock',           'Awaiting Response'],
                            'accepted'    => ['primary',  'check-circle',    'Accepted'],
                            'in_progress' => ['info',     'arrow-repeat',    'In Progress'],
                        ];
                        [$color, $icon, $label] = $badgeMap[$job->status];
                    @endphp
                    <span class="badge bg-{{ $color }} bg-opacity-10 text-{{ $color }} border border-{{ $color }} border-opacity-25">
                        <i class="bi bi-{{ $icon }} me-1"></i>{{ $label }}
                    </span>
                    <a href="{{ route('customer.messages.index', $job->id) }}"
                       class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-chat-dots me-1"></i>View Messages
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endif

    {{-- Completed / needs review --}}
    @php $complete = $requests->where('status', 'complete'); @endphp
    @if($complete->count())
    <h6 class="text-uppercase fw-bold text-muted mb-3 mt-4" style="font-size:.7rem;letter-spacing:.08em">
        Awaiting Review <span class="badge bg-warning text-dark ms-1">{{ $complete->count() }}</span>
    </h6>

    @foreach($complete as $job)
    <div class="card mb-3" style="border-left:3px solid #f59e0b">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <div class="fw-semibold">{{ $job->tradesperson->name ?? '—' }}</div>
                <div class="text-muted small">
                    {{ ucfirst($job->tradesperson->tradespersonProfile->category ?? '') }}
                    &middot; {{ $job->scheduled_date->format('M d, Y') }}
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('customer.messages.index', $job->id) }}"
                   class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-chat-dots me-1"></i>Messages
                </a>
                <a href="{{ route('customer.review.create', $job->id) }}"
                   class="btn btn-sm btn-warning">
                    <i class="bi bi-star me-1"></i>Leave Review
                </a>
            </div>
        </div>
    </div>
    @endforeach
    @endif

    {{-- History --}}
    @php $history = $requests->whereIn('status', ['reviewed', 'declined']); @endphp
    @if($history->count())
    <h6 class="text-uppercase fw-bold text-muted mb-3 mt-4" style="font-size:.7rem;letter-spacing:.08em">History</h6>

    @foreach($history as $job)
    <div class="card mb-2" style="opacity:.75">
        <div class="card-body py-2 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <span class="fw-medium small">{{ $job->tradesperson->name ?? '—' }}</span>
                <span class="text-muted small ms-2">
                    · {{ ucfirst($job->tradesperson->tradespersonProfile->category ?? '') }}
                    · {{ $job->scheduled_date->format('M d, Y') }}
                </span>
            </div>
            <div class="d-flex align-items-center gap-2">
                @if($job->status === 'reviewed' && $job->review)
                    <span class="text-warning small">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ $i <= $job->review->rating ? '-fill' : '' }}"></i>
                        @endfor
                    </span>
                @endif
                <span class="badge bg-{{ $job->status === 'reviewed' ? 'success' : 'danger' }} bg-opacity-10
                             text-{{ $job->status === 'reviewed' ? 'success' : 'danger' }}">
                    {{ ucfirst($job->status) }}
                </span>
                <a href="{{ route('customer.messages.index', $job->id) }}"
                   class="btn btn-sm btn-outline-secondary py-0 px-2" style="font-size:.75rem">
                    <i class="bi bi-chat-dots"></i>
                </a>
            </div>
        </div>
    </div>
    @endforeach
    @endif
@endif
@endsection
