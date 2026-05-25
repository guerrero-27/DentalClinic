@extends('layouts.client')

@section('page-title', 'My Appointments')

@section('content')
    <!-- Page Header -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">My Appointments</h1>
            <p class="text-gray-500 mt-1">Track and manage all your dental appointments</p>
        </div>
        <a href="{{ route('client.appointments.create') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-xl hover:bg-blue-700 font-semibold shadow-lg shadow-blue-200 transition flex items-center gap-2 whitespace-nowrap">
            <i class="fa-solid fa-plus"></i>
            Book New Appointment
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-3 mb-6 flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if($appointments->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
    @endif

    @forelse($appointments as $appointment)
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-md transition">
            <!-- Profile Section -->
            <div class="p-5 text-center border-b border-gray-100">
                <div class="w-16 h-16 rounded-full bg-blue-100 mx-auto mb-3 flex items-center justify-center text-blue-600 text-2xl font-bold border-2 border-blue-200">
                    <i class="fa-solid fa-tooth"></i>
                </div>
                <a href="{{ route('client.appointments.show', $appointment->id) }}" class="font-bold text-base text-blue-600 hover:text-blue-700 hover:underline">{{ $appointment->service->name }}</a>
                <p class="text-gray-500 text-xs">ID: #{{ $appointment->id }}</p>
            </div>

            <!-- Info Section -->
            <div class="p-4 space-y-2.5">
                <div class="flex items-center gap-3 text-sm">
                    <i class="fa-solid fa-calendar text-gray-400 w-5"></i>
                    <span class="text-gray-600">{{ $appointment->appointment_date->format('M d, Y') }}</span>
                </div>
                <div class="flex items-center gap-3 text-sm">
                    <i class="fa-solid fa-clock text-gray-400 w-5"></i>
                    <span class="text-gray-600">{{ date('g:i A', strtotime($appointment->appointment_time)) }} - {{ date('g:i A', strtotime($appointment->end_time)) }}</span>
                </div>
                <div class="flex items-center gap-3 text-sm">
                    <i class="fa-solid fa-user-doctor text-gray-400 w-5"></i>
                    <span class="text-gray-600">{{ $appointment->dentist ? 'Dr. ' . $appointment->dentist->name : 'TBD' }}</span>
                </div>
            </div>

            <!-- Status & Actions -->
            <div class="px-4 pb-4 pt-2 border-t border-gray-100">
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $appointment->getStatusColorClass() }}">
                        {{ ucfirst($appointment->status) }}
                    </span>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('client.appointments.show', $appointment->id) }}" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition flex items-center gap-1.5">
                            <i class="fa-solid fa-eye"></i> View
                        </a>
                        @if($appointment->status === 'pending' && $appointment->appointment_date > now())
                            <form method="POST" action="{{ route('client.appointments.cancel', $appointment->id) }}" onsubmit="return confirm('Cancel this appointment?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-lg transition flex items-center gap-1.5">
                                    <i class="fa-solid fa-ban"></i> Cancel
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="text-6xl mb-4">📅</div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">No Appointments Yet</h3>
            <p class="text-gray-500 mb-6">You haven't booked any dental appointments. Schedule your first visit today!</p>
            <a href="{{ route('client.appointments.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition-colors">
                <i class="fa-solid fa-plus"></i>
                Book Your First Appointment
            </a>
        </div>
    @endforelse

        @if($appointments->count() > 0)
        </div>
        @endif

    <!-- Pagination -->
    @if($appointments->hasPages())
        <div class="mt-8">
            {{ $appointments->links() }}
        </div>
    @endif
@endsection