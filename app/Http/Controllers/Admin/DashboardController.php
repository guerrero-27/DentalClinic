<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

        $newClientsThisMonth = User::where('role', 'client')
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        $appointmentsThisMonth = Appointment::whereMonth('appointment_date', Carbon::now()->month)->count();
        $appointmentsLastMonth = Appointment::whereMonth('appointment_date', Carbon::now()->subMonth()->month)->count();
        $growthRate = $appointmentsLastMonth > 0 ? round((($appointmentsThisMonth - $appointmentsLastMonth) / $appointmentsLastMonth) * 100, 1) : 0;

        $todayAppointments = Appointment::with(['user', 'service', 'dentist'])
            ->whereDate('appointment_date', today())
            ->whereNotIn('status', ['cancelled'])
            ->orderBy('appointment_time')
            ->get();

        $recentAppointments = Appointment::with(['user', 'service', 'dentist'])
            ->latest()
            ->take(6)
            ->get();

        // Upcoming appointments (next 7 days, excluding today)
        $upcomingAppointments = Appointment::with(['user', 'service', 'dentist'])
            ->whereDate('appointment_date', '>', today())
            ->whereDate('appointment_date', '<=', today()->addDays(7))
            ->whereNotIn('status', ['cancelled'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->take(5)
            ->get();

        // Pending appointments needing attention
        $pendingAppointments = Appointment::with(['user', 'service', 'dentist'])
            ->where('status', 'pending')
            ->orderBy('appointment_date')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentAppointments',
            'todayAppointments',
            'upcomingAppointments',
            'pendingAppointments',
            'newClientsThisMonth',
            'growthRate',
            'appointmentsThisMonth'
        ));
    }

    public function analytics()
    {
        // Monthly appointment trends (last 6 months)
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $count = Appointment::whereMonth('appointment_date', $month->month)
                ->whereYear('appointment_date', $month->year)
                ->count();
            $monthlyData[] = [
                'month' => $month->format('M'),
                'count' => $count,
            ];
        }

        // Appointments by status
        $statusCounts = [
            'pending' => Appointment::where('status', 'pending')->count(),
            'confirmed' => Appointment::where('status', 'confirmed')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
        ];

        // Top services (by completed appointments)
        $topServices = Service::withCount([
            'appointments' => fn($q) => $q->where('status', 'completed')
        ])->orderBy('appointments_count', 'desc')->take(5)->get();

        // Weekly stats
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();
        $weeklyAppointments = Appointment::whereBetween('appointment_date', [$weekStart, $weekEnd])->count();

        // Growth metrics
        $thisMonth = Appointment::whereMonth('appointment_date', Carbon::now()->month)->count();
        $lastMonth = Appointment::whereMonth('appointment_date', Carbon::now()->subMonth()->month)->count();
        $growthRate = $lastMonth > 0 ? round((($thisMonth - $lastMonth) / $lastMonth) * 100, 1) : 0;

        return view('admin.analytics', compact(
            'monthlyData',
            'statusCounts',
            'topServices',
            'weeklyAppointments',
            'growthRate',
            'thisMonth',
            'lastMonth'
        ));
    }

    public function reports()
    {
        // Overall statistics
        $stats = [
            'total_appointments' => Appointment::count(),
            'pending' => Appointment::where('status', 'pending')->count(),
            'confirmed' => Appointment::where('status', 'confirmed')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
            'total_clients' => User::where('role', 'client')->count(),
            'total_services' => Service::count(),
        ];

        // Total revenue from completed appointments
        $totalRevenue = DB::table('appointments')
            ->join('services', 'appointments.service_id', '=', 'services.id')
            ->where('appointments.status', 'completed')
            ->sum('services.price');

        // Service breakdown
        $serviceBreakdown = Service::withCount([
            'appointments' => fn($q) => $q->where('status', 'completed')
        ])->get()->map(function ($service) {
            $service->revenue = $service->appointments_count * $service->price;
            return $service;
        });

        // Monthly revenue (last 6 months)
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $revenue = DB::table('appointments')
                ->join('services', 'appointments.service_id', '=', 'services.id')
                ->whereMonth('appointments.appointment_date', $month->month)
                ->whereYear('appointments.appointment_date', $month->year)
                ->where('appointments.status', 'completed')
                ->sum('services.price');
            $monthlyRevenue[] = [
                'month' => $month->format('M'),
                'revenue' => $revenue,
            ];
        }

        // Active clients (clients with at least 1 appointment)
        $activeClients = User::where('role', 'client')
            ->whereHas('appointments')
            ->count();

        // Cancellation rate
        $cancellationRate = $stats['total_appointments'] > 0
            ? round(($stats['cancelled'] / $stats['total_appointments']) * 100, 1)
            : 0;

        return view('admin.reports', compact(
            'stats',
            'totalRevenue',
            'serviceBreakdown',
            'monthlyRevenue',
            'activeClients',
            'cancellationRate'
        ));
    }
}
