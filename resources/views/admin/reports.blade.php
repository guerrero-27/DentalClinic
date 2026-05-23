@extends('layouts.admin')
@section('page-title', 'Reports')
@section('page-subtitle')
    <p class="text-sm text-gray-500">Business performance overview</p>
@endsection
@section('content')

    <!-- Key Financial Metrics -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 text-white rounded-2xl p-5 shadow-lg shadow-emerald-200">
            <div class="flex items-center gap-2 mb-2">
                <i class="fa-solid fa-peso-sign text-xl text-emerald-200"></i>
                <span class="text-emerald-200 text-sm font-medium">Revenue</span>
            </div>
            <div class="text-3xl font-bold">₱{{ number_format($totalRevenue, 2) }}</div>
            <div class="text-emerald-200 text-sm mt-1">Total Earned</div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-5">
            <div class="flex items-center gap-2 mb-2">
                <i class="fa-solid fa-calendar-check text-xl text-blue-500"></i>
                <span class="text-gray-500 text-sm font-medium">Appointments</span>
            </div>
            <div class="text-3xl font-bold text-gray-800">{{ $stats['total_appointments'] }}</div>
            <div class="text-gray-500 text-sm mt-1">All Time</div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-5">
            <div class="flex items-center gap-2 mb-2">
                <i class="fa-solid fa-users text-xl text-purple-500"></i>
                <span class="text-gray-500 text-sm font-medium">Active Clients</span>
            </div>
            <div class="text-3xl font-bold text-gray-800">{{ $activeClients }}</div>
            <div class="text-gray-500 text-sm mt-1">With Bookings</div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-5">
            <div class="flex items-center gap-2 mb-2">
                <i class="fa-solid fa-ban text-xl text-red-500"></i>
                <span class="text-gray-500 text-sm font-medium">Cancellation</span>
            </div>
            <div class="text-3xl font-bold text-gray-800">{{ $cancellationRate }}%</div>
            <div class="text-gray-500 text-sm mt-1">Rate</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Monthly Revenue -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="font-bold text-blue-900"><i class="fa-solid fa-coins mr-2 text-yellow-500"></i>Monthly Revenue</h2>
                <p class="text-gray-400 text-xs">Last 6 months earnings</p>
            </div>
            <div class="p-6">
                <div class="flex items-end justify-between h-48 gap-2">
                    @php $maxRevenue = max(array_column($monthlyRevenue, 'revenue')) ?: 1; @endphp
                    @foreach($monthlyRevenue as $data)
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-yellow-100 rounded-t-lg relative group" style="min-height: 4px; height: {{ max($data['revenue'] / $maxRevenue * 160, 8) }}px;">
                                @if($data['revenue'] > 0)
                                    <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-yellow-600 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition whitespace-nowrap">
                                        ₱{{ number_format($data['revenue'], 2) }}
                                    </div>
                                @endif
                                <div class="absolute bottom-0 left-0 right-0 bg-yellow-500 rounded-t-lg" style="height: {{ $data['revenue'] > 0 ? '100%' : '0' }};"></div>
                            </div>
                            <span class="text-xs text-gray-500 mt-2 font-medium">{{ $data['month'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="font-bold text-blue-900"><i class="fa-solid fa-clipboard-list mr-2 text-blue-500"></i>Appointment Summary</h2>
                <p class="text-gray-400 text-xs">Status breakdown</p>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-clock text-yellow-600"></i>
                            </div>
                            <span class="font-medium text-gray-700">Pending</span>
                        </div>
                        <span class="font-bold text-gray-800">{{ $stats['pending'] }}</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-check text-blue-600"></i>
                            </div>
                            <span class="font-medium text-gray-700">Confirmed</span>
                        </div>
                        <span class="font-bold text-gray-800">{{ $stats['confirmed'] }}</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-circle-check text-green-600"></i>
                            </div>
                            <span class="font-medium text-gray-700">Completed</span>
                        </div>
                        <span class="font-bold text-gray-800">{{ $stats['completed'] }}</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-red-50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-ban text-red-600"></i>
                            </div>
                            <span class="font-medium text-gray-700">Cancelled</span>
                        </div>
                        <span class="font-bold text-gray-800">{{ $stats['cancelled'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Revenue Breakdown -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="font-bold text-blue-900"><i class="fa-solid fa-receipt mr-2 text-indigo-500"></i>Service Revenue Breakdown</h2>
            <p class="text-gray-400 text-xs">Earnings per service type</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Service</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Completed Bookings</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Total Revenue</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($serviceBreakdown as $service)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fa-solid fa-stethoscope text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $service->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $service->duration_minutes }} mins</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-800">₱{{ number_format($service->price, 2) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-16 bg-gray-100 rounded-full h-1.5">
                                        <div class="bg-blue-500 h-1.5 rounded-full" style="width: {{ $stats['completed'] > 0 ? min($service->appointments_count / $stats['completed'] * 100, 100) : 0 }}%;"></div>
                                    </div>
                                    <span class="font-semibold text-gray-800">{{ $service->appointments_count }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-emerald-600">₱{{ number_format($service->revenue, 2) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                                <i class="fa-solid fa-face-meh text-4xl mb-2"></i>
                                <p>No service data yet</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection