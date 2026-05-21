@extends('layouts.admin')
@section('page-title', 'Appointment Details')
@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.appointments.index') }}" class="text-blue-600 hover:text-blue-900">← Back to Appointments</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Appointment Details -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6 mb-6">
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
                        <p class="text-sm text-gray-600 mb-1">Client Name</p>
                        <p class="text-lg font-semibold">{{ $appointment->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Client Email</p>
                        <p class="text-lg font-semibold">{{ $appointment->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Client Phone</p>
                        <p class="text-lg font-semibold">{{ $appointment->user->phone ?? 'Not provided' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Service</p>
                        <p class="text-lg font-semibold">{{ $appointment->service->name }}</p>
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
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Duration</p>
                        <p class="text-lg font-semibold">{{ $appointment->service->duration_minutes }} minutes</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Price</p>
                        <p class="text-lg font-semibold">₱{{ number_format($appointment->service->price, 2) }}</p>
                    </div>
                </div>

                <hr class="my-6">

                <div>
                    <p class="text-sm text-gray-600 mb-1">Client Notes</p>
                    <p class="text-base">{{ $appointment->notes ?? 'No notes provided' }}</p>
                </div>
            </div>
        </div>

        <!-- Update Status Section -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Update Status</h2>

                <form action="{{ route('admin.appointments.status', $appointment->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label for="status" class="block text-sm font-semibold mb-2">Status</label>
                        <select 
                            name="status" 
                            id="status"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('status') border-red-500 @enderror"
                            required
                        >
                            <option value="">Select Status</option>
                            <option value="pending" {{ $appointment->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $appointment->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="completed" {{ $appointment->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $appointment->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="admin_notes" class="block text-sm font-semibold mb-2">Admin Notes</label>
                        <textarea 
                            name="admin_notes" 
                            id="admin_notes"
                            rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('admin_notes') border-red-500 @enderror"
                            placeholder="Add notes about this appointment..."
                        >{{ $appointment->admin_notes }}</textarea>
                        @error('admin_notes')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <button 
                        type="submit" 
                        class="w-full bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-medium"
                    >
                        Update Appointment
                    </button>
                </form>
            </div>

            @if($appointment->admin_notes)
                <div class="bg-white rounded-lg shadow p-6 mt-6">
                    <h3 class="font-bold mb-2">Admin Notes</h3>
                    <p class="text-gray-700">{{ $appointment->admin_notes }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
