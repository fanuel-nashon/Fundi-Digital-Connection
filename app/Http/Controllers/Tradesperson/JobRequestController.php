<?php

namespace App\Http\Controllers\Tradesperson;

use App\Http\Controllers\Controller;
use App\Models\JobRequest;
use Illuminate\Http\Request;

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

    public function updateProgress(Request $request, string $id)
    {
        $request->validate([
            'progress' => ['required', 'integer', 'in:0,25,50,75,100'],
        ]);

        $job = JobRequest::where('id', $id)
            ->where('tradesperson_id', auth()->id())
            ->whereIn('status', ['accepted', 'in_progress'])
            ->firstOrFail();

        $status = $request->progress == 100 ? 'complete' : 'in_progress';

        $job->update([
            'progress' => $request->progress,
            'status'   => $status,
        ]);

        $label = match((int) $request->progress) {
            0   => 'reset to Not Started',
            25  => 'updated to Started (25%)',
            50  => 'updated to Halfway (50%)',
            75  => 'updated to Almost Done (75%)',
            100 => 'marked as Complete',
        };

        return back()->with('success', "Job progress {$label}.");
    }

    public function notifications()
    {
        $notifications = auth()->user()->notifications()->latest()->paginate(20);
        auth()->user()->unreadNotifications->markAsRead();

        return view('tradesperson.notifications', compact('notifications'));
    }

    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    }
}
