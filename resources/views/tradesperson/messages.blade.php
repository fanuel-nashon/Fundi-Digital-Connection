@extends('layouts.tradesperson')
@section('title', 'Messages')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        {{-- Job header --}}
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white flex-shrink-0"
                             style="width:42px;height:42px;background:#0891b2;font-size:.9rem">
                            {{ strtoupper(substr($jobRequest->customer->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="fw-semibold">{{ $jobRequest->customer->name }}</div>
                            <div class="text-muted small">
                                {{ $jobRequest->customer->location ?? '' }}
                                &middot; Scheduled: {{ $jobRequest->scheduled_date->format('M d, Y') }}
                                @if($jobRequest->deadline)
                                    &middot;
                                    <span class="{{ $jobRequest->isOverdue() ? 'text-danger fw-semibold' : '' }}">
                                        Deadline: {{ $jobRequest->deadline->format('M d, Y') }}
                                    </span>
                                @endif
                            </div>
                            <p class="mb-0 mt-1 small text-muted">{{ Str::limit($jobRequest->description, 100) }}</p>
                        </div>
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

                @if(in_array($jobRequest->status, ['accepted', 'in_progress']))
                    <div class="mt-3">
                        <div class="d-flex justify-content-between small text-muted mb-1">
                            <span>Work progress</span>
                            <span class="fw-semibold" style="color:#0891b2">{{ $jobRequest->progress }}%</span>
                        </div>
                        <div class="progress" style="height:8px;border-radius:4px;background:#e2e8f0">
                            <div class="progress-bar"
                                 style="width:{{ $jobRequest->progress }}%;background:linear-gradient(90deg,#0891b2,#2563eb);border-radius:4px">
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Message thread --}}
        <div class="card mb-3">
            <div class="card-header fw-semibold d-flex align-items-center gap-2">
                <i class="bi bi-chat-dots text-muted"></i> Conversation with {{ $jobRequest->customer->name }}
            </div>
            <div class="card-body" style="max-height:450px;overflow-y:auto" id="messageThread">
                @forelse($jobRequest->messages as $msg)
                    @php $isMine = $msg->senders_id === auth()->id(); @endphp
                    <div class="d-flex {{ $isMine ? 'justify-content-end' : 'justify-content-start' }} mb-3">
                        <div style="max-width:75%">
                            <div class="rounded-3 px-3 py-2
                                {{ $isMine ? 'text-white' : 'bg-light' }}"
                                 style="{{ $isMine ? 'background:#0891b2' : '' }}">
                                {{ $msg->message_content }}
                            </div>
                            <div class="text-muted mt-1"
                                 style="font-size:.72rem;text-align:{{ $isMine ? 'right' : 'left' }}">
                                {{ $msg->sender->name }} &middot; {{ $msg->created_at->format('M d, g:i a') }}
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center small py-3">No messages yet. Send the first one.</p>
                @endforelse
            </div>
        </div>

        {{-- Reply form --}}
        @if(!in_array($jobRequest->status, ['reviewed', 'declined']))
        <div class="card mb-3">
            <div class="card-body">
                <form method="POST" action="{{ route('tradesperson.messages.store', $jobRequest->id) }}">
                    @csrf
                    <div class="d-flex gap-2">
                        <input type="text" name="message_content"
                               class="form-control @error('message_content') is-invalid @enderror"
                               placeholder="Type a message..." required autocomplete="off">
                        <button type="submit" class="btn btn-brand px-4">
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

        <a href="{{ route('tradesperson.job-requests.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Back to Job Requests
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
