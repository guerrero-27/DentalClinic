<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
    public function view(User $user, Appointment $appointment): bool
    {
        return $user->id === $appointment->user_id || $user->isAdmin();
    }

    public function update(User $user, Appointment $appointment): bool
    {
        
        if ($user->isAdmin()) {
            return true;
        }

        
        if ($user->id !== $appointment->user_id) {
            return false;
        }

        
        return $appointment->status === 'pending';
    }
}