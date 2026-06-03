<?php

namespace App\Http\Controllers\Tradesperson;

use App\Http\Controllers\Controller;
use App\Models\JobRequest;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(string $jobRequestId)
    {
        $jobRequest = JobRequest::with(['customer', 'messages.sender', 'review'])
            ->where('id', $jobRequestId)
            ->where('tradesperson_id', auth()->id())
            ->firstOrFail();

        return view('tradesperson.messages', compact('jobRequest'));
    }

    public function store(Request $request, string $jobRequestId)
    {
        $request->validate([
            'message_content' => ['required', 'string', 'max:2000'],
        ]);

        $jobRequest = JobRequest::where('id', $jobRequestId)
            ->where('tradesperson_id', auth()->id())
            ->firstOrFail();

        Message::create([
            'job_request_id'  => $jobRequest->id,
            'senders_id'      => auth()->id(),
            'receivers_id'    => $jobRequest->customer_id,
            'message_content' => $request->message_content,
        ]);

        return redirect()->route('tradesperson.messages.index', $jobRequestId);
    }
}
