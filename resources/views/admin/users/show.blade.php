@extends('layouts.admin')
@section('page-title', 'Client Details')
@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-900">← Back to Clients</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
                <p class="text-gray-600">{{ $user->email }}</p>
            </div>
            <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg font-semibold">Client</span>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-600">Phone</p>
                <p class="font-semibold">{{ $user->phone ?? 'Not provided' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Member Since</p>
                <p class="font-semibold">{{ $user->created_at->format('M d, Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Total Appointments</p>
                <p class="font-semibold">{{ $user->appointments()->count() }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Status</p>
                <p class="font-semibold">
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">Active</span>
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold mb-4">Appointment History</h2>

        @if($appointments->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Service</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Date</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Time</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $appointment->service->name ?? 'Unknown' }}</td>
                                <td class="px-6 py-4">{{ $appointment->appointment_date->format('M d, Y') }}</td>
                                <td class="px-6 py-4">{{ $appointment->appointment_time }}</td>
                                <td class="px-6 py-4">
                                    <span class="{{ $appointment->getStatusColorClass() }} px-3 py-1 rounded-full text-sm font-medium">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ Str::limit($appointment->notes ?? 'No notes', 50) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $appointments->links() }}
            </div>
        @else
            <p class="text-gray-500">No appointments found for this client.</p>
        @endif
    </div>
</div>
@endsection
