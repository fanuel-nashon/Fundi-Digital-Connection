<?php

namespace App\Http\Controllers\Tradesperson;

use App\Http\Controllers\Controller;
use App\Models\TradespersonProfile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(string $id)
    {
        abort_if((int) $id !== auth()->id(), 403);

        $profile = TradespersonProfile::where('user_id', $id)->first();

        return view('tradesperson.profile', compact('profile'));
    }

    public function create()
    {
        if (TradespersonProfile::where('user_id', auth()->id())->exists()) {
            return redirect()->route('tradesperson.tradesperson-profile', auth()->id())
                ->with('error', 'You already have a profile.');
        }

        return view('tradesperson.create-profile');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category'            => ['required', 'in:plumbing,electrical,carpentry,welding,masonry'],
            'bio'                 => ['required', 'string', 'max:1000'],
            'availability_status' => ['required', 'in:available,unavailable'],
        ]);

        TradespersonProfile::create([
            'user_id'             => auth()->id(),
            'category'            => $request->category,
            'bio'                 => $request->bio,
            'availability_status' => $request->availability_status,
            'reviews'             => 0,
        ]);

        return redirect()->route('tradesperson.tradesperson-profile', auth()->id())
            ->with('success', 'Profile created successfully.');
    }
}
