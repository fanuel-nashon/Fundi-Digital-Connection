<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\TradespersonProfile;

class DashboardController extends Controller
{
    public function index()
    {
        $query = TradespersonProfile::with('user')->whereHas('user');

        if (request('category')) {
            $query->where('category', request('category'));
        }

        if (request('availability')) {
            $query->where('availability_status', request('availability'));
        }

        if (request('location')) {
            $query->whereHas('user', function ($q) {
                $q->where('location', 'like', '%' . request('location') . '%');
            });
        }

        $tradespersons = $query->get()->map(function ($profile) {
            $profile->avg_rating = $profile->averageRating();
            return $profile;
        });

        if (request('min_rating')) {
            $tradespersons = $tradespersons->filter(fn($p) => $p->avg_rating >= (float) request('min_rating'));
        }

        return view('customer.dashboard', compact('tradespersons'));
    }

    public function show(string $id)
    {
        $profile = TradespersonProfile::with('user')->where('user_id', $id)->firstOrFail();
        $profile->avg_rating = $profile->averageRating();

        $recentReviews = \App\Models\Review::whereIn(
            'job_requests_id',
            \App\Models\JobRequest::where('tradesperson_id', $id)->pluck('id')
        )->latest()->take(5)->get()->map(function ($review) {
            $review->customer_name = $review->jobRequest->customer->name ?? 'Customer';
            return $review;
        });

        return view('customer.tradesperson-show', compact('profile', 'recentReviews'));
    }
}
