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
            'total'            => User::where('status', 'active')->count(),
            'admins'           => User::where('role', 'admin')->where('status', 'active')->count(),
            'tradespeople'     => User::where('role', 'tradesperson')->where('status', 'active')->count(),
            'customers'        => User::where('role', 'customer')->where('status', 'active')->count(),
            'pending_jobs'     => JobRequest::where('status', 'pending')->count(),
            'pending_accounts' => User::where('status', 'pending')->count(),
        ];

        $recentUsers = User::latest()->take(6)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers'));
    }
}
