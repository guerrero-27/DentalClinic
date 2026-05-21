<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'user_id', 'service_id', 'appointment_date',
        'appointment_time', 'status', 'notes', 'admin_notes'
    ];

    protected $casts = ['appointment_date' => 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function getStatusColorClass()
    {
        return match($this->status){
            'pending' => 'bg-yellow-100 text-yellow-800',
            'confirmed' => 'bg-blue-100 text-blue-800',
            'completed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-100',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
