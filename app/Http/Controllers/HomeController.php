<?php

namespace App\Http\Controllers;

use App\Models\TradespersonProfile;

class HomeController extends Controller
{
    public function index()
    {
        // Redirect logged-in users straight to their dashboard
        if (auth()->check()) {
            $role = auth()->user()->role;
            if ($role === 'admin')        return redirect(route('admin.dashboard'));
            if ($role === 'tradesperson') return redirect(route('tradesperson.tradesperson-dashboard'));
        }

        $query = TradespersonProfile::with('user')
            ->whereHas('user', fn($q) => $q->where('status', 'active'))
            ->where('availability_status', 'available');

        if (request('category')) {
            $query->where('category', request('category'));
        }

        if (request('location')) {
            $query->whereHas('user', fn($q) => $q->where('location', 'like', '%' . request('location') . '%'));
        }

        $tradespersons = $query->get()->map(function ($profile) {
            $profile->avg_rating = $profile->averageRating();
            return $profile;
        });

        return view('welcome', compact('tradespersons'));
    }
}
