@extends('layouts.admin')

@section('page-title', 'Dentist Profile')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.dentists.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 text-sm font-medium">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Dentists
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <!-- Header -->
        <div class="p-6 md:p-8 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row items-center gap-6">
                @if($dentist->image)
                    <img src="{{ asset('storage/' . $dentist->image) }}" alt="{{ $dentist->name }}" class="w-28 h-28 rounded-full object-cover border-2 border-gray-200">
                @else
                    <div class="w-28 h-28 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-4xl font-bold border-2 border-gray-300">
                        {{ strtoupper(substr($dentist->name, 0, 1)) }}
                    </div>
                @endif
                <div class="text-center sm:text-left flex-1">
                    <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-4 mb-2">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $dentist->name }}</h2>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium {{ $dentist->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                            <span class="w-2 h-2 rounded-full {{ $dentist->is_active ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                            {{ $dentist->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <p class="text-gray-500">{{ $dentist->email }}</p>
                    <div class="flex flex-wrap justify-center sm:justify-start gap-4 mt-3 text-sm text-gray-600">
                        <span><i class="fa-solid fa-phone mr-1"></i>{{ $dentist->phone ?? 'N/A' }}</span>
                        <span><i class="fa-solid fa-user-injured mr-1"></i>{{ $dentist->dentistAppointments()->where('status', 'confirmed')->count() }} appointments</span>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.dentists.edit', $dentist->id) }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition">
                        <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                    </a>
                </div>
            </div>
        </div>

        <!-- Details -->
        <div class="p-6 md:p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Contact</h4>
                    <p class="text-gray-900">{{ $dentist->phone ?? 'Not set' }}</p>
                </div>
                <div>
                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Address</h4>
                    <p class="text-gray-900">{{ $dentist->address ?? 'Not set' }}</p>
                </div>
                <div>
                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Birthdate</h4>
                    <p class="text-gray-900">{{ $dentist->birthdate?->format('M d, Y') ?? 'Not set' }}</p>
                </div>
                <div>
                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Working Hours</h4>
                    <p class="text-gray-900">
                        @if($dentist->working_start && $dentist->working_end)
                            {{ \Carbon\Carbon::parse($dentist->working_start)->format('g:i A') }} - {{ \Carbon\Carbon::parse($dentist->working_end)->format('g:i A') }}
                        @else
                            Not scheduled
                        @endif
                    </p>
                </div>
                <div>
                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Member Since</h4>
                    <p class="text-gray-900">{{ $dentist->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Appointments -->
        <div class="border-t border-gray-100">
            <div class="p-6 md:p-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Recent Appointments</h3>
                @if($appointments->count() > 0)
                    <div class="space-y-3">
                        @foreach($appointments as $appointment)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $appointment->service->name ?? 'Service' }}</p>
                                    <p class="text-sm text-gray-500">{{ $appointment->appointment_date->format('M d, Y - g:i A') }}</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    @if($appointment->status === 'completed') bg-emerald-100 text-emerald-700
                                    @elseif($appointment->status === 'confirmed') bg-blue-100 text-blue-700
                                    @elseif($appointment->status === 'pending') bg-yellow-100 text-yellow-700
                                    @elseif($appointment->status === 'cancelled') bg-red-100 text-red-700
                                    @else bg-gray-100 text-gray-600
                                    @endif">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        {{ $appointments->links() }}
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No appointments yet</p>
                @endif
            </div>
        </div>
    </div>
@endsection