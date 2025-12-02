<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BusinessHour;

class BusinessHourSeeder extends Seeder
{
    public function run(): void
    {
        $businessHours = [
            [
                'day_of_week' => 'monday',
                'opening_time' => '08:00',
                'closing_time' => '18:00',
                'lunch_start' => '12:00',
                'lunch_end' => '13:00',
                'is_open' => true,
                'emergency_only' => false,
                'slot_duration' => 60
            ],
            [
                'day_of_week' => 'tuesday',
                'opening_time' => '08:00',
                'closing_time' => '18:00',
                'lunch_start' => '12:00',
                'lunch_end' => '13:00',
                'is_open' => true,
                'emergency_only' => false,
                'slot_duration' => 60
            ],
            [
                'day_of_week' => 'wednesday',
                'opening_time' => '08:00',
                'closing_time' => '18:00',
                'lunch_start' => '12:00',
                'lunch_end' => '13:00',
                'is_open' => true,
                'emergency_only' => false,
                'slot_duration' => 60
            ],
            [
                'day_of_week' => 'thursday',
                'opening_time' => '08:00',
                'closing_time' => '18:00',
                'lunch_start' => '12:00',
                'lunch_end' => '13:00',
                'is_open' => true,
                'emergency_only' => false,
                'slot_duration' => 60
            ],
            [
                'day_of_week' => 'friday',
                'opening_time' => '08:00',
                'closing_time' => '18:00',
                'lunch_start' => '12:00',
                'lunch_end' => '13:00',
                'is_open' => true,
                'emergency_only' => false,
                'slot_duration' => 60
            ],
            [
                'day_of_week' => 'saturday',
                'opening_time' => '08:00',
                'closing_time' => '16:00',
                'lunch_start' => '12:00',
                'lunch_end' => '13:00',
                'is_open' => true,
                'emergency_only' => false,
                'slot_duration' => 60
            ],
            [
                'day_of_week' => 'sunday',
                'opening_time' => '08:00',
                'closing_time' => '16:00',
                'lunch_start' => null,
                'lunch_end' => null,
                'is_open' => false,
                'emergency_only' => true, // Solo emergencias los domingos
                'slot_duration' => 60
            ]
        ];

        foreach ($businessHours as $hours) {
            BusinessHour::create($hours);
        }
    }
}