@extends('layouts.admin')

@section('page-title', 'Appointment Details')

@section('content')
    <!-- Page Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.appointments.index') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-900 font-medium transition mb-2 text-sm">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to Appointments</span>
            </a>
            <h1 class="text-2xl font-bold text-slate-900">Appointment Details</h1>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Appointment Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Header Card -->
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 px-6 py-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-2">Appointment ID</p>
                            <h1 class="text-2xl font-bold text-white mb-1">#{{ $appointment->id }}</h1>
                            <p class="text-slate-300 text-sm">{{ $appointment->appointment_date->format('l, F j, Y') }} at {{ date('g:i A', strtotime($appointment->appointment_time)) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-slate-400 text-xs font-semibold mb-2 uppercase tracking-wider">Status</p>
                            <span class="{{ $appointment->getStatusColorClass() }} px-4 py-2 rounded-full text-sm font-semibold">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Client Information Section -->
                    <div class="mb-6">
                        <h3 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-user text-slate-400"></i> Client Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-slate-50 rounded-lg p-4 border border-slate-100">
                                <p class="text-xs text-slate-500 font-medium mb-1">Full Name</p>
                                <p class="text-base font-semibold text-slate-900">{{ $appointment->user->name }}</p>
                            </div>
                            <div class="bg-slate-50 rounded-lg p-4 border border-slate-100">
                                <p class="text-xs text-slate-500 font-medium mb-1">Email Address</p>
                                <p class="text-base font-medium text-slate-900 break-all">{{ $appointment->user->email }}</p>
                            </div>
                            <div class="bg-slate-50 rounded-lg p-4 border border-slate-100">
                                <p class="text-xs text-slate-500 font-medium mb-1">Phone Number</p>
                                <p class="text-base font-medium text-slate-900">{{ $appointment->user->phone ?? '—' }}</p>
                            </div>
                            <div class="bg-indigo-50 rounded-lg p-4 border border-indigo-100">
                                <p class="text-xs text-indigo-600 font-medium mb-1">Service</p>
                                <p class="text-base font-bold text-indigo-900">{{ $appointment->service->name }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 my-6"></div>

                    <!-- Appointment Schedule Section -->
                    <div class="mb-6">
                        <h3 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-calendar-alt text-slate-400"></i> Schedule & Details
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                            <!-- Date -->
                            <div class="bg-slate-50 rounded-lg p-4 border border-slate-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-slate-200 rounded-lg flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-calendar text-slate-500"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs text-slate-500 font-medium">Date</p>
                                        <p class="text-sm font-semibold text-slate-900 truncate">{{ $appointment->appointment_date->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Start Time -->
                            <div class="bg-slate-50 rounded-lg p-4 border border-slate-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-slate-200 rounded-lg flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-clock text-slate-500"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs text-slate-500 font-medium">Start Time</p>
                                        <p class="text-sm font-semibold text-slate-900">{{ date('g:i A', strtotime($appointment->appointment_time)) }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- End Time -->
                            <div class="bg-slate-50 rounded-lg p-4 border border-slate-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-slate-200 rounded-lg flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-clock text-slate-500"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs text-slate-500 font-medium">End Time</p>
                                        <p class="text-sm font-semibold text-slate-900">{{ $appointment->end_time ? date('g:i A', strtotime($appointment->end_time)) : '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Duration -->
                            <div class="bg-slate-50 rounded-lg p-4 border border-slate-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-slate-200 rounded-lg flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-hourglass-half text-slate-500"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs text-slate-500 font-medium">Duration</p>
                                        <p class="text-sm font-semibold text-slate-900">{{ $appointment->service->duration_minutes }} min</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Dentist -->
                            <div class="bg-slate-50 rounded-lg p-4 border border-slate-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-slate-200 rounded-lg flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-user-doctor text-slate-500"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs text-slate-500 font-medium">Dentist</p>
                                        <p class="text-sm font-semibold text-slate-900 truncate">{{ $appointment->dentist ? 'Dr. ' . $appointment->dentist->name : 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Price -->
                            <div class="bg-slate-50 rounded-lg p-4 border border-slate-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-slate-200 rounded-lg flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-peso-sign text-slate-500"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs text-slate-500 font-medium">Price</p>
                                        <p class="text-sm font-semibold text-slate-900">₱{{ number_format($appointment->service->price, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Service Description -->
                    @if($appointment->service->description)
                        <div class="border-t border-slate-100 my-6"></div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-info-circle text-slate-400"></i> Service Description
                            </h3>
                            <p class="text-slate-600 leading-relaxed text-sm">{{ $appointment->service->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Notes Card -->
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-comment text-slate-500"></i>
                        <h3 class="text-sm font-semibold text-slate-700">Client Notes</h3>
                    </div>
                </div>
                <div class="p-6">
                    @if($appointment->notes)
                        <div class="bg-slate-50 rounded-lg p-4 border border-slate-100">
                            <p class="text-slate-600 leading-relaxed whitespace-pre-wrap text-sm">{{ $appointment->notes }}</p>
                        </div>
                    @else
                        <div class="text-center py-6 text-slate-400">
                            <i class="fa-solid fa-note-sticky text-2xl mb-2"></i>
                            <p class="text-sm">No notes provided by the client</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Admin Notes Display -->
            @if($appointment->admin_notes)
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-pen text-slate-500"></i>
                        <h3 class="text-sm font-semibold text-slate-700">Admin Notes</h3>
                        <span class="text-xs text-slate-400">· Updated {{ $appointment->updated_at->format('M d, Y H:i') }}</span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="bg-amber-50 rounded-lg p-4 border border-amber-100">
                        <p class="text-slate-700 leading-relaxed whitespace-pre-wrap text-sm">{{ $appointment->admin_notes }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Update Status Section -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Status Update Form -->
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 px-6 py-4">
                    <h2 class="text-base font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-sliders-h"></i>
                        Manage Appointment
                    </h2>
                </div>

                <form action="{{ route('admin.appointments.status', $appointment->id) }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Change Status
                        </label>

                        <input type="hidden" name="status" id="status-hidden" value="{{ $appointment->status }}">

                        <div class="relative" id="status-dropdown">
                            <button
                                type="button"
                                onclick="toggleStatusDropdown()"
                                id="status-trigger"
                                class="w-full px-4 py-3 border-2 border-slate-200 rounded-lg flex items-center justify-between bg-white hover:border-slate-300 focus:outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200 transition duration-200 ease-in-out text-left"
                            >
                                <span id="status-label" class="flex items-center gap-2 text-sm">
                                    @php
                                        $statusOptions = [
                                            'pending'   => ['label' => 'Pending',   'color' => 'amber'],
                                            'confirmed' => ['label' => 'Confirmed',  'color' => 'blue'],
                                            'completed' => ['label' => 'Completed', 'color' => 'emerald'],
                                            'cancelled' => ['label' => 'Cancelled',  'color' => 'red'],
                                        ];
                                        $current = $appointment->status;
                                        $currentInfo = $statusOptions[$current] ?? ['label' => 'Select Status', 'color' => 'slate'];
                                    @endphp
                                    <span id="status-text">{{ $currentInfo['label'] }}</span>
                                </span>
                                <i id="status-chevron" class="fa-solid fa-chevron-down text-slate-400 transition-transform duration-300"></i>
                            </button>

                            <div
                                id="status-menu"
                                class="absolute z-50 mt-1.5 w-full bg-white border-2 border-slate-300 rounded-xl overflow-hidden shadow-lg
                                       opacity-0 -translate-y-2 scale-y-95 pointer-events-none
                                       transition-all duration-300 ease-in-out origin-top"
                            >
                                @php
                                    $allOptions = [
                                        'pending'   => ['label' => 'Pending',   'color' => 'amber'],
                                        'confirmed' => ['label' => 'Confirmed',  'color' => 'blue'],
                                        'completed' => ['label' => 'Completed', 'color' => 'emerald'],
                                        'cancelled' => ['label' => 'Cancelled',  'color' => 'red'],
                                    ];
                                @endphp
                                @foreach($allOptions as $val => $opt)
                                    <div
                                        class="flex items-center gap-2 px-4 py-3 text-sm cursor-pointer hover:bg-slate-50 transition-colors duration-150
                                               {{ $appointment->status === $val ? 'bg-slate-100 font-semibold text-slate-900' : 'text-slate-700' }}"
                                        onclick="selectStatus('{{ $val }}', '{{ $opt['label'] }}')"
                                    >
                                        {{ $opt['label'] }}
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @error('status')
                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="border-t border-slate-100"></div>

                    <div>
                        <label for="admin_notes" class="block text-sm font-semibold text-slate-700 mb-2">
                            Internal Notes
                        </label>
                        <textarea
                            name="admin_notes"
                            id="admin_notes"
                            rows="4"
                            class="w-full px-4 py-3 border-2 border-slate-200 rounded-lg focus:outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200 hover:border-slate-300 transition duration-200 ease-in-out resize-none text-sm"
                            placeholder="Add private notes about this appointment..."
                        >{{ $appointment->admin_notes }}</textarea>
                        @error('admin_notes')
                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-sky-700 hover:bg-slate-700 text-white px-4 py-3 rounded-lg font-semibold transition flex items-center justify-center gap-2 text-sm"
                    >
                        <i class="fa-solid fa-check"></i>
                        Save Changes
                    </button>
                </form>
            </div>

            <!-- Quick Info Card -->
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-100">
                    <h3 class="text-sm font-semibold text-slate-700">Appointment Info</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-500">Created</span>
                        <span class="font-medium text-slate-900">{{ $appointment->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm border-t border-slate-100 pt-4">
                        <span class="text-slate-500">Last Updated</span>
                        <span class="font-medium text-slate-900">{{ $appointment->updated_at->format('M d, Y H:i') }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm border-t border-slate-100 pt-4">
                        <span class="text-slate-500">Client ID</span>
                        <span class="font-medium text-slate-900">#{{ $appointment->user->id }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm border-t border-slate-100 pt-4">
                        <span class="text-slate-500">Service ID</span>
                        <span class="font-medium text-slate-900">#{{ $appointment->service->id }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

        function selectStatus(value, label) {
            document.getElementById('status-hidden').value = value;
            document.getElementById('status-text').textContent = label;
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