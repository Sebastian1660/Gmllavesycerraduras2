<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'base_price',
        'estimated_duration',
        'emergency_service',
        'requires_evaluation',
        'category',
        'icon',
        'is_active'
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'emergency_service' => 'boolean',
        'requires_evaluation' => 'boolean',
        'is_active' => 'boolean'
    ];

    // Relación: Un servicio puede tener muchas citas
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // Scope para servicios activos
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope para servicios de emergencia
    public function scopeEmergency($query)
    {
        return $query->where('emergency_service', true);
    }

    // Accessor para precio formateado
    public function getFormattedPriceAttribute()
    {
        return $this->base_price ? '$' . number_format($this->base_price, 0, ',', '.') : 'Consultar';
    }
}