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

    @forelse($appointments as $appointment)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-4 hover:shadow-md transition-shadow">
            <div class="flex flex-col md:flex-row items-stretch">
                <!-- Left accent bar and status -->
                <div class="md:w-1 bg-gradient-to-b {{ $appointment->status === 'pending' ? 'from-yellow-400 to-yellow-500' : ($appointment->status === 'confirmed' ? 'from-blue-400 to-blue-500' : ($appointment->status === 'completed' ? 'from-emerald-400 to-emerald-500' : 'from-red-400 to-red-500')) }}"></div>

                <!-- Content -->
                <div class="flex-1 p-6 md:p-8">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                                <i class="fa-solid fa-stethoscope text-blue-600"></i>
                                {{ $appointment->service->name }}
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">ID: #{{ $appointment->id }}</p>
                        </div>
                        <span class="{{ $appointment->getStatusColorClass() }} px-4 py-2 rounded-full text-sm font-bold whitespace-nowrap shadow-sm">
                            <i class="fa-solid fa-circle mr-1 text-xs"></i>
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
                        <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                            <p class="text-xs text-gray-500 font-semibold">Date</p>
                            <p class="font-bold text-gray-900 text-lg">{{ $appointment->appointment_date->format('M d') }}</p>
                            <p class="text-xs text-gray-500">{{ $appointment->appointment_date->format('Y') }}</p>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                            <p class="text-xs text-gray-500 font-semibold">Time</p>
                            <p class="font-bold text-gray-900 text-lg">{{ date('g:i A', strtotime($appointment->appointment_time)) }}</p>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                            <p class="text-xs text-gray-500 font-semibold">End Time</p>
                            <p class="font-bold text-gray-900 text-lg">{{ $appointment->end_time ? date('g:i A', strtotime($appointment->end_time)) : '-' }}</p>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                            <p class="text-xs text-gray-500 font-semibold">Duration</p>
                            <p class="font-bold text-gray-900 text-lg">{{ $appointment->service->duration_minutes }}</p>
                            <p class="text-xs text-gray-500">minutes</p>
                        </div>

                        <div class="bg-emerald-50 rounded-lg p-3 border border-emerald-100">
                            <p class="text-xs text-emerald-600 font-semibold">Dentist</p>
                            <p class="font-bold text-emerald-900 text-sm">{{ $appointment->dentist ? 'Dr. ' . $appointment->dentist->name : 'Not assigned' }}</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('client.appointments.show', $appointment->id) }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center justify-center gap-2 text-sm">
                            <i class="fa-solid fa-eye"></i>
                            View Details
                        </a>
                        @if($appointment->status === 'pending' && $appointment->appointment_date > now())
                            <form method="POST" action="{{ route('client.appointments.cancel', $appointment->id) }}" class="flex-1" onsubmit="return confirm('Are you sure you want to cancel this appointment?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center justify-center gap-2 text-sm">
                                    <i class="fa-solid fa-ban"></i>
                                    Cancel
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

    <!-- Pagination -->
    @if($appointments->hasPages())
        <div class="mt-8">
            {{ $appointments->links() }}
        </div>
    @endif
</div>
@endsection
