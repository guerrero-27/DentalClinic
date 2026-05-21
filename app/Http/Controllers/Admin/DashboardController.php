<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Service;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_appointments' => Appointment::count(),
            'pending' => Appointment::where('status', 'pending')->count(),
            'confirmed' => Appointment::where('status', 'confirmed')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
            'total_clients' => User::where('role', 'client')->count(),
            'total_services' => Service::where('is_active', true)->count(),
        ];

        $recentAppointments = Appointment::with(['user', 'service'])
            ->latest()->take(8)->get();

        $todayAppointments = Appointment::with([['user', 'service']])
            ->whereDate('appointment_date', today())
            ->whereNotIn('status', ['cancelled'])
            ->orderBy('appointment_time')
            ->get();

        return view('admin.dashboard', compact('stats', 'recentAppointments', 'todayAppointments'));
    }
}
