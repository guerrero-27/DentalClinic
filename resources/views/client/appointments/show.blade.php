@extends('layouts.client')

@section('page-title', 'Appointment Details')

@section('content')
    <div class="mb-6">
        <a href="{{ route('client.appointments.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 transition font-medium text-sm">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to My Appointments</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <!-- Header with Status -->
        <div class="px-6 py-5 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-xl font-bold text-gray-900 mb-1">Appointment Details</h1>
                <p class="text-gray-500 text-sm">ID #{{ $appointment->id }}</p>
            </div>
            <span class="{{ $appointment->getStatusColorClass() }} px-3 py-1 rounded-full text-xs font-bold whitespace-nowrap">
                {{ ucfirst($appointment->status) }}
            </span>
        </div>

        <div class="p-6">
            <!-- Service & Dentist -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <p class="text-xs text-gray-500 font-semibold mb-1">Service</p>
                    <p class="font-bold text-gray-900">{{ $appointment->service->name }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $appointment->service->duration_minutes }} mins</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <p class="text-xs text-gray-500 font-semibold mb-1">Dentist</p>
                    <p class="font-bold text-gray-900">
                        @if($appointment->dentist)
                            Dr. {{ $appointment->dentist->name }}
                        @else
                            <span class="text-gray-400">Not assigned</span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Date & Time -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
                <div class="bg-gray-50 rounded-lg p-3 border border-gray-100 text-center">
                    <p class="text-xs text-gray-500 font-semibold mb-1">Date</p>
                    <p class="font-bold text-gray-900 text-sm">{{ $appointment->appointment_date->format('M d, Y') }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3 border border-gray-100 text-center">
                    <p class="text-xs text-gray-500 font-semibold mb-1">Start Time</p>
                    <p class="font-bold text-gray-900 text-sm">{{ date('g:i A', strtotime($appointment->appointment_time)) }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3 border border-gray-100 text-center">
                    <p class="text-xs text-gray-500 font-semibold mb-1">End Time</p>
                    <p class="font-bold text-gray-900 text-sm">{{ $appointment->end_time ? date('g:i A', strtotime($appointment->end_time)) : '-' }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3 border border-gray-100 text-center">
                    <p class="text-xs text-gray-500 font-semibold mb-1">Price</p>
                    <p class="font-bold text-gray-900 text-sm">₱{{ number_format($appointment->service->price, 2) }}</p>
                </div>
            </div>

            <!-- Notes -->
            @if($appointment->notes)
                <div class="mb-6">
                    <h4 class="text-sm font-semibold text-gray-500 mb-2">Your Notes</h4>
                    <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                        <p class="text-gray-700 text-sm">{{ $appointment->notes }}</p>
                    </div>
                </div>
            @endif

            @if($appointment->admin_notes)
                <div class="mb-6">
                    <h4 class="text-sm font-semibold text-gray-500 mb-2">Admin Notes</h4>
                    <div class="bg-blue-50 rounded-lg p-3 border border-blue-100">
                        <p class="text-gray-700 text-sm">{{ $appointment->admin_notes }}</p>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-100">
                @if(in_array($appointment->status, ['pending', 'confirmed']) && $appointment->appointment_date >= now()->format('Y-m-d'))
                    <a href="{{ route('client.appointments.create') }}?reschedule={{ $appointment->id }}"
                       class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg font-medium transition flex items-center justify-center gap-2 text-sm">
                        <i class="fa-solid fa-calendar-arrow-up"></i>
                        Reschedule
                    </a>
                @endif

                @if($appointment->status === 'pending' && $appointment->appointment_date >= now()->format('Y-m-d'))
                    <form method="POST" action="{{ route('client.appointments.cancel', $appointment->id) }}" class="flex-1">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-lg font-medium transition flex items-center justify-center gap-2 text-sm"
                                onclick="return confirm('Cancel this appointment?')">
                            <i class="fa-solid fa-ban"></i>
                            Cancel Appointment
                        </button>
                    </form>
                @endif

                @if($appointment->status === 'confirmed' && $appointment->appointment_date >= now()->format('Y-m-d'))
                    <div class="flex-1 bg-yellow-50 border border-yellow-200 rounded-lg px-4 py-2.5 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-info-circle text-yellow-600 text-xs"></i>
                        <span class="text-yellow-800 text-xs">Confirmed appointments cannot be cancelled.</span>
                    </div>
                @endif

                <a href="{{ route('client.appointments.index') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2.5 rounded-lg font-medium transition flex items-center justify-center gap-2 text-sm border border-gray-200">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Appointments
                </a>
            </div>
        </div>
    </div>
@endsection