<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name', 'description', 'price', 'duration_minutes', 'buffer_minutes', 'is_active'];

    protected $casts = [
        'price' => 'decimal:2',
        'duration_minutes' => 'integer',
        'buffer_minutes' => 'integer',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function getTotalMinutesAttribute()
    {
        return $this->duration_minutes + $this->buffer_minutes;
    }

    public function getFormattedDurationAttribute()
    {
        return $this->duration_minutes . ' mins (+' . $this->buffer_minutes . ' min buffer)';
    }
}
