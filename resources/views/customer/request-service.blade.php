@extends('layouts.customer')

@section('title', 'Request Service')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <a href="{{ route('customer.tradesperson.show', $profile->user_id) }}" class="btn btn-sm btn-outline-secondary mb-4">
            &larr; Back to profile
        </a>

        <div class="card mb-3">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                     style="width:48px;height:48px;flex-shrink:0">
                    <i class="bi bi-person-fill text-primary"></i>
                </div>
                <div>
                    <div class="fw-semibold">{{ $profile->user->name }}</div>
                    <span class="badge bg-primary bg-opacity-10 text-primary" style="font-size:0.72rem">
                        {{ ucfirst($profile->category) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white fw-semibold">Describe Your Request</div>
            <div class="card-body">
                <form action="{{ route('customer.request.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tradesperson_id" value="{{ $profile->user_id }}">

                    <div class="mb-3">
                        <label for="description" class="form-label fw-medium">What do you need?</label>
                        <textarea name="description" id="description" rows="4"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Describe the work you need done in detail..." required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="scheduled_date" class="form-label fw-medium">Preferred Date</label>
                        <input type="date" name="scheduled_date" id="scheduled_date"
                               class="form-control @error('scheduled_date') is-invalid @enderror"
                               min="{{ date('Y-m-d') }}" value="{{ old('scheduled_date') }}" required>
                        @error('scheduled_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-1"></i> Send Request
                        </button>
                        <a href="{{ route('customer.tradesperson.show', $profile->user_id) }}"
                           class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
