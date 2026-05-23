<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'user_id', 'service_id', 'dentist_id',
        'appointment_date', 'appointment_time', 'end_time',
        'status', 'notes', 'admin_notes', 'is_online_booking'
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'is_online_booking' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function dentist()
    {
        return $this->belongsTo(User::class, 'dentist_id');
    }

    public function getStatusColorClass()
    {
        return match($this->status){
            'pending' => 'bg-yellow-100 text-yellow-700 border border-yellow-200',
            'confirmed' => 'bg-blue-100 text-blue-700 border border-blue-200',
            'completed' => 'bg-emerald-100 text-emerald-700 border border-emerald-200',
            'cancelled' => 'bg-red-100 text-red-700 border border-red-200',
            default => 'bg-slate-100 text-slate-700 border border-slate-200',
        };
    }

    public function getFormattedTimeRangeAttribute()
    {
        $start = date('g:i A', strtotime($this->appointment_time));
        $end = date('g:i A', strtotime($this->end_time));
        return $start . ' - ' . $end;
    }

    public function overlapsWith($newStart, $newEnd)
    {
        $existingStart = strtotime($this->appointment_time);
        $existingEnd = strtotime($this->end_time);
        $newStartTime = strtotime($newStart);
        $newEndTime = strtotime($newEnd);

        return $newStartTime < $existingEnd && $newEndTime > $existingStart;
    }

    /**
     * Scope to find overlapping appointments for a dentist on a given date/time.
     * Excludes cancelled appointments.
     */
    public function scopeOverlapping($query, $date, $startTime, $endTime, $dentistId, $excludeId = null)
    {
        return $query->where('dentist_id', $dentistId)
            ->where('appointment_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->where(function ($q) use ($startTime, $endTime) {
                $q->where(function ($sub) use ($startTime, $endTime) {
                    $sub->where('appointment_time', '<=', $startTime)
                        ->where('end_time', '>', $startTime);
                })->orWhere(function ($sub) use ($startTime, $endTime) {
                    $sub->where('appointment_time', '<', $endTime)
                        ->where('end_time', '>=', $endTime);
                })->orWhere(function ($sub) use ($startTime, $endTime) {
                    $sub->where('appointment_time', '>=', $startTime)
                        ->where('end_time', '<=', $endTime);
                });
            });
    }
}
