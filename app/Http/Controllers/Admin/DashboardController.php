<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobRequest;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total'       => User::count(),
            'admins'      => User::where('role', 'admin')->count(),
            'tradespeople'=> User::where('role', 'tradesperson')->count(),
            'customers'   => User::where('role', 'customer')->count(),
            'pending_jobs'=> JobRequest::where('status', 'pending')->count(),
        ];

        $recentUsers = User::latest()->take(6)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers'));
    }
}
