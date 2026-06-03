@extends('layouts.customer')

@section('title', 'Messages')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        {{-- Job request header --}}
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <div class="fw-semibold">{{ $jobRequest->tradesperson->name }}</div>
                        <small class="text-muted">
                            {{ ucfirst($jobRequest->tradesperson->tradespersonProfile->category ?? '') }} &middot;
                            {{ $jobRequest->scheduled_date->format('M d, Y') }}
                        </small>
                    </div>
                    <span class="badge bg-{{ match($jobRequest->status) {
                        'pending'     => 'warning',
                        'accepted'    => 'primary',
                        'in_progress' => 'info',
                        'complete'    => 'success',
                        'reviewed'    => 'secondary',
                        default       => 'light'
                    } }} text-capitalize">{{ str_replace('_', ' ', $jobRequest->status) }}</span>
                </div>

                <div class="mt-3 d-flex gap-2 flex-wrap">
                    @if(in_array($jobRequest->status, ['accepted', 'in_progress']))
                        <form method="POST" action="{{ route('customer.messages.complete', $jobRequest->id) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="bi bi-check-circle me-1"></i> Mark as Complete
                            </button>
                        </form>
                    @endif

                    @if($jobRequest->status === 'complete' && !$jobRequest->review)
                        <a href="{{ route('customer.review.create', $jobRequest->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-star me-1"></i> Leave a Review
                        </a>
                    @endif

                    @if($jobRequest->status === 'reviewed')
                        <span class="text-muted small"><i class="bi bi-check-all me-1"></i>You reviewed this job</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Message thread --}}
        <div class="card mb-3">
            <div class="card-header bg-white fw-semibold">Conversation</div>
            <div class="card-body" style="max-height:450px;overflow-y:auto" id="messageThread">
                @forelse($jobRequest->messages as $message)
                    @php $isMine = $message->senders_id === auth()->id(); @endphp
                    <div class="d-flex {{ $isMine ? 'justify-content-end' : 'justify-content-start' }} mb-3">
                        <div style="max-width:75%">
                            <div class="rounded-3 px-3 py-2 {{ $isMine ? 'bg-primary text-white' : 'bg-light' }}">
                                {{ $message->message_content }}
                            </div>
                            <div class="text-muted mt-1" style="font-size:0.72rem;text-align:{{ $isMine ? 'right' : 'left' }}">
                                {{ $message->sender->name }} &middot; {{ $message->created_at->format('M d, g:i a') }}
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center small">No messages yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Reply form --}}
        @if(!in_array($jobRequest->status, ['reviewed']))
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('customer.messages.store', $jobRequest->id) }}">
                    @csrf
                    <div class="d-flex gap-2">
                        <input type="text" name="message_content"
                               class="form-control @error('message_content') is-invalid @enderror"
                               placeholder="Type a message..." required>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-send"></i>
                        </button>
                    </div>
                    @error('message_content')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </form>
            </div>
        </div>
        @endif

        <a href="{{ route('customer.my-requests') }}" class="btn btn-sm btn-outline-secondary mt-3">
            <i class="bi bi-arrow-left me-1"></i>Back to My Requests
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const thread = document.getElementById('messageThread');
    if (thread) thread.scrollTop = thread.scrollHeight;
</script>
@endsection
