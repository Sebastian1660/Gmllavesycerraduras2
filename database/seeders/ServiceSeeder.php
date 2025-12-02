<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Apertura de Puertas',
                'description' => 'Servicio de emergencia rápido y profesional para todo tipo de puertas, con tecnología no destructiva.',
                'base_price' => 80000,
                'estimated_duration' => 30,
                'emergency_service' => true,
                'requires_evaluation' => false,
                'category' => 'emergencia',
                'icon' => 'fas fa-door-open',
                'is_active' => true
            ],
            [
                'name' => 'Cambio de Cerraduras',
                'description' => 'Reemplazamos e instalamos cerraduras de alta seguridad con garantía y certificación profesional.',
                'base_price' => 150000,
                'estimated_duration' => 60,
                'emergency_service' => false,
                'requires_evaluation' => true,
                'category' => 'instalacion',
                'icon' => 'fas fa-lock',
                'is_active' => true
            ],
            [
                'name' => 'Sistemas de Seguridad',
                'description' => 'Implementación de sistemas avanzados de control de acceso y seguridad para hogares y empresas.',
                'base_price' => 300000,
                'estimated_duration' => 120,
                'emergency_service' => false,
                'requires_evaluation' => true,
                'category' => 'seguridad',
                'icon' => 'fas fa-shield-alt',
                'is_active' => true
            ],
            [
                'name' => 'Copia de Llaves',
                'description' => 'Duplicación de llaves de alta precisión, incluyendo llaves especiales, de vehículos y de seguridad.',
                'base_price' => 15000,
                'estimated_duration' => 15,
                'emergency_service' => false,
                'requires_evaluation' => false,
                'category' => 'duplicacion',
                'icon' => 'fas fa-key',
                'is_active' => true
            ],
            [
                'name' => 'Mantenimiento de Cerraduras',
                'description' => 'Servicio de mantenimiento preventivo y correctivo para prolongar la vida útil de sus cerraduras.',
                'base_price' => 50000,
                'estimated_duration' => 45,
                'emergency_service' => false,
                'requires_evaluation' => false,
                'category' => 'mantenimiento',
                'icon' => 'fas fa-tools',
                'is_active' => true
            ],
            [
                'name' => 'Instalación de Cajas Fuertes',
                'description' => 'Instalación profesional de cajas fuertes para hogares y oficinas con asesoramiento especializado.',
                'base_price' => 200000,
                'estimated_duration' => 90,
                'emergency_service' => false,
                'requires_evaluation' => true,
                'category' => 'instalacion',
                'icon' => 'fas fa-vault',
                'is_active' => true
            ]
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
