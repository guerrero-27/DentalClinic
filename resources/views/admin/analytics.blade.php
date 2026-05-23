@extends('layouts.admin')
@section('page-title', 'Analytics')
@section('page-subtitle')
    <p class="text-sm text-gray-500">Clinic performance insights</p>
@endsection
@section('content')

    <!-- Key Metrics -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-2xl p-5 shadow-lg shadow-blue-200">
            <div class="flex items-center justify-between mb-2">
                <i class="fa-solid fa-chart-line text-2xl text-blue-200"></i>
                @if($growthRate > 0)
                    <span class="text-xs bg-green-500/30 px-2 py-1 rounded-full">+{{ $growthRate }}%</span>
                @elseif($growthRate < 0)
                    <span class="text-xs bg-red-500/30 px-2 py-1 rounded-full">{{ $growthRate }}%</span>
                @endif
            </div>
            <div class="text-3xl font-bold">{{ $thisMonth }}</div>
            <div class="text-blue-200 text-sm mt-1">Appointments This Month</div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-5">
            <div class="flex items-center justify-between mb-2">
                <i class="fa-solid fa-calendar-week text-2xl text-purple-500"></i>
                <span class="text-xs text-gray-500">vs last month</span>
            </div>
            <div class="text-3xl font-bold text-gray-800">{{ $weeklyAppointments }}</div>
            <div class="text-gray-500 text-sm mt-1">This Week</div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-5">
            <div class="flex items-center justify-between mb-2">
                <i class="fa-solid fa-users text-2xl text-emerald-500"></i>
            </div>
            <div class="text-3xl font-bold text-gray-800">{{ $statusCounts['completed'] }}</div>
            <div class="text-gray-500 text-sm mt-1">Completed</div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-5">
            <div class="flex items-center justify-between mb-2">
                <i class="fa-solid fa-clock text-2xl text-yellow-500"></i>
            </div>
            <div class="text-3xl font-bold text-gray-800">{{ $statusCounts['pending'] }}</div>
            <div class="text-gray-500 text-sm mt-1">Pending</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Monthly Appointment Trends -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="font-bold text-blue-900"><i class="fa-solid fa-chart-line mr-2 text-blue-500"></i>Monthly Appointments</h2>
                <p class="text-gray-400 text-xs">Last 6 months trend</p>
            </div>
            <div class="p-6">
                <div class="flex items-end justify-between h-48 gap-2">
                    @foreach($monthlyData as $data)
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-blue-100 rounded-t-lg relative group" style="min-height: 4px; height: {{ max($data['count'] * 10, 8) }}px;">
                                @if($data['count'] > 0)
                                    <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-blue-600 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition whitespace-nowrap">
                                        {{ $data['count'] }} appointments
                                    </div>
                                @endif
                                <div class="absolute bottom-0 left-0 right-0 bg-blue-500 rounded-t-lg" style="height: {{ $data['count'] > 0 ? '100%' : '0' }};"></div>
                            </div>
                            <span class="text-xs text-gray-500 mt-2 font-medium">{{ $data['month'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Appointments by Status -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="font-bold text-blue-900"><i class="fa-solid fa-pie-chart mr-2 text-blue-500"></i>Appointments by Status</h2>
                <p class="text-gray-400 text-xs">Distribution overview</p>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @php
                        $total = array_sum($statusCounts);
                        $colors = [
                            'pending' => 'bg-yellow-500',
                            'confirmed' => 'bg-blue-500',
                            'completed' => 'bg-green-500',
                            'cancelled' => 'bg-red-500',
                        ];
                        $labels = [
                            'pending' => 'Pending',
                            'confirmed' => 'Confirmed',
                            'completed' => 'Completed',
                            'cancelled' => 'Cancelled',
                        ];
                    @endphp
                    @foreach($statusCounts as $status => $count)
                        @if($count > 0)
                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-sm font-medium text-gray-700 flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full {{ $colors[$status] }}"></span>
                                        {{ $labels[$status] }}
                                    </span>
                                    <span class="text-sm font-bold text-gray-800">{{ $count }}</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2.5">
                                    <div class="h-2.5 rounded-full {{ $colors[$status] }} transition-all duration-500"
                                         style="width: {{ $total > 0 ? ($count / $total * 100) : 0 }}%;"></div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 text-center">
                    <span class="text-2xl font-bold text-gray-800">{{ $total }}</span>
                    <p class="text-gray-500 text-sm">Total Appointments</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Services -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="font-bold text-blue-900"><i class="fa-solid fa-star mr-2 text-yellow-500"></i>Top Services</h2>
            <p class="text-gray-400 text-xs">Most booked by clients</p>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($topServices as $index => $service)
                <div class="px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-sm">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">{{ $service->name }}</p>
                            <p class="text-xs text-gray-500">₱{{ number_format($service->price, 2) }} · {{ $service->duration_minutes }} mins</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-gray-800">{{ $service->appointments_count }}</p>
                        <p class="text-xs text-gray-500">bookings</p>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-gray-400">
                    <i class="fa-solid fa-face-meh text-4xl mb-2"></i>
                    <p>No service data yet</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection