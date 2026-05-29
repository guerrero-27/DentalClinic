<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'birthdate' => 'date',
        ];
    }

    protected $fillable = [
        'name', 'email', 'phone', 'address', 'birthdate', 'role', 'password',
        'working_start', 'working_end', 'unavailable_dates', 'is_active', 'image',
    ];

    protected $hidden = ['password', 'remember_token'];

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'user_id');
    }

    public function dentistAppointments()
    {
        return $this->hasMany(Appointment::class, 'dentist_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isClient()
    {
        return $this->role === 'client';
    }

    public function isDentist()
    {
        return $this->role === 'dentist';
    }

    public function isActiveDentist()
    {
        return $this->role === 'dentist' && ($this->is_active === true || $this->is_active === 1);
    }
}