<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AppointmentStatus;

class AppointmentStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            [
                'name' => 'pending',
                'display_name' => 'Pendiente',
                'color' => '#ffc107',
                'description' => 'Cita creada, esperando confirmación del administrador',
                'is_final' => false,
                'requires_admin_action' => true,
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'name' => 'confirmed',
                'display_name' => 'Confirmada',
                'color' => '#28a745',
                'description' => 'Cita confirmada por el administrador',
                'is_final' => false,
                'requires_admin_action' => false,
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'name' => 'in_progress',
                'display_name' => 'En Progreso',
                'color' => '#17a2b8',
                'description' => 'El técnico está realizando el servicio',
                'is_final' => false,
                'requires_admin_action' => false,
                'sort_order' => 3,
                'is_active' => true
            ],
            [
                'name' => 'completed',
                'display_name' => 'Completada',
                'color' => '#007bff',
                'description' => 'Servicio completado satisfactoriamente',
                'is_final' => true,
                'requires_admin_action' => false,
                'sort_order' => 4,
                'is_active' => true
            ],
            [
                'name' => 'cancelled',
                'display_name' => 'Cancelada',
                'color' => '#dc3545',
                'description' => 'Cita cancelada por el cliente o administrador',
                'is_final' => true,
                'requires_admin_action' => false,
                'sort_order' => 5,
                'is_active' => true
            ],
            [
                'name' => 'no_show',
                'display_name' => 'No se presentó',
                'color' => '#6c757d',
                'description' => 'El cliente no se presentó a la cita',
                'is_final' => true,
                'requires_admin_action' => false,
                'sort_order' => 6,
                'is_active' => true
            ]
        ];

        foreach ($statuses as $status) {
            AppointmentStatus::create($status);
        }
    }
}