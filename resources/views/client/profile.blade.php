@extends('layouts.client')

@section('page-title', 'My Profile')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">My Profile</h1>
        <p class="text-gray-500 mt-1">Manage your personal information</p>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-3 mb-6 flex items-center gap-2">
            <i class="fa-solid fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-5">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-user text-white text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">{{ $user->name }}</h2>
                            <p class="text-blue-200 text-sm">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('client.profile.update') }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fa-solid fa-user mr-1 text-gray-400"></i> Full Name
                            </label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 hover:border-gray-300 transition">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fa-solid fa-envelope mr-1 text-gray-400"></i> Email Address
                            </label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 hover:border-gray-300 transition">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fa-solid fa-phone mr-1 text-gray-400"></i> Phone Number
                            </label>
                            <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                                placeholder="(Optional)"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 hover:border-gray-300 transition">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fa-solid fa-cake-candles mr-1 text-gray-400"></i> Birthdate
                            </label>
                            <input type="date" name="birthdate" value="{{ old('birthdate', $user->birthdate?->format('Y-m-d')) }}"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 hover:border-gray-300 transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fa-solid fa-location-dot mr-1 text-gray-400"></i> Address
                        </label>
                        <textarea name="address" rows="2" placeholder="(Optional)"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 hover:border-gray-300 transition resize-none">{{ old('address', $user->address) }}</textarea>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-200 flex items-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-chart-simple text-blue-500"></i> Appointment Stats
                    </h3>
                </div>
                <div class="p-4 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm flex items-center gap-2">
                            <i class="fa-solid fa-calendar text-gray-400"></i> Total
                        </span>
                        <span class="font-bold text-gray-900">{{ $stats['total'] }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                        <span class="text-yellow-600 text-sm flex items-center gap-2">
                            <i class="fa-solid fa-clock text-yellow-500"></i> Pending
                        </span>
                        <span class="font-bold text-yellow-600">{{ $stats['pending'] }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                        <span class="text-blue-600 text-sm flex items-center gap-2">
                            <i class="fa-solid fa-check text-blue-500"></i> Confirmed
                        </span>
                        <span class="font-bold text-blue-600">{{ $stats['confirmed'] }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                        <span class="text-emerald-600 text-sm flex items-center gap-2">
                            <i class="fa-solid fa-circle-check text-emerald-500"></i> Completed
                        </span>
                        <span class="font-bold text-emerald-600">{{ $stats['completed'] }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                        <span class="text-red-600 text-sm flex items-center gap-2">
                            <i class="fa-solid fa-ban text-red-500"></i> Cancelled
                        </span>
                        <span class="font-bold text-red-600">{{ $stats['cancelled'] }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left text-gray-500"></i> Recent Activity
                    </h3>
                </div>
                <div class="divide-y divide-gray-50">
                    @forelse($recentAppointments as $apt)
                    <div class="p-4 hover:bg-gray-50 transition">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">{{ $apt->service->name ?? 'Unknown' }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $apt->appointment_date->format('M d, Y') }}</p>
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $apt->getStatusColorClass() }}">
                                {{ ucfirst($apt->status) }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="p-6 text-center text-gray-400">
                        <i class="fa-solid fa-calendar-xmark text-2xl mb-2"></i>
                        <p class="text-sm">No appointments yet</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-gray-500"></i> Account Info
                    </h3>
                </div>
                <div class="p-4 space-y-3">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">Member Since</span>
                        <span class="font-medium text-gray-900">{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm pt-3 border-t border-gray-100">
                        <span class="text-gray-500">Role</span>
                        <span class="px-2 py-0.5 bg-blue-50 text-blue-700 rounded-full text-xs font-semibold">Client</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection