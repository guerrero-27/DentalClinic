@extends('layouts.app')
@section('title', 'Book Appointment')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-blue-900 mb-2">Book an Appointment</h1>
    <p class="text-gray-500 mb-8">Fill in the details below to schedule your visit.</p>

    <form action="{{ route('client.appointments.store') }}" method="POST" class="bg-white rounded-2xl border border-blue-100 shadow-sm p-8 space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Select Service</label>
            <select name="service_id" class="w-full border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500" required>
                <option value="">-- Choose a Service --</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                        {{ $service->name }} — ₱{{ number_format($service->price, 2) }} ({{ $service->duration_minutes }} mins)
                    </option>
                @endforeach
            </select>
            @error('service_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Preferred Date</label>
                <input type="date" name="appointment_date" value="{{ old('appointment_date') }}"
                    min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                    class="w-full border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500" required>
                @error('appointment_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Preferred Time</label>
                <select name="appointment_time" class="w-full border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">-- Choose Time --</option>
                    @foreach(['08:00', '09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'] as $time)
                        <option value="{{ $time }}" {{ old('appointment_time') == $time ? 'selected' : '' }}>
                            {{ date('g:i A', strtotime($time)) }}
                        </option>
                    @endforeach
                </select>
                @error('appointment_time') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Notes / Concerns (Optional)</label>
            <textarea name="notes" rows="3" placeholder="Describe your dental concern..."
                class="w-full border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">{{ old('notes') }}</textarea>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700 transition">
                Book Appointment
            </button>
            <a href="{{ route('client.dashboard') }}" class="flex-1 text-center border border-gray-300 text-gray-600 py-3 rounded-xl font-semibold hover:bg-gray-50 transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection