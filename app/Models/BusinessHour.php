<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BusinessHour extends Model
{
    use HasFactory;

    protected $fillable = [
        'day_of_week',
        'opening_time',
        'closing_time',
        'lunch_start',
        'lunch_end',
        'is_open',
        'emergency_only',
        'slot_duration'
    ];

    protected $casts = [
        'opening_time' => 'datetime:H:i',
        'closing_time' => 'datetime:H:i',
        'lunch_start' => 'datetime:H:i',
        'lunch_end' => 'datetime:H:i',
        'is_open' => 'boolean',
        'emergency_only' => 'boolean'
    ];

    // Scope para días abiertos
    public function scopeOpen($query)
    {
        return $query->where('is_open', true);
    }

    // Obtener horarios disponibles para un día
    public function getAvailableSlots()
    {
        $slots = [];
        
        if (!$this->is_open) {
            return $slots;
        }

        $current = Carbon::parse($this->opening_time);
        $closing = Carbon::parse($this->closing_time);
        $lunchStart = $this->lunch_start ? Carbon::parse($this->lunch_start) : null;
        $lunchEnd = $this->lunch_end ? Carbon::parse($this->lunch_end) : null;

        while ($current->lt($closing)) {
            // Si hay horario de almuerzo, saltarlo
            if ($lunchStart && $lunchEnd && 
                $current->gte($lunchStart) && $current->lt($lunchEnd)) {
                $current = $lunchEnd->copy();
                continue;
            }

            $slots[] = $current->format('H:i');
            $current->addMinutes($this->slot_duration);
        }

        return $slots;
    }

    // Obtener el nombre del día en español
    public function getDayNameAttribute()
    {
        $days = [
            'monday' => 'Lunes',
            'tuesday' => 'Martes',
            'wednesday' => 'Miércoles',
            'thursday' => 'Jueves',
            'friday' => 'Viernes',
            'saturday' => 'Sábado',
            'sunday' => 'Domingo'
        ];

        return $days[$this->day_of_week] ?? $this->day_of_week;
    }
}