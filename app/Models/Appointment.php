<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'appointment_date',
        'appointment_time',
        'client_name',
        'client_phone',
        'client_email',
        'service_address',
        'address_references',
        'service_details',
        'estimated_price',
        'final_price',
        'status',
        'admin_notes',
        'client_notes',
        'confirmed_at',
        'started_at',
        'completed_at',
        'cancelled_at'
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i',
        'estimated_price' => 'decimal:2',
        'final_price' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime'
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('appointment_date', today());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', today())
                    ->whereIn('status', ['pending', 'confirmed']);
    }

    // Accessors
    public function getFullDateTimeAttribute()
    {
        return Carbon::parse($this->appointment_date->format('Y-m-d') . ' ' . $this->appointment_time);
    }

    public function getFormattedDateAttribute()
    {
        return $this->appointment_date->format('d/m/Y');
    }

    public function getFormattedTimeAttribute()
    {
        return Carbon::parse($this->appointment_time)->format('H:i');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="badge bg-warning">Pendiente</span>',
            'confirmed' => '<span class="badge bg-success">Confirmada</span>',
            'in_progress' => '<span class="badge bg-info">En Progreso</span>',
            'completed' => '<span class="badge bg-primary">Completada</span>',
            'cancelled' => '<span class="badge bg-danger">Cancelada</span>',
            'no_show' => '<span class="badge bg-secondary">No se presentó</span>'
        ];

        return $badges[$this->status] ?? '<span class="badge bg-light">Sin estado</span>';
    }

    // Métodos de acción
    public function confirm()
    {
        $this->update([
            'status' => 'confirmed',
            'confirmed_at' => now()
        ]);
    }

    public function start()
    {
        $this->update([
            'status' => 'in_progress',
            'started_at' => now()
        ]);
    }

    public function complete($finalPrice = null)
    {
        $data = [
            'status' => 'completed',
            'completed_at' => now()
        ];

        if ($finalPrice) {
            $data['final_price'] = $finalPrice;
        }

        $this->update($data);
    }

    public function cancel($reason = null)
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'admin_notes' => $reason ? $this->admin_notes . "\nCancelado: " . $reason : $this->admin_notes
        ]);
    }
}