@extends('layouts.app')
@section('title', 'My Dashboard')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-blue-900">Hello, {{ auth()->user()->name }}! 👋</h1>
            <p class="text-gray-500 mt-1">Manage your dental appointments here.</p>
        </div>
        <a href="{{ route('client.appointments.create') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-xl font-medium hover:bg-blue-700 transition">
            + Book Appointment
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl border border-blue-100 p-5 text-center shadow-sm">
            <div class="text-3xl font-bold text-blue-600">{{ $stats['total'] }}</div>
            <div class="text-gray-500 text-sm mt-1">Total</div>
        </div>
        <div class="bg-yellow-50 rounded-2xl border border-yellow-200 p-5 text-center shadow-sm">
            <div class="text-3xl font-bold text-yellow-600">{{ $stats['pending'] }}</div>
            <div class="text-gray-500 text-sm mt-1">Pending</div>
        </div>
        <div class="bg-blue-50 rounded-2xl border border-blue-200 p-5 text-center shadow-sm">
            <div class="text-3xl font-bold text-blue-700">{{ $stats['confirmed'] }}</div>
            <div class="text-gray-500 text-sm mt-1">Confirmed</div>
        </div>
        <div class="bg-green-50 rounded-2xl border border-green-200 p-5 text-center shadow-sm">
            <div class="text-3xl font-bold text-green-600">{{ $stats['completed'] }}</div>
            <div class="text-gray-500 text-sm mt-1">Completed</div>
        </div>
    </div>

    <!-- Recent Appointments -->
    <div class="bg-white rounded-2xl border border-blue-100 shadow-sm">
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
            <h2 class="font-bold text-blue-900 text-lg">Recent Appointments</h2>
            <a href="{{ route('client.appointments.index') }}" class="text-blue-600 text-sm hover:underline">View All →</a>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($appointments as $apt)
            <div class="px-6 py-4 flex justify-between items-center">
                <div>
                    <p class="font-semibold text-gray-800">{{ $apt->service->name }}</p>
                    <p class="text-sm text-gray-400">{{ $apt->appointment_date->format('F j, Y') }} at {{ date('g:i A', strtotime($apt->appointment_time)) }}</p>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $apt->getStatusColorClass() }}">
                    {{ ucfirst($apt->status) }}
                </span>
            </div>
            @empty
            <div class="px-6 py-10 text-center text-gray-400">
                <p class="text-4xl mb-2">📅</p>
                <p>No appointments yet. <a href="{{ route('client.appointments.create') }}" class="text-blue-600 hover:underline">Book one now!</a></p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection