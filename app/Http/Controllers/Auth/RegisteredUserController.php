<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\TradespersonProfile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(Request $request): View
    {
        $role = in_array($request->role, ['customer', 'tradesperson'])
            ? $request->role
            : 'customer';

        return view('auth.register', compact('role'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'location' => ['required', 'string', 'max:255'],
            'role'     => ['required', 'in:customer,tradesperson'],
            'category' => ['required_if:role,tradesperson', 'nullable', 'in:plumbing,electrical,carpentry,welding,masonry'],
            'bio'      => ['required_if:role,tradesperson', 'nullable', 'string', 'max:1000'],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'location' => $this->resolveLocationSearch($request->location)[0],
            'role'     => $request->role,
            'status'   => 'pending',
            'password' => null,
        ]);

        if ($request->role === 'tradesperson') {
            TradespersonProfile::create([
                'user_id'             => $user->id,
                'category'            => $request->category,
                'bio'                 => $request->bio,
                'availability_status' => 'available',
                'reviews'             => 0,
            ]);
        }

        event(new Registered($user));

        return redirect()->route('register.pending');
    }
}
