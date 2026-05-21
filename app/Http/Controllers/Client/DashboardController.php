<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $appointments = $user->appointments()->with('service')->latest()->take(5)->get();

        $stats = [
            'total' => $user->appointments()->count(),
            'pending' => $user->appointments()->where('status', 'pending')->count(),
            'confirmed' => $user->appointments()->where('status', 'confirmed')->count(),
            'completed' => $user->appointments()->where('status', 'completed')->count(),
        ];

        return view('client.dashboard', compact('appointments', 'stats'));
    }
}
