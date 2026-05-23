@extends('layouts.admin')
@section('page-title', 'Dashboard')
@section('page-subtitle')
    <p class="text-sm text-gray-500">Welcome back, {{ auth()->user()->name }}</p>
@endsection
@section('content')

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-2xl p-5 shadow-lg shadow-blue-200 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-6 -mt-6"></div>
            <i class="fa-solid fa-calendar-check text-3xl text-blue-200 mb-3"></i>
            <div class="text-3xl font-bold">{{ $stats['total_appointments'] }}</div>
            <div class="text-blue-100 text-sm mt-1">Total Appointments</div>
        </div>

        <div class="bg-gradient-to-br from-yellow-400 to-yellow-500 text-white rounded-2xl p-5 shadow-lg shadow-yellow-200 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-6 -mt-6"></div>
            <i class="fa-solid fa-clock text-3xl text-yellow-200 mb-3"></i>
            <div class="text-3xl font-bold">{{ $stats['pending'] }}</div>
            <div class="text-yellow-100 text-sm mt-1">Pending Approval</div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-2xl p-5 shadow-lg shadow-green-200 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-6 -mt-6"></div>
            <i class="fa-solid fa-circle-check text-3xl text-green-200 mb-3"></i>
            <div class="text-3xl font-bold">{{ $stats['completed'] }}</div>
            <div class="text-green-100 text-sm mt-1">Completed</div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-2xl p-5 shadow-lg shadow-purple-200 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-6 -mt-6"></div>
            <i class="fa-solid fa-users text-3xl text-purple-200 mb-3"></i>
            <div class="text-3xl font-bold">{{ $stats['total_clients'] }}</div>
            <div class="text-purple-100 text-sm mt-1">Total Clients</div>
        </div>
    </div>

    <!-- Secondary Stats Row -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white border border-gray-200 rounded-2xl p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">This Month</span>
                <i class="fa-solid fa-calendar text-gray-400"></i>
            </div>
            <div class="text-2xl font-bold text-gray-800">{{ $appointmentsThisMonth ?? 0 }}</div>
            <p class="text-xs text-gray-500 mt-1">appointments</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">New Clients</span>
                <i class="fa-solid fa-user-plus text-gray-400"></i>
            </div>
            <div class="text-2xl font-bold text-gray-800">+{{ $newClientsThisMonth }}</div>
            <p class="text-xs text-gray-500 mt-1">this month</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Growth</span>
                @if($growthRate > 0)
                    <i class="fa-solid fa-arrow-up text-green-500"></i>
                @elseif($growthRate < 0)
                    <i class="fa-solid fa-arrow-down text-red-500"></i>
                @else
                    <i class="fa-solid fa-minus text-gray-400"></i>
                @endif
            </div>
            <div class="text-2xl font-bold {{ $growthRate >= 0 ? 'text-green-600' : 'text-red-600' }}">
                {{ $growthRate > 0 ? '+' : '' }}{{ $growthRate }}%
            </div>
            <p class="text-xs text-gray-500 mt-1">vs last month</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Services</span>
                <i class="fa-solid fa-stethoscope text-gray-400"></i>
            </div>
            <div class="text-2xl font-bold text-gray-800">{{ $stats['total_services'] }}</div>
            <p class="text-xs text-gray-500 mt-1">active services</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Today's Schedule -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h2 class="font-bold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-calendar-day text-blue-500"></i> Today
                    </h2>
                    <p class="text-gray-400 text-xs">{{ now()->format('l, F j, Y') }}</p>
                </div>
                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">
                    {{ $todayAppointments->count() }} appointments
                </span>
            </div>
            <div class="divide-y divide-gray-50 max-h-64 overflow-y-auto">
                @forelse($todayAppointments as $apt)
                <div class="px-6 py-3 hover:bg-blue-50/50 transition">
                    <div class="flex justify-between items-start">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-800 text-sm truncate">{{ $apt->user->name }}</p>
                            <p class="text-xs text-gray-400 flex items-center gap-1 mt-0.5">
                                <i class="fa-solid fa-stethoscope text-blue-400"></i>
                                {{ $apt->service->name ?? 'Unknown' }}
                            </p>
                        </div>
                        <div class="text-right ml-3">
                            <p class="text-sm font-semibold text-gray-800">{{ date('g:i A', strtotime($apt->appointment_time)) }}</p>
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $apt->getStatusColorClass() }} mt-1 inline-block">
                                {{ ucfirst($apt->status) }}
                            </span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="px-6 py-8 text-center">
                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fa-solid fa-calendar-xmark text-gray-400 text-xl"></i>
                    </div>
                    <p class="text-gray-400 text-sm">No appointments today</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Pending Approvals -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h2 class="font-bold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-hourglass-half text-yellow-500"></i> Pending
                    </h2>
                    <p class="text-gray-400 text-xs">Needs attention</p>
                </div>
                @if($stats['pending'] > 0)
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">
                        {{ $stats['pending'] }} pending
                    </span>
                @endif
            </div>
            <div class="divide-y divide-gray-50 max-h-64 overflow-y-auto">
                @forelse($pendingAppointments as $apt)
                <div class="px-6 py-3 hover:bg-yellow-50/50 transition">
                    <div class="flex justify-between items-start">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-800 text-sm truncate">{{ $apt->user->name }}</p>
                            <p class="text-xs text-gray-400 flex items-center gap-1 mt-0.5">
                                <i class="fa-solid fa-calendar text-yellow-400"></i>
                                {{ $apt->appointment_date->format('M j') }} at {{ date('g:i A', strtotime($apt->appointment_time)) }}
                            </p>
                        </div>
                        <a href="{{ route('admin.appointments.show', $apt) }}" class="px-3 py-1 bg-blue-600 text-white rounded-lg text-xs font-semibold hover:bg-blue-700 transition">
                            Review
                        </a>
                    </div>
                </div>
                @empty
                <div class="px-6 py-8 text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fa-solid fa-check-circle text-green-400 text-xl"></i>
                    </div>
                    <p class="text-gray-400 text-sm">All caught up!</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Upcoming (Next 7 Days) -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h2 class="font-bold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-calendar-week text-purple-500"></i> Upcoming
                    </h2>
                    <p class="text-gray-400 text-xs">Next 7 days</p>
                </div>
                <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-bold">
                    {{ $upcomingAppointments->count() }}
                </span>
            </div>
            <div class="divide-y divide-gray-50 max-h-64 overflow-y-auto">
                @forelse($upcomingAppointments as $apt)
                <div class="px-6 py-3 hover:bg-purple-50/50 transition">
                    <div class="flex justify-between items-start">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-800 text-sm truncate">{{ $apt->user->name }}</p>
                            <p class="text-xs text-gray-400 flex items-center gap-1 mt-0.5">
                                <i class="fa-solid fa-stethoscope text-purple-400"></i>
                                {{ $apt->service->name ?? 'Unknown' }}
                            </p>
                        </div>
                        <div class="text-right ml-3">
                            <p class="text-xs font-semibold text-purple-700">{{ $apt->appointment_date->format('M j') }}</p>
                            <p class="text-xs text-gray-500">{{ date('g:i A', strtotime($apt->appointment_time)) }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="px-6 py-8 text-center">
                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fa-solid fa-calendar text-gray-400 text-xl"></i>
                    </div>
                    <p class="text-gray-400 text-sm">No upcoming appointments</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h2 class="font-bold text-gray-900 flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-gray-400"></i> Recent Activity
            </h2>
            <a href="{{ route('admin.appointments.index') }}" class="text-blue-600 text-sm font-medium hover:underline flex items-center gap-1">
                View All <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <!-- Desktop Table View -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Service</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Date & Time</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($recentAppointments as $apt)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-sm flex-shrink-0">
                                    {{ strtoupper(substr($apt->user->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-800 truncate">{{ $apt->user->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $apt->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-medium text-gray-800">{{ $apt->service->name ?? 'Unknown' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-medium text-gray-800 text-sm">{{ $apt->appointment_date->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-500">{{ date('g:i A', strtotime($apt->appointment_time)) }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $apt->getStatusColorClass() }}">
                                {{ ucfirst($apt->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.appointments.show', $apt) }}" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-semibold text-sm transition">
                                <i class="fa-solid fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="text-gray-400">
                                <i class="fa-solid fa-calendar-xmark text-4xl mb-2"></i>
                                <p class="font-medium">No appointments found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden divide-y divide-gray-100">
            @forelse($recentAppointments as $apt)
            <div class="p-4 space-y-3 hover:bg-gray-50 transition">
                <!-- Header Row -->
                <div class="flex justify-between items-start">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-sm flex-shrink-0">
                            {{ strtoupper(substr($apt->user->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="font-semibold text-gray-800 truncate">{{ $apt->user->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $apt->user->email }}</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $apt->getStatusColorClass() }} ml-2 flex-shrink-0">
                        {{ ucfirst($apt->status) }}
                    </span>
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-100 pt-3">
                    <!-- Details Grid -->
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div class="bg-gray-50 rounded-lg p-2.5">
                            <p class="text-gray-500 text-xs mb-0.5">Service</p>
                            <p class="font-medium text-gray-800 truncate">{{ $apt->service->name ?? 'Unknown' }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-2.5">
                            <p class="text-gray-500 text-xs mb-0.5">Schedule</p>
                            <p class="font-medium text-gray-800">{{ $apt->appointment_date->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-500">{{ date('g:i A', strtotime($apt->appointment_time)) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="pt-1">
                    <a href="{{ route('admin.appointments.show', $apt) }}" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg font-semibold text-sm transition">
                        <i class="fa-solid fa-eye"></i> View Details
                    </a>
                </div>
            </div>
            @empty
            <div class="px-6 py-12 text-center">
                <div class="text-gray-400">
                    <i class="fa-solid fa-calendar-xmark text-4xl mb-2"></i>
                    <p class="font-medium">No appointments found</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
@endsection