@extends('layouts.client')

@section('page-title', 'Dashboard')

@section('content')
    <!-- Welcome Section -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 mb-6 text-white">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold mb-1">Hello, {{ explode(' ', auth()->user()->name)[0] }}! 👋</h1>
                <p class="text-blue-100 text-sm md:text-base">Welcome back to your dental care portal. Here's your appointment overview.</p>
            </div>
            <a href="{{ route('client.appointments.create') }}" class="inline-flex items-center gap-2 bg-white text-blue-600 px-5 py-2.5 rounded-xl font-semibold hover:bg-blue-50 transition shadow-lg">
                <i class="fa-solid fa-plus"></i>
                Book Appointment
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                    <i class="fa-solid fa-calendar-check text-blue-600"></i>
                </div>
                <span class="text-xs text-gray-400">Total</span>
            </div>
            <div class="text-2xl md:text-3xl font-bold text-gray-900">{{ $stats['total'] }}</div>
            <p class="text-sm text-gray-500 mt-1">Appointments</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                    <i class="fa-solid fa-clock text-yellow-600"></i>
                </div>
                <span class="text-xs text-yellow-600 bg-yellow-50 px-2 py-0.5 rounded-full">Pending</span>
            </div>
            <div class="text-2xl md:text-3xl font-bold text-gray-900">{{ $stats['pending'] }}</div>
            <p class="text-sm text-gray-500 mt-1">Awaiting Confirmation</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                    <i class="fa-solid fa-calendar-check text-blue-600"></i>
                </div>
                <span class="text-xs text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">Confirmed</span>
            </div>
            <div class="text-2xl md:text-3xl font-bold text-gray-900">{{ $stats['confirmed'] }}</div>
            <p class="text-sm text-gray-500 mt-1">Upcoming</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                    <i class="fa-solid fa-check-circle text-emerald-600"></i>
                </div>
                <span class="text-xs text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Done</span>
            </div>
            <div class="text-2xl md:text-3xl font-bold text-gray-900">{{ $stats['completed'] }}</div>
            <p class="text-sm text-gray-500 mt-1">Completed</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Appointments -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h2 class="font-bold text-gray-900 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-gray-400"></i> Recent Appointments
                </h2>
                <a href="{{ route('client.appointments.index') }}" class="text-blue-600 text-sm font-medium hover:underline flex items-center gap-1">
                    View All <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            <!-- Desktop Table View -->
            <div class="hidden md:block">
                @forelse($appointments as $apt)
                <div class="p-4 hover:bg-gray-50 transition border-b border-gray-50 last:border-0">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                <i class="fa-solid fa-tooth text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">{{ $apt->service->name ?? 'Unknown Service' }}</p>
                                <p class="text-sm text-gray-500 flex items-center gap-2 mt-1">
                                    <i class="fa-regular fa-calendar text-gray-400"></i>
                                    {{ $apt->appointment_date->format('M d, Y') }}
                                    <span class="mx-1">•</span>
                                    <i class="fa-regular fa-clock text-gray-400"></i>
                                    {{ date('g:i A', strtotime($apt->appointment_time)) }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $apt->getStatusColorClass() }}">
                                {{ ucfirst($apt->status) }}
                            </span>
                            <a href="{{ route('client.appointments.show', $apt) }}" class="w-9 h-9 inline-flex items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition" title="View">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-calendar-xmark text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-500 font-medium mb-2">No appointments yet</p>
                    <a href="{{ route('client.appointments.create') }}" class="inline-flex items-center gap-2 text-blue-600 hover:underline">
                        <i class="fa-solid fa-plus"></i> Book your first appointment
                    </a>
                </div>
                @endforelse
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden divide-y divide-gray-100">
                @forelse($appointments as $apt)
                <div class="p-4 hover:bg-gray-50 transition">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-tooth text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">{{ $apt->service->name ?? 'Unknown' }}</p>
                                <p class="text-xs text-gray-500">{{ $apt->appointment_date->format('M d, Y') }} at {{ date('g:i A', strtotime($apt->appointment_time)) }}</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $apt->getStatusColorClass() }}">
                            {{ ucfirst($apt->status) }}
                        </span>
                    </div>
                    <a href="{{ route('client.appointments.show', $apt) }}" class="flex items-center justify-center gap-2 w-full px-4 py-2 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg font-medium text-sm transition">
                        <i class="fa-solid fa-eye"></i> View Details
                    </a>
                </div>
                @empty
                <div class="p-8 text-center">
                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fa-solid fa-calendar-xmark text-gray-400 text-xl"></i>
                    </div>
                    <p class="text-gray-500 text-sm">No appointments found</p>
                    <a href="{{ route('client.appointments.create') }}" class="inline-flex items-center gap-1 text-blue-600 hover:underline text-sm mt-2">
                        Book your first appointment
                    </a>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Right Sidebar Features -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-bolt text-yellow-500"></i> Quick Actions
                    </h3>
                </div>
                <div class="p-4 space-y-3">
                    <a href="{{ route('client.appointments.create') }}" class="flex items-center gap-3 p-3 bg-blue-50 hover:bg-blue-100 rounded-xl transition group">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition">
                            <i class="fa-solid fa-plus text-blue-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 text-sm">Book Appointment</p>
                            <p class="text-xs text-gray-500">Schedule a visit</p>
                        </div>
                    </a>
                    <a href="{{ route('client.appointments.index') }}" class="flex items-center gap-3 p-3 bg-gray-50 hover:bg-gray-100 rounded-xl transition group">
                        <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center group-hover:bg-gray-300 transition">
                            <i class="fa-solid fa-list text-gray-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 text-sm">My Appointments</p>
                            <p class="text-xs text-gray-500">View all bookings</p>
                        </div>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 bg-gray-50 hover:bg-gray-100 rounded-xl transition group">
                        <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center group-hover:bg-gray-300 transition">
                            <i class="fa-solid fa-headset text-gray-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 text-sm">Support</p>
                            <p class="text-xs text-gray-500">Need help?</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Clinic Info Card -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-tooth text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">DentalCare Clinic</h3>
                        <p class="text-blue-100 text-sm">Your smile is our priority</p>
                    </div>
                </div>
                <div class="space-y-2 text-sm text-blue-100">
                    <p class="flex items-center gap-2">
                        <i class="fa-solid fa-location-dot w-4"></i>
                        123 Dental Street, Makati City
                    </p>
                    <p class="flex items-center gap-2">
                        <i class="fa-solid fa-phone w-4"></i>
                        (02) 123-4567
                    </p>
                    <p class="flex items-center gap-2">
                        <i class="fa-solid fa-clock w-4"></i>
                        Mon - Sat: 8AM - 6PM
                    </p>
                </div>
            </div>

            <!-- Emergency Contact -->
            <div class="bg-white rounded-xl border border-red-200 shadow-sm overflow-hidden">
                <div class="bg-red-50 px-6 py-4 border-b border-red-100">
                    <h3 class="font-bold text-red-700 flex items-center gap-2">
                        <i class="fa-solid fa-phone-volume"></i> Emergency?
                    </h3>
                </div>
                <div class="p-4 text-center">
                    <p class="text-sm text-gray-600 mb-3">For dental emergencies, call us immediately:</p>
                    <a href="tel:+6321234567" class="inline-flex items-center justify-center gap-2 w-full bg-red-600 text-white py-3 rounded-xl font-semibold hover:bg-red-700 transition">
                        <i class="fa-solid fa-phone"></i> (02) 123-4567
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection