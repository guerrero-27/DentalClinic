@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">My Appointments</h1>
        <a href="{{ route('client.appointments.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            Book Appointment
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Service</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Date & Time</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appointment)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $appointment->service->name }}</td>
                        <td class="px-6 py-4">
                            <div>
                                <p>{{ $appointment->appointment_date->format('M d, Y') }}</p>
                                <p class="text-sm text-gray-600">{{ $appointment->appointment_time }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="{{ $appointment->getStatusColorClass() }} px-3 py-1 rounded-full text-sm font-medium">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('client.appointments.show', $appointment->id) }}" class="text-blue-600 hover:text-blue-900 font-medium mr-4">View</a>
                            @if($appointment->status !== 'cancelled' && $appointment->appointment_date > now())
                                <form method="POST" action="{{ route('client.appointments.cancel', $appointment->id) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium" onclick="return confirm('Are you sure?')">Cancel</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            You don't have any appointments yet. 
                            <a href="{{ route('client.appointments.create') }}" class="text-blue-600 hover:text-blue-900">Book one now</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $appointments->links() }}
    </div>
</div>
@endsection
