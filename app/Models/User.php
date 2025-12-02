<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'last_login' => 'datetime'
    ];

    // Relaciones
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // Scopes
    public function scopeClients($query)
    {
        return $query->where('role', 'client');
    }

    public function sendPasswordResetNotification($token)
    {
    $this->notify(new ResetPasswordNotification($token));
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Métodos de verificación de roles
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isClient()
    {
        return $this->role === 'client';
    }

    // Método para actualizar último login
    public function updateLastLogin()
    {
        $this->update(['last_login' => now()]);
    }

    // Accessor para obtener citas pendientes
    public function getPendingAppointmentsAttribute()
    {
        return $this->appointments()->whereIn('status', ['pending', 'confirmed'])->count();
    }
}