@extends('layouts.customer')

@section('title', 'Leave a Review')

@section('styles')
<style>
    .star-rating { display:flex; flex-direction:row-reverse; justify-content:flex-end; gap:4px; }
    .star-rating input { display:none; }
    .star-rating label { font-size:2.5rem; color:#d1d5db; cursor:pointer; transition:color 0.15s; }
    .star-rating label:hover,
    .star-rating label:hover ~ label,
    .star-rating input:checked ~ label { color:#f59e0b; }
</style>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header bg-white fw-semibold">Rate Your Experience</div>
            <div class="card-body text-center">

                <div class="mb-3">
                    <div class="fw-semibold">{{ $jobRequest->tradesperson->name }}</div>
                    <small class="text-muted">
                        {{ ucfirst($jobRequest->tradesperson->tradespersonProfile->category ?? '') }}
                    </small>
                </div>

                <p class="text-muted small mb-4">How would you rate the service provided?</p>

                <form action="{{ route('customer.review.store', $jobRequest->id) }}" method="POST">
                    @csrf

                    <div class="star-rating justify-content-center mb-4">
                        @for($i = 5; $i >= 1; $i--)
                            <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}"
                                   {{ old('rating') == $i ? 'checked' : '' }}>
                            <label for="star{{ $i }}" title="{{ $i }} star{{ $i > 1 ? 's' : '' }}">
                                <i class="bi bi-star-fill"></i>
                            </label>
                        @endfor
                    </div>

                    @error('rating')
                        <div class="text-danger small mb-3">{{ $message }}</div>
                    @enderror

                    <div class="mb-4 text-start">
                        <label for="comment" class="form-label fw-medium">Written Review <span class="text-muted fw-normal">(optional)</span></label>
                        <textarea name="comment" id="comment" rows="3"
                                  class="form-control @error('comment') is-invalid @enderror"
                                  placeholder="Share details about your experience...">{{ old('comment') }}</textarea>
                        @error('comment')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 justify-content-center">
                        <button type="submit" class="btn btn-warning fw-medium">
                            <i class="bi bi-star me-1"></i> Submit Review
                        </button>
                        <a href="{{ route('customer.messages.index', $jobRequest->id) }}"
                           class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
