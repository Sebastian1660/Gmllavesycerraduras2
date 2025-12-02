
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('business_hours', function (Blueprint $table) {
            $table->id();
            $table->enum('day_of_week', [
                'monday', 'tuesday', 'wednesday', 'thursday', 
                'friday', 'saturday', 'sunday'
            ]);
            $table->time('opening_time'); // Hora de apertura
            $table->time('closing_time'); // Hora de cierre
            $table->time('lunch_start')->nullable(); // Inicio del almuerzo
            $table->time('lunch_end')->nullable(); // Final del almuerzo
            $table->boolean('is_open')->default(true); // ¿Está abierto este día?
            $table->boolean('emergency_only')->default(false); // ¿Solo emergencias?
            $table->integer('slot_duration')->default(60); // Duración de cada cita en minutos
            $table->timestamps();
            
            $table->unique('day_of_week'); // Solo un registro por día
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_hours');
    }
};