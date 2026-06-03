<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\AccountApprovedNotification;
use App\Notifications\AccountRejectedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    public function index()
    {
        $pending = User::where('status', 'pending')
            ->with('tradespersonProfile')
            ->latest()
            ->get();

        return view('admin.registrations.index', compact('pending'));
    }

    public function approve(string $id)
    {
        $user = User::where('id', $id)->where('status', 'pending')->firstOrFail();

        $tempPassword = Str::random(10);

        $user->update([
            'status'             => 'active',
            'password'           => Hash::make($tempPassword),
            'email_verified_at'  => now(),
        ]);

        $user->syncRoles([$user->role]);

        $user->notify(new AccountApprovedNotification($tempPassword));

        return back()->with('success', "Account for {$user->name} approved. Credentials sent to {$user->email}.");
    }

    public function reject(Request $request, string $id)
    {
        $user = User::where('id', $id)->where('status', 'pending')->firstOrFail();

        $user->update(['status' => 'rejected']);

        $user->notify(new AccountRejectedNotification($request->reason));

        return back()->with('success', "Account for {$user->name} rejected.");
    }
}
