@extends('layouts.client')

@section('page-title', 'Appointment Details')

@section('content')
    <div class="mb-6">
        <a href="{{ route('client.appointments.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 transition font-medium text-sm">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to My Appointments</span>
        </a>
    </div>

    <div class="space-y-6">
        <!-- Header Card with Status -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-5">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold text-white mb-1">Appointment Details</h1>
                        <p class="text-blue-200 text-sm">
                            <i class="fa-solid fa-hashtag mr-1"></i>ID #{{ $appointment->id }}
                        </p>
                    </div>
                    <span class="{{ $appointment->getStatusColorClass() }} px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                        <i class="fa-solid fa-circle mr-1 text-xs"></i>
                        {{ ucfirst($appointment->status) }}
                    </span>
                </div>
            </div>

            <div class="p-6">
                <!-- Service & Dentist Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4 border border-blue-100">
                        <p class="text-xs text-blue-600 font-semibold mb-1 uppercase tracking-wider flex items-center gap-1">
                            <i class="fa-solid fa-tooth"></i> Service
                        </p>
                        <p class="text-xl font-bold text-blue-900">{{ $appointment->service->name }}</p>
                        <p class="text-sm text-blue-700 mt-1">
                            {{ $appointment->service->duration_minutes }} mins + {{ $appointment->service->buffer_minutes ?? 10 }} min buffer
                        </p>
                    </div>
                    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-xl p-4 border border-emerald-100">
                        <p class="text-xs text-emerald-600 font-semibold mb-1 uppercase tracking-wider flex items-center gap-1">
                            <i class="fa-solid fa-user-doctor"></i> Dentist
                        </p>
                        <p class="text-xl font-bold text-emerald-900">
                            @if($appointment->dentist)
                                Dr. {{ $appointment->dentist->name }}
                            @else
                                <span class="text-gray-400">Not assigned</span>
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Schedule Details -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
                    <div class="bg-purple-50 rounded-lg p-4 border border-purple-100 text-center">
                        <i class="fa-solid fa-calendar text-purple-600 mb-2"></i>
                        <p class="text-xs text-gray-500 font-medium">Date</p>
                        <p class="font-bold text-gray-900">{{ $appointment->appointment_date->format('M d, Y') }}</p>
                    </div>
                    <div class="bg-amber-50 rounded-lg p-4 border border-amber-100 text-center">
                        <i class="fa-solid fa-clock text-amber-600 mb-2"></i>
                        <p class="text-xs text-gray-500 font-medium">Start Time</p>
                        <p class="font-bold text-gray-900">{{ date('g:i A', strtotime($appointment->appointment_time)) }}</p>
                    </div>
                    <div class="bg-orange-50 rounded-lg p-4 border border-orange-100 text-center">
                        <i class="fa-solid fa-clock text-orange-600 mb-2"></i>
                        <p class="text-xs text-gray-500 font-medium">End Time</p>
                        <p class="font-bold text-gray-900">{{ $appointment->end_time ? date('g:i A', strtotime($appointment->end_time)) : '-' }}</p>
                    </div>
                    <div class="bg-emerald-50 rounded-lg p-4 border border-emerald-100 text-center">
                        <i class="fa-solid fa-peso-sign text-emerald-600 mb-2"></i>
                        <p class="text-xs text-gray-500 font-medium">Price</p>
                        <p class="font-bold text-emerald-700">₱{{ number_format($appointment->service->price, 2) }}</p>
                    </div>
                </div>

                <!-- Notes -->
                @if($appointment->notes)
                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-2">
                            <i class="fa-solid fa-comment text-yellow-600"></i> Your Notes
                        </h4>
                        <div class="bg-yellow-50 rounded-xl p-4 border border-yellow-100">
                            <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $appointment->notes }}</p>
                        </div>
                    </div>
                @endif

                @if($appointment->admin_notes)
                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-2">
                            <i class="fa-solid fa-pen text-blue-600"></i> Admin Notes
                        </h4>
                        <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                            <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $appointment->admin_notes }}</p>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-100">
                    {{-- Reschedule: Both pending and confirmed appointments can be rescheduled --}}
                    @if(in_array($appointment->status, ['pending', 'confirmed']) && $appointment->appointment_date >= now()->format('Y-m-d'))
                        <a href="{{ route('client.appointments.create') }}?reschedule={{ $appointment->id }}"
                           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-calendar-arrow-up"></i>
                            Reschedule
                        </a>
                    @endif

                    {{-- Cancel: ONLY pending appointments can be cancelled --}}
                    @if($appointment->status === 'pending' && $appointment->appointment_date >= now()->format('Y-m-d'))
                        <form method="POST" action="{{ route('client.appointments.cancel', $appointment->id) }}" class="flex-1">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-semibold transition flex items-center justify-center gap-2"
                                    onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                <i class="fa-solid fa-ban"></i>
                                Cancel Appointment
                            </button>
                        </form>
                    @endif

                    {{-- Show message if confirmed and in the future --}}
                    @if($appointment->status === 'confirmed' && $appointment->appointment_date >= now()->format('Y-m-d'))
                        <div class="flex-1 bg-amber-50 border border-amber-200 rounded-xl px-6 py-3 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-info-circle text-amber-600"></i>
                            <span class="text-amber-800 font-medium text-sm">Confirmed appointments cannot be cancelled. Please reschedule instead.</span>
                        </div>
                    @endif

                    <a href="{{ route('client.appointments.index') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold transition flex items-center justify-center gap-2 border border-gray-200">
                        <i class="fa-solid fa-arrow-left"></i>
                        Back to Appointments
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection