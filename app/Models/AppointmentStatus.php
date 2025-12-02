<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'color',
        'description',
        'is_final',
        'requires_admin_action',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_final' => 'boolean',
        'requires_admin_action' => 'boolean',
        'is_active' => 'boolean'
    ];

    // Scope para estados activos
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    // Scope para estados que requieren acción del admin
    public function scopeRequiresAdminAction($query)
    {
        return $query->where('requires_admin_action', true);
    }
}