<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use App\Services\AvailabilityChecker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = auth()->user()->appointments()
            ->with(['service', 'dentist'])
            ->latest()
            ->paginate(10);

        return view('client.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $services = Service::where('is_active', true)->get();
        $dentists = AvailabilityChecker::getDentists();
        $defaultDate = Carbon::tomorrow()->format('Y-m-d');

        return view('client.appointments.create', compact('services', 'dentists', 'defaultDate'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'dentist_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'notes' => 'nullable|string|max:500',
        ]);

        // Verify service exists and is active
        $service = Service::where('id', $validated['service_id'])
            ->where('is_active', true)
            ->firstOrFail();

        // Verify dentist exists and is active
        $dentist = User::where('id', $validated['dentist_id'])
            ->where('role', 'dentist')
            ->where('is_active', true)
            ->firstOrFail();

        $endTime = AvailabilityChecker::calculateEndTime($validated['appointment_time'], $service->id);

        // Validate within clinic hours
        if (!AvailabilityChecker::isWithinClinicHours($validated['appointment_time'])) {
            return back()->withErrors(['appointment_time' => 'Appointments must be within clinic hours (9 AM - 5 PM).'])->withInput();
        }

        if (!AvailabilityChecker::isWithinClinicHours($endTime)) {
            return back()->withErrors(['appointment_time' => 'Appointment would end after clinic hours.'])->withInput();
        }

        // Check lunch overlap
        $lunchStart = strtotime('12:00');
        $lunchEnd = strtotime('13:00');
        $slotStart = strtotime($validated['appointment_time']);
        $slotEnd = strtotime($endTime);

        if ($slotStart < $lunchEnd && $slotEnd > $lunchStart) {
            return back()->withErrors(['appointment_time' => 'Appointments cannot be during lunch break (12 PM - 1 PM).'])->withInput();
        }

        // Pre-check: Quick rejection before starting transaction (atomic lookup)
        // This catches obvious duplicates BEFORE we waste resources on a transaction
        $existingConflict = Appointment::where('dentist_id', $validated['dentist_id'])
            ->where('appointment_date', $validated['appointment_date'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('appointment_time', $validated['appointment_time'])
            ->first();

        if ($existingConflict) {
            return back()->withErrors([
                'appointment_time' => 'This schedule is already booked. Please choose another time.'
            ])->withInput();
        }

        // Use transaction with retry (handles race conditions)
        return DB::transaction(function () use ($validated, $service, $endTime) {
            // Double-check overlap with exclusive lock inside transaction
            $hasOverlap = AvailabilityChecker::checkOverlapWithLock(
                $validated['appointment_date'],
                $validated['appointment_time'],
                $endTime,
                $validated['dentist_id']
            );

            if ($hasOverlap) {
                return back()->withErrors([
                    'appointment_time' => 'This schedule is already booked. Please choose another time.'
                ])->withInput();
            }

            // Check past time (only for today bookings)
            if ($validated['appointment_date'] == Carbon::today()->format('Y-m-d')) {
                if (strtotime($validated['appointment_time']) <= strtotime(Carbon::now()->format('H:i'))) {
                    return back()->withErrors(['appointment_time' => 'Cannot book in the past.'])->withInput();
                }
            }

            $appointment = Appointment::create([
                'user_id' => auth()->id(),
                'service_id' => $validated['service_id'],
                'dentist_id' => $validated['dentist_id'],
                'appointment_date' => $validated['appointment_date'],
                'appointment_time' => $validated['appointment_time'],
                'end_time' => $endTime,
                'status' => 'pending',
                'notes' => $validated['notes'] ?? null,
                'is_online_booking' => true,
            ]);

            return redirect()->route('client.appointments.index');
        }, 5);
    }

    public function show(Appointment $appointment)
    {
        $this->authorize('view', $appointment);
        $appointment->load(['service', 'dentist']);
        return view('client.appointments.show', compact('appointment'));
    }

    public function cancel(Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        // Clients can only cancel pending appointments
        // Confirmed appointments cannot be cancelled by clients
        if ($appointment->status !== 'pending') {
            return back()->with('error', 'Only pending appointments can be cancelled.');
        }

        $appointment->update(['status' => 'cancelled']);
        return back()->with('success', 'Appointment Cancelled Successfully.');
    }

    public function reschedule(Request $request, Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        if (!in_array($appointment->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'This appointment cannot be rescheduled.');
        }

        $request->validate([
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'dentist_id' => 'required|exists:users,id',
        ]);

        $endTime = AvailabilityChecker::calculateEndTime($request->appointment_time, $appointment->service_id);

        // Manual transaction with exclusive lock for SQLite race condition prevention
        $driver = DB::connection()->getDriverName();
        $hasOverlap = false;

        try {
            if ($driver === 'sqlite') {
                DB::statement('BEGIN IMMEDIATE');
            } else {
                DB::beginTransaction();
            }

            $hasOverlap = AvailabilityChecker::checkOverlapWithLock(
                $request->appointment_date,
                $request->appointment_time,
                $endTime,
                $request->dentist_id,
                $appointment->id
            );

            if ($hasOverlap) {
                DB::rollBack();
                return back()->withErrors(['appointment_time' => 'This schedule is already booked. Please choose another time.'])->withInput();
            }

            DB::rollBack(); // Release lock before update
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        $appointment->update([
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'end_time' => $endTime,
            'dentist_id' => $request->dentist_id,
            'status' => 'pending',
        ]);

        return redirect()->route('client.appointments.show', $appointment)
            ->with('success', 'Appointment Rescheduled Successfully!');
    }

    // AJAX: Get available slots
    public function getSlots(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'date' => 'required|date',
            'dentist_id' => 'required|exists:users,id',
        ]);

        // Verify service is active
        $service = Service::where('id', $request->service_id)
            ->where('is_active', true)
            ->first();

        if (!$service) {
            return response()->json(['error' => 'Service is not available'], 404);
        }

        // Verify dentist is active
        $dentist = User::where('id', $request->dentist_id)
            ->where('role', 'dentist')
            ->where('is_active', true)
            ->first();

        if (!$dentist) {
            return response()->json(['error' => 'Dentist is not available'], 404);
        }

        $slots = AvailabilityChecker::getAvailableSlots(
            $request->date,
            $request->service_id,
            $request->dentist_id
        );

        return response()->json($slots);
    }
}