<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\JobRequest;
use App\Models\Message;
use App\Models\TradespersonProfile;
use Illuminate\Http\Request;

class JobRequestController extends Controller
{
    public function create(string $tradespersonId)
    {
        $profile = TradespersonProfile::with('user')->where('user_id', $tradespersonId)->firstOrFail();

        return view('customer.request-service', compact('profile'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tradesperson_id' => ['required', 'exists:users,id'],
            'description'     => ['required', 'string', 'max:1000'],
            'scheduled_date'  => ['required', 'date', 'after_or_equal:today'],
            'deadline'        => ['nullable', 'date', 'after_or_equal:scheduled_date'],
        ]);

        $jobRequest = JobRequest::create([
            'customer_id'     => auth()->id(),
            'tradesperson_id' => $request->tradesperson_id,
            'description'     => $request->description,
            'scheduled_date'  => $request->scheduled_date,
            'deadline'        => $request->deadline,
            'status'          => 'pending',
        ]);

        // Initial message from description
        Message::create([
            'job_request_id'  => $jobRequest->id,
            'senders_id'      => auth()->id(),
            'receivers_id'    => $request->tradesperson_id,
            'message_content' => $request->description,
        ]);

        return redirect()->route('customer.messages.index', $jobRequest->id)
            ->with('success', 'Service request sent successfully.');
    }
}
