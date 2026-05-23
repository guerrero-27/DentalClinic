<?php

namespace App\Rules;

use App\Models\Appointment;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class NoDoubleBooking implements ValidationRule, DataAwareRule
{
    protected array $data = [];

    /**
     * Set the data under validation.
     */
    public function setData(array $data): static
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $dentistId = $this->data['dentist_id'] ?? null;
        $appointmentDate = $this->data['appointment_date'] ?? null;
        $startTime = $value;
        $endTime = $this->data['end_time'] ?? null;
        $excludeAppointmentId = $this->data['exclude_appointment_id'] ?? null;

        if (!$dentistId || !$appointmentDate || !$startTime || !$endTime) {
            return;
        }

        $hasOverlap = Appointment::where('dentist_id', $dentistId)
            ->where('appointment_date', $appointmentDate)
            ->whereIn('status', ['pending', 'confirmed'])
            ->when($excludeAppointmentId, fn($q) => $q->where('id', '!=', $excludeAppointmentId))
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($q) use ($startTime, $endTime) {
                    // New slot starts during existing appointment
                    $q->where('appointment_time', '<=', $startTime)
                      ->where('end_time', '>', $startTime);
                })->orWhere(function ($q) use ($startTime, $endTime) {
                    // New slot ends during existing appointment
                    $q->where('appointment_time', '<', $endTime)
                      ->where('end_time', '>=', $endTime);
                })->orWhere(function ($q) use ($startTime, $endTime) {
                    // New slot completely contains existing appointment
                    $q->where('appointment_time', '>=', $startTime)
                      ->where('end_time', '<=', $endTime);
                });
            })
            ->exists();

        if ($hasOverlap) {
            $fail('This schedule is already booked. Please choose another time.');
        }
    }
}