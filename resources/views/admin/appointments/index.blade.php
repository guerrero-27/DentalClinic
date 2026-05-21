@extends('layouts.admin')
@section('page-title', 'Appointments')
@section('content')
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form action="{{ route('admin.appointments.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-semibold mb-2">Search Client</label>
                <input 
                    type="text" 
                    name="search" 
                    id="search"
                    placeholder="Name or email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                    value="{{ request('search') }}"
                >
            </div>

            <div>
                <label for="status" class="block text-sm font-semibold mb-2">Status</label>
                <select 
                    name="status" 
                    id="status"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                >
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div>
                <label for="date" class="block text-sm font-semibold mb-2">Date</label>
                <input 
                    type="date" 
                    name="date" 
                    id="date"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                    value="{{ request('date') }}"
                >
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">&nbsp;</label>
                <button 
                    type="submit" 
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 font-medium"
                >
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Appointments Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Client</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Service</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Date & Time</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appointment)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-semibold">{{ $appointment->user->name }}</p>
                                <p class="text-sm text-gray-600">{{ $appointment->user->email }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">{{ $appointment->service->name ?? 'Unknown' }}</td>
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
                            <a href="{{ route('admin.appointments.show', $appointment->id) }}" class="text-blue-600 hover:text-blue-900 font-medium">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No appointments found.</td>
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
