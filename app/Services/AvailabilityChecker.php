<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AvailabilityChecker
{
    // Clinic hours
    const CLINIC_START = '09:00';
    const CLINIC_END = '17:00';
    const LUNCH_START = '12:00';
    const LUNCH_END = '13:00';

    public static function getAvailableSlots($date, $serviceId, $dentistId = null)
    {
        $service = Service::findOrFail($serviceId);
        $totalMinutes = $service->duration_minutes + $service->buffer_minutes;

        $slots = [];
        $currentTime = self::CLINIC_START;

        while ($currentTime < self::CLINIC_END) {
            $startTime = $currentTime;
            $endTime = Carbon::parse($startTime)->addMinutes($totalMinutes)->format('H:i');

            // Check if slot fits within clinic hours
            if ($endTime > self::CLINIC_END) {
                break;
            }

            // Check if slot overlaps with lunch break
            $overlapsLunch = self::checkOverlapsLunch($startTime, $endTime);

            // Check if slot is already booked
            $isBooked = self::isSlotBooked($date, $startTime, $endTime, $dentistId);

            // Check if past today's time
            $isPast = self::isPastSlot($date, $startTime);

            $slots[] = [
                'time' => $startTime,
                'formatted' => self::formatTime($startTime),
                'available' => !$overlapsLunch && !$isBooked && !$isPast,
                'reason' => $overlapsLunch ? 'Lunch break' : ($isBooked ? 'Already booked' : ($isPast ? 'Past time' : null))
            ];

            // Move to next slot (15 min intervals)
            $currentTime = Carbon::parse($currentTime)->addMinutes(15)->format('H:i');
        }

        return $slots;
    }

    public static function checkOverlap($date, $startTime, $endTime, $dentistId = null, $excludeAppointmentId = null)
    {
        $newStartSec = self::timeToSecondsOfDay($startTime);
        $newEndSec = self::timeToSecondsOfDay($endTime);

        $appointments = Appointment::where('appointment_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->when($dentistId, fn ($q) => $q->where('dentist_id', $dentistId))
            ->when($excludeAppointmentId, fn ($q) => $q->where('id', '!=', $excludeAppointmentId))
            ->get(['appointment_time', 'end_time', 'service_id']);

        foreach ($appointments as $apt) {
            $aptStartSec = self::timeToSecondsOfDay($apt->appointment_time);

            // If end_time is missing, compute it from the appointment's service duration (+ buffer)
            if (empty($apt->end_time)) {
                $service = Service::find($apt->service_id);
                if (!$service) {
                    // If service missing, fall back to strict equality: treat as zero-length (won't usually block)
                    continue;
                }
                $computedEnd = Carbon::parse($apt->appointment_time)->addMinutes($service->duration_minutes + $service->buffer_minutes)->format('H:i');
                $aptEndSec = self::timeToSecondsOfDay($computedEnd);
            } else {
                $aptEndSec = self::timeToSecondsOfDay($apt->end_time);
            }


            // Check overlap: newStart < existingEnd AND newEnd > existingStart
            if ($newStartSec < $aptEndSec && $newEndSec > $aptStartSec) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check for overlapping appointments WITH pessimistic locking.
     * Use this inside a DB transaction to prevent race conditions.
     *
     * @param string $date YYYY-MM-DD
     * @param string $startTime HH:MM
     * @param string $endTime HH:MM
     * @param int|null $dentistId
     * @param int|null $excludeAppointmentId ID to exclude (for reschedules)
     * @return bool True if overlap exists
     */
    public static function checkOverlapWithLock($date, $startTime, $endTime, $dentistId = null, $excludeAppointmentId = null)
    {
        $newStartSec = self::timeToSecondsOfDay($startTime);
        $newEndSec = self::timeToSecondsOfDay($endTime);

        $query = Appointment::where('appointment_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->when($dentistId, fn ($q) => $q->where('dentist_id', $dentistId))
            ->when($excludeAppointmentId, fn ($q) => $q->where('id', '!=', $excludeAppointmentId));

        // Use lockForUpdate only for MySQL/PostgreSQL (not SQLite)
        // SQLite serializes writes automatically within transactions
        $driver = DB::connection()->getDriverName();
        if (in_array($driver, ['mysql', 'pgsql'])) {
            $query->lockForUpdate();
        }

        $appointments = $query->get(['appointment_time', 'end_time', 'service_id']);

        foreach ($appointments as $apt) {
            $aptStartSec = self::timeToSecondsOfDay($apt->appointment_time);

            if (empty($apt->end_time)) {
                $service = Service::find($apt->service_id);
                if (!$service) {
                    continue;
                }
                $computedEnd = Carbon::parse($apt->appointment_time)->addMinutes($service->duration_minutes + $service->buffer_minutes)->format('H:i');
                $aptEndSec = self::timeToSecondsOfDay($computedEnd);
            } else {
                $aptEndSec = self::timeToSecondsOfDay($apt->end_time);
            }

            // Check overlap: newStart < existingEnd AND newEnd > existingStart
            if ($newStartSec < $aptEndSec && $newEndSec > $aptStartSec) {
                return true;
            }
        }

        return false;
    }

    public static function calculateEndTime($startTime, $serviceId)
    {
        $service = Service::findOrFail($serviceId);
        $totalMinutes = $service->duration_minutes + $service->buffer_minutes;
        return Carbon::parse($startTime)->addMinutes($totalMinutes)->format('H:i');
    }

    private static function checkOverlapsLunch($startTime, $endTime)
    {
        $slotStart = self::timeToSecondsOfDay($startTime);
        $slotEnd = self::timeToSecondsOfDay($endTime);
        $lunchStart = self::timeToSecondsOfDay(self::LUNCH_START);
        $lunchEnd = self::timeToSecondsOfDay(self::LUNCH_END);

        return $slotStart < $lunchEnd && $slotEnd > $lunchStart;
    }

    private static function isSlotBooked($date, $startTime, $endTime, $dentistId = null)
    {
        $newStartSec = self::timeToSecondsOfDay($startTime);
        $newEndSec = self::timeToSecondsOfDay($endTime);

        $appointments = Appointment::where('appointment_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->when($dentistId, fn ($q) => $q->where('dentist_id', $dentistId))
            ->get(['appointment_time', 'end_time', 'service_id']);

        foreach ($appointments as $apt) {
            $aptStartSec = self::timeToSecondsOfDay($apt->appointment_time);

            // If end_time is missing, compute it from the appointment's service duration (+ buffer)
            if (empty($apt->end_time)) {
                $service = Service::find($apt->service_id);
                if (!$service) {
                    continue;
                }
                $computedEnd = Carbon::parse($apt->appointment_time)->addMinutes($service->duration_minutes + $service->buffer_minutes)->format('H:i');
                $aptEndSec = self::timeToSecondsOfDay($computedEnd);
            } else {
                $aptEndSec = self::timeToSecondsOfDay($apt->end_time);
            }


            // Check overlap: newStart < existingEnd AND newEnd > existingStart
            if ($newStartSec < $aptEndSec && $newEndSec > $aptStartSec) {
                return true;
            }
        }

        return false;
    }

    private static function isPastSlot($date, $time)
    {
        if ($date == Carbon::today()->format('Y-m-d')) {
            return self::timeToSecondsOfDay($time) <= self::timeToSecondsOfDay(Carbon::now()->format('H:i'));
        }
        return false;
    }

    /**
     * Convert time string (HH:MM or HH:MM:SS) to seconds since midnight
     * Works consistently regardless of database or strtotime quirks
     */
    private static function timeToSecondsOfDay($time)
    {
        // Clean up the time string - remove seconds if present
        $time = trim($time);

        // Split by colon
        $parts = explode(':', $time);

        $hours = (int)$parts[0];
        $minutes = isset($parts[1]) ? (int)$parts[1] : 0;
        $seconds = isset($parts[2]) ? (int)$parts[2] : 0;

        // Convert to total seconds from midnight
        return ($hours * 3600) + ($minutes * 60) + $seconds;
    }

    /**
     * Format time for display (12-hour format with AM/PM)
     */
    private static function formatTime($time)
    {
        $time = trim($time);
        $parts = explode(':', $time);
        $hours = (int)$parts[0];
        $minutes = isset($parts[1]) ? $parts[1] : '00';
        $ampm = $hours >= 12 ? 'PM' : 'AM';
        $hours12 = $hours % 12;
        if ($hours12 == 0) $hours12 = 12;
        return $hours12 . ':' . $minutes . ' ' . $ampm;
    }

    public static function isWithinClinicHours($time)
    {
        $slotStart = self::timeToSecondsOfDay($time);
        $clinicStart = self::timeToSecondsOfDay(self::CLINIC_START);
        $clinicEnd = self::timeToSecondsOfDay(self::CLINIC_END);
        return $slotStart >= $clinicStart && $slotStart < $clinicEnd;
    }

    public static function getDentists()
    {
        return \App\Models\User::where('role', 'dentist')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }
}