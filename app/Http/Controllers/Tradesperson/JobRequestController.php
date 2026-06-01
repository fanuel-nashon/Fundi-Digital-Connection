<?php

namespace App\Http\Controllers\Tradesperson;

use App\Http\Controllers\Controller;
use App\Models\JobRequest;

class JobRequestController extends Controller
{
    public function index()
    {
        $jobRequests = JobRequest::with('customer')
            ->where('tradesperson_id', auth()->id())
            ->latest()
            ->get();

        return view('tradesperson.job-requests', compact('jobRequests'));
    }

    public function accept(string $id)
    {
        JobRequest::where('id', $id)
            ->where('tradesperson_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail()
            ->update(['status' => 'accepted']);

        return back()->with('success', 'Job request accepted.');
    }

    public function decline(string $id)
    {
        JobRequest::where('id', $id)
            ->where('tradesperson_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail()
            ->update(['status' => 'declined']);

        return back()->with('success', 'Job request declined.');
    }
}
