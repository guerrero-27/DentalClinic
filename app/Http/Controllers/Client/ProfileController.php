<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        $stats = [
            'total' => $user->appointments->count(),
            'pending' => $user->appointments->where('status', 'pending')->count(),
            'confirmed' => $user->appointments->where('status', 'confirmed')->count(),
            'completed' => $user->appointments->where('status', 'completed')->count(),
            'cancelled' => $user->appointments->where('status', 'cancelled')->count(),
        ];

        $recentAppointments = $user->appointments()->latest()->take(5)->get();

        return view('client.profile', compact('user', 'stats', 'recentAppointments'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'birthdate' => 'nullable|date',
        ]);

        $user->update($validated);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
