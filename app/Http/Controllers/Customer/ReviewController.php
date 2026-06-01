<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\JobRequest;
use App\Models\Review;
use App\Models\TradespersonProfile;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(string $jobRequestId)
    {
        $jobRequest = JobRequest::with('tradesperson.tradespersonProfile')
            ->where('id', $jobRequestId)
            ->where('customer_id', auth()->id())
            ->where('status', 'complete')
            ->firstOrFail();

        abort_if($jobRequest->review()->exists(), 403, 'You have already reviewed this job.');

        return view('customer.rate', compact('jobRequest'));
    }

    public function store(Request $request, string $jobRequestId)
    {
        $request->validate([
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $jobRequest = JobRequest::where('id', $jobRequestId)
            ->where('customer_id', auth()->id())
            ->where('status', 'complete')
            ->firstOrFail();

        abort_if($jobRequest->review()->exists(), 403, 'You have already reviewed this job.');

        Review::create([
            'job_requests_id' => $jobRequest->id,
            'rating'          => $request->rating,
            'comment'         => $request->comment,
        ]);

        // Update review count on tradesperson profile
        $profile = TradespersonProfile::where('user_id', $jobRequest->tradesperson_id)->first();
        if ($profile) {
            $profile->increment('reviews');
        }

        $jobRequest->update(['status' => 'reviewed']);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Thank you for your review!');
    }
}
