@extends('layouts.customer')

@section('title', $profile->user->name)

@section('content')
<a href="{{ route('customer.dashboard') }}" class="btn btn-sm btn-outline-secondary mb-4">
    &larr; Back to list
</a>

<div class="row g-4">
    {{-- Profile Card --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center py-4">
                <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3"
                     style="width:72px;height:72px">
                    <i class="bi bi-person-fill fs-2 text-primary"></i>
                </div>
                <h5 class="fw-bold mb-0">{{ $profile->user->name }}</h5>
                <small class="text-muted">{{ $profile->user->location ?? 'Location not set' }}</small>

                <div class="my-3">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="bi bi-star{{ $i <= round($profile->avg_rating) ? '-fill' : '' }}"
                           style="color:{{ $i <= round($profile->avg_rating) ? '#f59e0b' : '#d1d5db' }};font-size:1.1rem"></i>
                    @endfor
                    <div class="text-muted small mt-1">{{ $profile->avg_rating > 0 ? $profile->avg_rating . ' / 5' : 'No ratings yet' }}</div>
                </div>

                <span class="badge bg-primary bg-opacity-10 text-primary">{{ ucfirst($profile->category) }}</span>
                <span class="badge bg-{{ $profile->availability_status === 'available' ? 'success' : 'secondary' }} ms-1">
                    {{ ucfirst($profile->availability_status) }}
                </span>

                <div class="mt-3 text-muted small">{{ $profile->reviews }} review{{ $profile->reviews !== 1 ? 's' : '' }}</div>
            </div>
            <div class="card-footer bg-white">
                @if($profile->availability_status === 'available')
                    <a href="{{ route('customer.request.create', $profile->user_id) }}" class="btn btn-primary w-100">
                        <i class="bi bi-send me-1"></i> Request Service
                    </a>
                @else
                    <button class="btn btn-secondary w-100" disabled>Currently Unavailable</button>
                @endif
            </div>
        </div>
    </div>

    {{-- Bio & Reviews --}}
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white fw-semibold">About</div>
            <div class="card-body">
                <p class="mb-0">{{ $profile->bio }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white fw-semibold">Recent Reviews</div>
            <div class="card-body">
                @forelse($recentReviews as $review)
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="fw-medium small">{{ $review->customer_name }}</span>
                            <div>
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"
                                       style="color:{{ $i <= $review->rating ? '#f59e0b' : '#d1d5db' }};font-size:0.8rem"></i>
                                @endfor
                            </div>
                        </div>
                        <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                        @if($review->comment)
                            <p class="small text-muted mt-1 mb-0">{{ $review->comment }}</p>
                        @endif
                    </div>
                @empty
                    <p class="text-muted mb-0 small">No reviews yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
