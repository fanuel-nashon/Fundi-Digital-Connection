@extends('layouts.customer')

@section('title', 'Find a Tradesperson')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold mb-1">Find a Tradesperson</h4>
    <p class="text-muted small mb-3">Browse and filter professionals in your area</p>

    <form method="GET" action="{{ route('customer.dashboard') }}" class="card p-3">
        <div class="row g-2 align-items-end">
            <div class="col-sm-6 col-lg-3">
                <label class="form-label small fw-medium mb-1">Category</label>
                <select name="category" class="form-select form-select-sm">
                    <option value="">All Categories</option>
                    @foreach(['plumbing','electrical','carpentry','welding','masonry'] as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>
                            {{ ucfirst($cat) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-6 col-lg-3">
                <label class="form-label small fw-medium mb-1">Availability</label>
                <select name="availability" class="form-select form-select-sm">
                    <option value="">Any</option>
                    <option value="available"   {{ request('availability') === 'available'   ? 'selected' : '' }}>Available</option>
                    <option value="unavailable" {{ request('availability') === 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                </select>
            </div>
            <div class="col-sm-6 col-lg-2">
                <label class="form-label small fw-medium mb-1">Min Rating</label>
                <select name="min_rating" class="form-select form-select-sm">
                    <option value="">Any</option>
                    @foreach([4,3,2,1] as $r)
                        <option value="{{ $r }}" {{ request('min_rating') == $r ? 'selected' : '' }}>{{ $r }}+ ★</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-6 col-lg-3">
                <label class="form-label small fw-medium mb-1">Location</label>
                <input type="text" name="location" class="form-control form-control-sm"
                       placeholder="e.g. Dar es Salaam" value="{{ request('location') }}">
            </div>
            <div class="col-lg-1 d-flex gap-1">
                <button type="submit" class="btn btn-primary btn-sm w-100">Filter</button>
                @if(request()->hasAny(['category','availability','min_rating','location']))
                    <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary btn-sm">✕</a>
                @endif
            </div>
        </div>
    </form>
</div>

@if($tradespersons->isEmpty())
    <div class="text-center py-5 text-muted">
        <i class="bi bi-people fs-1"></i>
        <p class="mt-2">No tradespersons available at the moment.</p>
    </div>
@else
    <div class="row g-4">
        @foreach($tradespersons as $profile)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-start justify-content-between mb-2">
                        <div>
                            <h6 class="fw-bold mb-0">{{ $profile->user->name }}</h6>
                            <small class="text-muted">{{ $profile->user->location ?? 'Location not set' }}</small>
                        </div>
                        <span class="badge bg-{{ $profile->availability_status === 'available' ? 'success' : 'secondary' }} ms-2">
                            {{ ucfirst($profile->availability_status) }}
                        </span>
                    </div>

                    <span class="badge bg-primary bg-opacity-10 text-primary badge-category mb-2 align-self-start">
                        {{ ucfirst($profile->category) }}
                    </span>

                    <p class="text-muted small flex-grow-1" style="overflow:hidden;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical">
                        {{ $profile->bio }}
                    </p>

                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <div>
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= round($profile->avg_rating) ? '-fill star-filled' : ' star-empty' }}" style="font-size:0.85rem"></i>
                            @endfor
                            <span class="text-muted small ms-1">{{ $profile->avg_rating > 0 ? $profile->avg_rating : 'No ratings' }}</span>
                        </div>
                        <small class="text-muted">{{ $profile->reviews }} review{{ $profile->reviews !== 1 ? 's' : '' }}</small>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <a href="{{ route('customer.tradesperson.show', $profile->user_id) }}" class="btn btn-primary btn-sm w-100">
                        View Profile
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection
