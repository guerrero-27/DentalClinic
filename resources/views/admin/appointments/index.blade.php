@extends('layouts.admin')

@section('page-title', 'Appointments')

@section('content')
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg px-4 py-3 mb-4 md:mb-6 flex items-center gap-2">
            <i class="fa-solid fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 mb-4 md:mb-6">
        <form action="{{ route('admin.appointments.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4">
                <div>
                    <label for="search" class="block text-xs md:text-sm font-semibold mb-1 md:mb-2 text-gray-700">
                        <i class="fa-solid fa-magnifying-glass mr-1 text-gray-400"></i>Search Client
                    </label>
                    <input
                        type="text"
                        name="search"
                        id="search"
                        placeholder="Name or email"
                        class="w-full px-3 md:px-4 py-2 md:py-2.5 text-sm border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 hover:border-gray-300 transition duration-200 ease-in-out"
                        value="{{ request('search') }}"
                    >
                </div>

                {{-- ✅ Animated Status Dropdown --}}
                <div>
                    <label class="block text-xs md:text-sm font-semibold mb-1 md:mb-2 text-gray-700">
                        <i class="fa-solid fa-flag mr-1 text-gray-400"></i>Status
                    </label>

                    <input type="hidden" name="status" id="status-hidden" value="{{ request('status') }}">

                    <div class="relative" id="status-dropdown">
                        
                        <button
                            type="button"
                            onclick="toggleStatusDropdown()"
                            class="w-full px-3 md:px-4 py-2 md:py-2.5 text-sm border-2 border-gray-200 rounded-xl flex items-center justify-between bg-white hover:border-gray-300 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200 ease-in-out"
                            id="status-trigger"
                        >
                            <span id="status-label" class="flex items-center gap-2">
                                @php
                                    $statusLabels = [
                                        'pending'   => ['label' => 'Pending',    'dot' => '#FBBF24'],
                                        'confirmed' => ['label' => 'Confirmed',  'dot' => '#60A5FA'],
                                        'completed' => ['label' => 'Completed',  'dot' => '#34D399'],
                                        'cancelled' => ['label' => 'Cancelled',  'dot' => '#F87171'],
                                    ];
                                    $current = request('status');
                                    $currentLabel = $statusLabels[$current]['label'] ?? 'All Status';
                                    $currentDot   = $statusLabels[$current]['dot']  ?? '#D1D5DB';
                                @endphp
                                <span class="w-2 h-2 rounded-full flex-shrink-0" id="status-dot" style="background: {{ $currentDot }}"></span>
                                <span id="status-text">{{ $currentLabel }}</span>
                            </span>
                            <i id="status-chevron" class="fa-solid fa-chevron-down text-gray-400 transition-transform duration-300"></i>
                        </button>

                        <div
                            id="status-menu"
                            class="absolute z-50 mt-1.5 w-full bg-white border-2 border-blue-400 rounded-xl overflow-hidden shadow-lg
                                   opacity-0 -translate-y-2 scale-y-95 pointer-events-none
                                   transition-all duration-300 ease-in-out origin-top"
                        >
                            @php
                                $options = [
                                    ''          => ['label' => 'All Status', 'dot' => '#D1D5DB'],
                                    'pending'   => ['label' => 'Pending',    'dot' => '#FBBF24'],
                                    'confirmed' => ['label' => 'Confirmed',  'dot' => '#60A5FA'],
                                    'completed' => ['label' => 'Completed',  'dot' => '#34D399'],
                                    'cancelled' => ['label' => 'Cancelled',  'dot' => '#F87171'],
                                ];
                            @endphp
                            @foreach($options as $val => $opt)
                                <div
                                    class="flex items-center gap-2 px-4 py-2.5 text-sm cursor-pointer hover:bg-blue-50 transition-colors duration-150
                                           {{ request('status') === $val ? 'text-blue-600 font-semibold bg-blue-50' : 'text-gray-700' }}"
                                    onclick="selectStatus('{{ $val }}', '{{ $opt['label'] }}', '{{ $opt['dot'] }}')"
                                >
                                    <span class="w-2 h-2 rounded-full flex-shrink-0" style="background: {{ $opt['dot'] }}"></span>
                                    {{ $opt['label'] }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div>
                    <label for="date" class="block text-xs md:text-sm font-semibold mb-1 md:mb-2 text-gray-700">
                        <i class="fa-regular fa-calendar mr-1 text-gray-400"></i>Date
                    </label>
                    <input
                        type="date"
                        name="date"
                        id="date"
                        class="w-full px-3 md:px-4 py-2 md:py-2.5 text-sm border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 hover:border-gray-300 transition duration-200 ease-in-out"
                        value="{{ request('date') }}"
                    >
                </div>

                <div class="flex items-end gap-2">
                    <button
                        type="submit"
                        class="flex-1 sm:flex-none bg-blue-600 text-white px-4 md:px-6 py-2 md:py-2.5 rounded-xl hover:bg-blue-700 font-medium text-sm shadow-lg shadow-blue-200 transition flex items-center justify-center gap-2"
                    >
                        <i class="fa-solid fa-filter"></i>
                        <span class="hidden sm:inline">Filter</span>
                    </button>
                    <a href="{{ route('admin.appointments.index') }}" class="px-3 md:px-4 py-2 md:py-2.5 text-gray-600 hover:bg-gray-100 rounded-xl text-sm transition">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Desktop Table View -->
    <div class="hidden md:block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Client</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Service</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Dentist</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Date & Time</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($appointments as $appointment)
                    <tr class="hover:bg-blue-50/50 transition">
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $appointment->user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $appointment->user->email }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-medium text-gray-800">{{ $appointment->service->name ?? 'Unknown' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-gray-700">{{ $appointment->dentist ? 'Dr. ' . $appointment->dentist->name : 'N/A' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-medium text-gray-900">{{ $appointment->appointment_date->format('M d, Y') }}</p>
                                <p class="text-sm text-gray-500">{{ $appointment->appointment_time }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="{{ $appointment->getStatusColorClass() }} px-3 py-1 rounded-full text-xs font-bold">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.appointments.show', $appointment->id) }}" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-semibold text-sm transition">
                                <i class="fa-solid fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-gray-400">
                                <i class="fa-solid fa-calendar-xmark text-4xl mb-2"></i>
                                <p class="font-medium">No appointments found</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile Card View -->
    <div class="md:hidden space-y-3">
        @forelse($appointments as $appointment)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <p class="font-bold text-gray-900">{{ $appointment->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $appointment->user->email }}</p>
                    </div>
                    <span class="{{ $appointment->getStatusColorClass() }} px-2 py-1 rounded-full text-xs font-bold whitespace-nowrap ml-2">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-2 mb-3 text-sm">
                    <div>
                        <p class="text-gray-500 text-xs">Service</p>
                        <p class="font-semibold text-gray-800">{{ $appointment->service->name ?? 'Unknown' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Date & Time</p>
                        <p class="font-semibold text-gray-800">{{ $appointment->appointment_date->format('M d, Y') }}</p>
                        <p class="text-gray-600 text-xs">{{ $appointment->appointment_time }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.appointments.show', $appointment->id) }}" class="block w-full text-center bg-blue-600 text-white py-2 rounded-lg font-medium text-sm hover:bg-blue-700 transition">
                    <i class="fa-solid fa-eye mr-1"></i> View Details
                </a>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center">
                <div class="text-gray-400">
                    <i class="fa-solid fa-calendar-xmark text-4xl mb-2"></i>
                    <p class="font-medium">No appointments found</p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4 md:mt-6">
        {{ $appointments->links() }}
    </div>

    {{-- ✅ Animated Dropdown Script --}}
    <script>
        function toggleStatusDropdown() {
            const menu = document.getElementById('status-menu');
            const chevron = document.getElementById('status-chevron');
            const isOpen = !menu.classList.contains('pointer-events-none');

            if (isOpen) {
                menu.classList.add('opacity-0', '-translate-y-2', 'scale-y-95', 'pointer-events-none');
                menu.classList.remove('opacity-100', 'translate-y-0', 'scale-y-100');
                chevron.classList.remove('rotate-180');
            } else {
                menu.classList.remove('opacity-0', '-translate-y-2', 'scale-y-95', 'pointer-events-none');
                menu.classList.add('opacity-100', 'translate-y-0', 'scale-y-100');
                chevron.classList.add('rotate-180');
            }
        }

        function selectStatus(value, label, dot) {
            document.getElementById('status-hidden').value = value;
            document.getElementById('status-text').textContent = label;
            document.getElementById('status-dot').style.background = dot;
            toggleStatusDropdown();
        }

        document.addEventListener('click', function (e) {
            const dd = document.getElementById('status-dropdown');
            if (!dd.contains(e.target)) {
                const menu = document.getElementById('status-menu');
                menu.classList.add('opacity-0', '-translate-y-2', 'scale-y-95', 'pointer-events-none');
                menu.classList.remove('opacity-100', 'translate-y-0', 'scale-y-100');
                document.getElementById('status-chevron').classList.remove('rotate-180');
            }
        });
    </script>
@endsection