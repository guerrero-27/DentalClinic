@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('client.appointments.index') }}" class="text-blue-600 hover:text-blue-900">← Back to My Appointments</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-3xl font-bold mb-2">Appointment Details</h1>
                <p class="text-gray-600">ID: #{{ $appointment->id }}</p>
            </div>
            <span class="{{ $appointment->getStatusColorClass() }} px-4 py-2 rounded-lg font-semibold">
                {{ ucfirst($appointment->status) }}
            </span>
        </div>

        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <p class="text-sm text-gray-600 mb-1">Service</p>
                <p class="text-lg font-semibold">{{ $appointment->service->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Price</p>
                <p class="text-lg font-semibold">₱{{ number_format($appointment->service->price, 2) }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Duration</p>
                <p class="text-lg font-semibold">{{ $appointment->service->duration_minutes }} minutes</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Service Description</p>
                <p class="text-lg font-semibold">{{ $appointment->service->description ?? 'N/A' }}</p>
            </div>
        </div>

        <hr class="my-6">

        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <p class="text-sm text-gray-600 mb-1">Appointment Date</p>
                <p class="text-lg font-semibold">{{ $appointment->appointment_date->format('M d, Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Appointment Time</p>
                <p class="text-lg font-semibold">{{ $appointment->appointment_time }}</p>
            </div>
        </div>

        @if($appointment->notes)
            <hr class="my-6">
            <div class="mb-6">
                <p class="text-sm text-gray-600 mb-2">Your Notes</p>
                <p class="text-base">{{ $appointment->notes }}</p>
            </div>
        @endif

        @if($appointment->admin_notes)
            <hr class="my-6">
            <div class="mb-6 bg-blue-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600 mb-2">Admin Notes</p>
                <p class="text-base">{{ $appointment->admin_notes }}</p>
            </div>
        @endif

        <hr class="my-6">

        <div class="flex gap-4">
            @if($appointment->status !== 'cancelled' && $appointment->appointment_date > now())
                <form method="POST" action="{{ route('client.appointments.cancel', $appointment->id) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 font-medium" onclick="return confirm('Are you sure you want to cancel this appointment?')">
                        Cancel Appointment
                    </button>
                </form>
            @endif
            <a href="{{ route('client.appointments.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 font-medium">
                Back
            </a>
        </div>
    </div>
</div>
@endsection
