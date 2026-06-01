<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\JobRequest;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(string $jobRequestId)
    {
        $jobRequest = JobRequest::with(['tradesperson.tradespersonProfile', 'messages.sender', 'review'])
            ->where('id', $jobRequestId)
            ->where('customer_id', auth()->id())
            ->firstOrFail();

        return view('customer.messages', compact('jobRequest'));
    }

    public function store(Request $request, string $jobRequestId)
    {
        $request->validate([
            'message_content' => ['required', 'string', 'max:2000'],
        ]);

        $jobRequest = JobRequest::where('id', $jobRequestId)
            ->where('customer_id', auth()->id())
            ->firstOrFail();

        Message::create([
            'job_request_id'  => $jobRequest->id,
            'senders_id'      => auth()->id(),
            'receivers_id'    => $jobRequest->tradesperson_id,
            'message_content' => $request->message_content,
        ]);

        return redirect()->route('customer.messages.index', $jobRequestId);
    }

    public function complete(string $jobRequestId)
    {
        $jobRequest = JobRequest::where('id', $jobRequestId)
            ->where('customer_id', auth()->id())
            ->firstOrFail();

        $jobRequest->update(['status' => 'complete']);

        return redirect()->route('customer.messages.index', $jobRequestId)
            ->with('success', 'Job marked as complete. You can now leave a review.');
    }
}
