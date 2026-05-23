@extends('layouts.client')

@section('page-title', 'Book Appointment')

@section('content')
    <div class="mb-6">
        <a href="{{ route('client.appointments.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 font-medium transition mb-3 text-sm">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Appointments</span>
        </a>
        <h1 class="text-2xl font-bold text-gray-900 mb-1">Book an Appointment</h1>
        <p class="text-gray-500">Fill in the details below to schedule your visit.</p>
    </div>

    <div class="max-w-2xl">
        <form action="{{ route('client.appointments.store') }}" method="POST" id="booking-form" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 md:p-8 space-y-6">
            @csrf
            <input type="hidden" id="submission-token" name="submission_token" value="">

            <!-- Service Selection -->
            <div>
                <label class="block text-sm font-semibold mb-2 text-gray-700">
                    <i class="fa-solid fa-tooth mr-1 text-gray-400"></i>Select Service
                </label>
                <input type="hidden" name="service_id" id="service-id-hidden" value="{{ old('service_id') }}">
                <div class="relative" id="service-dropdown">
                    <button type="button" onclick="toggleServiceDropdown()" class="w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-xl flex items-center justify-between bg-white hover:border-gray-300 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition" id="service-trigger">
                        <span id="service-label" class="flex items-center gap-2 text-gray-500">
                            @php $selectedService = old('service_id') ? $services->find(old('service_id')) : null; @endphp
                            <span id="service-text" class="{{ $selectedService ? 'text-gray-900' : '' }}">{{ $selectedService ? $selectedService->name . ' — ₱' . number_format($selectedService->price, 2) : '-- Choose a Service --' }}</span>
                        </span>
                        <i id="service-chevron" class="fa-solid fa-caret-down text-blue-600 text-lg transition-transform duration-300"></i>
                    </button>
                    <div id="service-menu" class="absolute z-50 mt-1.5 w-full bg-white border-2 border-blue-400 rounded-xl overflow-hidden shadow-lg opacity-0 -translate-y-2 scale-y-95 pointer-events-none transition-all duration-300 ease-in-out origin-top">
                        <div class="py-1 max-h-60 overflow-auto">
                            @foreach($services as $service)
                                <div class="flex items-center justify-between px-4 py-3 text-sm cursor-pointer hover:bg-blue-50 transition-colors duration-150 {{ old('service_id') == $service->id ? 'text-blue-600 font-semibold bg-blue-50' : 'text-gray-700' }}"
                                     onclick="selectService('{{ $service->id }}', '{{ $service->name }} — ₱{{ number_format($service->price, 2) }} ({{ $service->duration_minutes }} mins + {{ $service->buffer_minutes ?? 10 }} min buffer)')">
                                    <div>
                                        <p class="font-medium">{{ $service->name }}</p>
                                        <p class="text-xs text-gray-500">₱{{ number_format($service->price, 2) }} · {{ $service->duration_minutes }} mins (+{{ $service->buffer_minutes ?? 10 }} min buffer)</p>
                                    </div>
                                    @if(old('service_id') == $service->id) <i class="fa-solid fa-check text-blue-600"></i> @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @error('service_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Dentist Selection -->
            <div>
                <label class="block text-sm font-semibold mb-2 text-gray-700">
                    <i class="fa-solid fa-user-doctor mr-1 text-gray-400"></i>Select Dentist
                </label>
                <input type="hidden" name="dentist_id" id="dentist-id-hidden" value="{{ old('dentist_id') }}">
                <div class="relative" id="dentist-dropdown">
                    <button type="button" onclick="toggleDentistDropdown()" class="w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-xl flex items-center justify-between bg-white hover:border-gray-300 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition" id="dentist-trigger">
                        <span id="dentist-label" class="flex items-center gap-2 text-gray-500">
                            @php $selectedDentist = old('dentist_id') && isset($dentists) ? $dentists->find(old('dentist_id')) : null; @endphp
                            <span id="dentist-text" class="{{ $selectedDentist ? 'text-gray-900' : '' }}">{{ $selectedDentist ? 'Dr. ' . $selectedDentist->name : '-- Choose a Dentist --' }}</span>
                        </span>
                        <i id="dentist-chevron" class="fa-solid fa-caret-down text-blue-600 text-lg transition-transform duration-300"></i>
                    </button>
                    <div id="dentist-menu" class="absolute z-50 mt-1.5 w-full bg-white border-2 border-blue-400 rounded-xl overflow-hidden shadow-lg opacity-0 -translate-y-2 scale-y-95 pointer-events-none transition-all duration-300 ease-in-out origin-top">
                        <div class="py-1 max-h-60 overflow-auto">
                            @forelse($dentists as $dentist)
                                <div class="flex items-center gap-3 px-4 py-3 text-sm cursor-pointer hover:bg-blue-50 transition-colors duration-150 {{ old('dentist_id') == $dentist->id ? 'text-blue-600 font-semibold bg-blue-50' : 'text-gray-700' }}"
                                     onclick="selectDentist('{{ $dentist->id }}', 'Dr. {{ $dentist->name }}')">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fa-solid fa-user-doctor text-blue-600 text-sm"></i>
                                    </div>
                                    <span>Dr. {{ $dentist->name }}</span>
                                    @if(old('dentist_id') == $dentist->id) <i class="fa-solid fa-check text-blue-600 ml-auto"></i> @endif
                                </div>
                            @empty
                                <div class="px-4 py-3 text-sm text-gray-500 text-center">No dentists available</div>
                            @endforelse
                        </div>
                    </div>
                </div>
                @error('dentist_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Date Selection -->
            <div>
                <label class="block text-sm font-semibold mb-2 text-gray-700">
                    <i class="fa-regular fa-calendar mr-1 text-gray-400"></i>Appointment Date
                </label>
                <input type="date" name="appointment_date" id="appointment_date" value="{{ old('appointment_date', $defaultDate ?? date('Y-m-d', strtotime('+1 day'))) }}"
                    min="{{ date('Y-m-d') }}"
                    class="w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 hover:border-gray-300 transition bg-white"
                    onchange="onDateChanged()">
                @error('appointment_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Time Slot Selection -->
            <div>
                <label class="block text-sm font-semibold mb-2 text-gray-700">
                    <i class="fa-regular fa-clock mr-1 text-gray-400"></i>Available Time Slots
                </label>
                <input type="hidden" name="appointment_time" id="time-hidden" value="{{ old('appointment_time') }}">

                <div id="time-slots-container" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-2 p-4 bg-gray-50 rounded-xl border-2 border-gray-100">
                    <p class="col-span-full text-sm text-gray-500 text-center py-4" id="slots-placeholder">
                        <i class="fa-solid fa-info-circle mr-1"></i> Select a service, dentist, and date to see available slots
                    </p>
                </div>

                @error('appointment_time') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Selected Appointment Summary -->
            <div id="appointment-summary" class="hidden p-4 bg-blue-50 rounded-xl border border-blue-100">
                <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                    <i class="fa-solid fa-clipboard-list text-blue-600"></i> Appointment Summary
                </h4>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <span class="text-gray-500">Service:</span>
                        <span id="summary-service" class="font-medium text-gray-900 block">-</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Dentist:</span>
                        <span id="summary-dentist" class="font-medium text-gray-900 block">-</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Date:</span>
                        <span id="summary-date" class="font-medium text-gray-900 block">-</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Time:</span>
                        <span id="summary-time" class="font-medium text-gray-900 block">-</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Duration:</span>
                        <span id="summary-duration" class="font-medium text-gray-900 block">-</span>
                    </div>
                    <div>
                        <span class="text-gray-500">End Time:</span>
                        <span id="summary-endtime" class="font-medium text-gray-900 block">-</span>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label class="block text-sm font-semibold mb-2 text-gray-700">
                    <i class="fa-regular fa-comment mr-1 text-gray-400"></i>Notes / Concerns (Optional)
                </label>
                <textarea name="notes" rows="3" placeholder="Describe your dental concern..."
                    class="w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 hover:border-gray-300 transition resize-none">{{ old('notes') }}</textarea>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3 pt-4 border-t border-gray-100">
                <button type="submit" id="submit-btn" class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-200 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fa-solid fa-calendar-check"></i> Book Appointment
                </button>
                <a href="{{ route('client.appointments.index') }}" class="flex-1 text-center bg-gray-100 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-200 transition border border-gray-200 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-xmark"></i> Cancel
                </a>
            </div>
        </form>
    </div>

    <script>
        // Prevent double form submission
        document.getElementById('booking-form').addEventListener('submit', function(e) {
            const btn = document.getElementById('submit-btn');

            if (btn.disabled || btn.dataset.submitting === 'true') {
                e.preventDefault();
                return false;
            }

            btn.disabled = true;
            btn.dataset.submitting = 'true';
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Booking...';
        });

        // State
        let selectedService = {{ old('service_id') ?? 'null' }};
        let selectedDentist = {{ old('dentist_id') ?? 'null' }};
        let selectedTime = null;

        // Dropdown functions
        function toggleServiceDropdown() {
            toggleDropdown('service');
        }

        function selectService(value, label) {
            document.getElementById('service-id-hidden').value = value;
            document.getElementById('service-text').textContent = label;
            document.getElementById('service-text').classList.remove('text-gray-500');
            document.getElementById('service-text').classList.add('text-gray-900');
            selectedService = value;
            // Clear selected time when service changes
            clearSelectedTime();
            toggleDropdown('service');
            loadAvailableSlots();
        }

        function toggleDentistDropdown() {
            toggleDropdown('dentist');
        }

        function selectDentist(value, label) {
            document.getElementById('dentist-id-hidden').value = value;
            document.getElementById('dentist-text').textContent = label;
            document.getElementById('dentist-text').classList.remove('text-gray-500');
            document.getElementById('dentist-text').classList.add('text-gray-900');
            selectedDentist = value;

            // Immediate verification
            console.log('=== SELECT DENTIST CALLED ===');
            console.log('Input value:', value, 'Type:', typeof value);
            console.log('selectedDentist after assignment:', selectedDentist, 'Type:', typeof selectedDentist);
            console.log('document.getElementById dentist-id-hidden:', document.getElementById('dentist-id-hidden').value);

            // Clear selected time when dentist changes
            clearSelectedTime();
            toggleDropdown('dentist');
            loadAvailableSlots();
        }

        function clearSelectedTime() {
            selectedTime = null;
            document.getElementById('time-hidden').value = '';
            document.getElementById('appointment-summary').classList.add('hidden');
            // Reset all time slot buttons to unselected state
            const buttons = document.querySelectorAll('#time-slots-container button');
            buttons.forEach(btn => {
                if (!btn.disabled) {
                    btn.classList.remove('bg-blue-600', 'text-white', 'shadow-lg');
                    btn.classList.add('bg-white', 'text-gray-700', 'border', 'border-gray-200');
                }
            });
        }

        function toggleDropdown(type) {
            const menu = document.getElementById(type + '-menu');
            const chevron = document.getElementById(type + '-chevron');
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

        // Load available slots via AJAX
        function loadAvailableSlots() {
            const date = document.getElementById('appointment_date').value;
            const container = document.getElementById('time-slots-container');
            const placeholder = container.querySelector('#slots-placeholder');

            if (!selectedService || !selectedDentist || !date) {
                if (placeholder) {
                    placeholder.innerHTML = '<i class="fa-solid fa-info-circle mr-1"></i> Select a service, dentist, and date to see available slots';
                }
                return;
            }

            // Force to integer to ensure correct type
            const serviceId = Math.floor(Number(selectedService));
            const dentistId = Math.floor(Number(selectedDentist));

            // Strict validation
            if (!Number.isInteger(serviceId) || serviceId <= 0 ||
                !Number.isInteger(dentistId) || dentistId <= 0) {
                console.error('Invalid IDs:', { serviceId, dentistId, selectedService, selectedDentist });
                return;
            }

            // Show loading state safely
            if (placeholder) {
                placeholder.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Loading slots...';
                placeholder.style.display = 'block';
            }

            // Direct DOM check to ensure hidden input values are correct
            const domDentistId = document.getElementById('dentist-id-hidden').value;
            console.log('DOM dentist-id-hidden value:', domDentistId);
            console.log('JS selectedDentist variable:', selectedDentist);
            console.log('Converted dentistId for fetch:', dentistId);

            const fetchUrl = `/client/appointments/slots?service_id=${serviceId}&date=${date}&dentist_id=${dentistId}&t=${Date.now()}`;
            console.log('Full fetch URL:', fetchUrl);
            fetch(fetchUrl, { cache: 'no-store' })
                .then(r => r.json())
                .then(slots => {
                    console.log('Slots received:', slots);
                    renderTimeSlots(slots);
                })
                .catch(err => {
                    console.error(err);
                    if (placeholder) {
                        placeholder.innerHTML = '<i class="fa-solid fa-exclamation-triangle text-red-500 mr-1"></i> Error loading slots';
                    }
                });
        }

        function onDateChanged() {
            clearSelectedTime();
            loadAvailableSlots();
        }

        function renderTimeSlots(slots) {
            const container = document.getElementById('time-slots-container');

            if (slots.length === 0) {
                container.innerHTML = '<p class="col-span-full text-sm text-gray-500 text-center py-4"><i class="fa-solid fa-times-circle mr-1"></i> No slots available</p>';
                return;
            }

            let html = '';
            slots.forEach(slot => {
                const isSelected = selectedTime === slot.time;
                const isAvailable = slot.available;
                const reason = slot.reason ? ` (${slot.reason})` : '';
                const disabledAttr = !isAvailable ? 'disabled' : '';
                const clickHandler = isAvailable ? `selectTimeSlot('${slot.time}', '${slot.formatted}', this)` : 'return false;';
                const titleText = isAvailable ? 'Click to select' : `Unavailable${reason}`;
                const btnClass = isSelected
                    ? 'bg-blue-600 text-white shadow-lg'
                    : (isAvailable ? 'bg-white text-gray-700 border border-gray-200 hover:border-blue-400 hover:bg-blue-50' : 'bg-gray-100 text-gray-400 cursor-not-allowed opacity-50');

                html += `
                    <div class="relative group">
                        <button type="button"
                            onclick="${clickHandler}"
                            title="${titleText}"
                            class="w-full px-3 py-2.5 rounded-lg text-sm font-medium transition-all ${btnClass}"
                            ${disabledAttr}>
                            ${slot.formatted}
                        </button>
                        ${!isAvailable && reason ? `<div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-10">
                            ${reason}
                        </div>` : ''}
                    </div>
                `;
            });

            container.innerHTML = html;
        }

        function selectTimeSlot(time, formatted, buttonEl) {
            if (buttonEl && buttonEl.disabled) return;

            selectedTime = time;
            document.getElementById('time-hidden').value = time;

            // Update visual
            const buttons = document.querySelectorAll('#time-slots-container button');
            buttons.forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white', 'shadow-lg');
                btn.classList.add('bg-white', 'text-gray-700', 'border', 'border-gray-200');
            });

            if (buttonEl) {
                buttonEl.classList.remove('bg-white', 'text-gray-700', 'border', 'border-gray-200');
                buttonEl.classList.add('bg-blue-600', 'text-white', 'shadow-lg');
            }

            // Update summary
            updateSummary();
        }

        function updateSummary() {
            const serviceEl = document.getElementById('service-text');
            const dentistEl = document.getElementById('dentist-text');
            const dateEl = document.getElementById('appointment_date');
            const summary = document.getElementById('appointment-summary');

            if (selectedService && selectedDentist && selectedTime && dateEl.value) {
                summary.classList.remove('hidden');
                document.getElementById('summary-service').textContent = serviceEl.textContent.split(' — ')[0];
                document.getElementById('summary-dentist').textContent = dentistEl.textContent;
                document.getElementById('summary-date').textContent = new Date(dateEl.value).toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
                document.getElementById('summary-time').textContent = formattedTime(selectedTime);

                // Calculate end time based on service duration
                const services = @json($services);
                const service = services.find(s => s.id == selectedService);
                if (service) {
                    const totalMins = service.duration_minutes + (service.buffer_minutes || 10);
                    const endTimestamp = new Date(`2000-01-01T${selectedTime}`);
                    endTimestamp.setMinutes(endTimestamp.getMinutes() + totalMins);
                    const endHours = endTimestamp.getHours().toString().padStart(2, '0');
                    const endMins = endTimestamp.getMinutes().toString().padStart(2, '0');
                    document.getElementById('summary-endtime').textContent = formattedTime(`${endHours}:${endMins}`);
                    document.getElementById('summary-duration').textContent = `${service.duration_minutes} mins (+${service.buffer_minutes || 10} min buffer)`;
                } else {
                    document.getElementById('summary-duration').textContent = '-';
                    document.getElementById('summary-endtime').textContent = '-';
                }
            }
        }

        function formattedTime(time) {
            const [hours, minutes] = time.split(':');
            const h = parseInt(hours);
            const ampm = h >= 12 ? 'PM' : 'AM';
            const hour12 = h % 12 || 12;
            return `${hour12}:${minutes} ${ampm}`;
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            ['service', 'dentist'].forEach(type => {
                const dd = document.getElementById(type + '-dropdown');
                const menu = document.getElementById(type + '-menu');
                const chevron = document.getElementById(type + '-chevron');
                if (dd && !dd.contains(e.target)) {
                    menu.classList.add('opacity-0', '-translate-y-2', 'scale-y-95', 'pointer-events-none');
                    menu.classList.remove('opacity-100', 'translate-y-0', 'scale-y-100');
                    if (chevron) chevron.classList.remove('rotate-180');
                }
            });
        });

        // Load slots on page load if values are pre-selected
        document.addEventListener('DOMContentLoaded', function() {
            if (selectedService && selectedDentist && document.getElementById('appointment_date').value) {
                loadAvailableSlots();
            }
        });
    </script>
@endsection