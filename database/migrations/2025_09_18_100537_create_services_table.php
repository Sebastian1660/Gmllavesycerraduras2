<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre del servicio
            $table->text('description'); // Descripción del servicio
            $table->decimal('base_price', 10, 2)->nullable(); // Precio base (puede variar)
            $table->integer('estimated_duration')->nullable(); // Duración estimada en minutos
            $table->boolean('emergency_service')->default(false); // ¿Es servicio de emergencia?
            $table->boolean('requires_evaluation')->default(false); // ¿Requiere evaluación previa?
            $table->string('category')->default('general'); // Categoría del servicio
            $table->string('icon')->nullable(); // Icono para mostrar en el frontend
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
