@extends('layouts.admin')
@section('page-title', 'Admin Dashboard')
@section('page-subtitle')
    <p class="text-sm text-gray-500">Welcome back, {{ auth()->user()->name }}</p>
@endsection
@section('content')

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-blue-600 text-white rounded-2xl p-5">
            <div class="text-3xl font-bold">{{ $stats['total_appointments'] }}</div>
            <div class="text-blue-200 text-sm mt-1">Total Appointments</div>
        </div>
        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-5">
            <div class="text-3xl font-bold text-yellow-700">{{ $stats['pending'] }}</div>
            <div class="text-yellow-600 text-sm mt-1"><i class="fa-solid fa-clock"></i> Pending</div>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-2xl p-5">
            <div class="text-3xl font-bold text-green-700">{{ $stats['completed'] }}</div>
            <div class="text-green-600 text-sm mt-1"><i class="fa-solid fa-circle-check"></i> Completed</div>
        </div>
        <div class="bg-white border border-blue-100 rounded-2xl p-5">
            <div class="text-3xl font-bold text-blue-800">{{ $stats['total_clients'] }}</div>
            <div class="text-gray-500 text-sm mt-1"><i class="fa-solid fa-users"></i> Clients</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Today's Schedule -->
        <div class="bg-white rounded-2xl border border-blue-100 shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="font-bold text-blue-900"><i class="fa-solid fa-calendar-check"></i> Today's Schedule</h2>
                <p class="text-gray-400 text-xs">{{ today()->format('F j, Y') }}</p>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($todayAppointments as $apt)
                <div class="px-6 py-3 flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800 text-sm">{{ $apt->user->name }}</p>
                        <p class="text-xs text-gray-400">{{ $apt->service->name }} · {{ date('g:i A', strtotime($apt->appointment_time)) }}</p>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $apt->getStatusColorClass() }}">{{ ucfirst($apt->status) }}</span>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-gray-400 text-sm">No appointments today.</div>
                @endforelse
            </div>
        </div>

        <!-- Recent Appointments -->
        <div class="bg-white rounded-2xl border border-blue-100 shadow-sm">
            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
                <h2 class="font-bold text-blue-900">Recent Appointments</h2>
                <a href="{{ route('admin.appointments.index') }}" class="text-blue-600 text-xs hover:underline">View All</a>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($recentAppointments as $apt)
                <div class="px-6 py-3 flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800 text-sm">{{ $apt->user->name }}</p>
                        <p class="text-xs text-gray-400">{{ $apt->service->name }} · {{ $apt->appointment_date->format('M j') }}</p>
                    </div>
                    <a href="{{ route('admin.appointments.show', $apt) }}" class="text-blue-600 text-xs hover:underline">View</a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection