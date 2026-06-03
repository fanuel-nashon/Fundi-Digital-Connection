<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();

        if ($user->isPending()) {
            Auth::logout();
            $request->session()->invalidate();
            return back()
                ->withErrors(['email' => 'Your account is awaiting admin approval. You will receive your login credentials by email once approved.'])
                ->onlyInput('email');
        }

        if ($user->isSuspended()) {
            Auth::logout();
            $request->session()->invalidate();
            return back()
                ->withErrors(['email' => 'Your account has been suspended. Please contact support.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        $role = $user->role;

        if ($role === 'admin')        return redirect(route('admin.dashboard'));
        if ($role === 'tradesperson') return redirect(route('tradesperson.tradesperson-dashboard'));
        if ($role === 'customer')     return redirect(route('home'));

        return redirect(route('dashboard', absolute: false));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
