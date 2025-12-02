<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointment_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // pending, confirmed, in_progress, completed, cancelled, no_show
            $table->string('display_name'); // Nombre para mostrar al cliente
            $table->string('color')->default('#6c757d'); // Color para la UI
            $table->text('description')->nullable(); // Descripción del estado
            $table->boolean('is_final')->default(false); // ¿Es un estado final?
            $table->boolean('requires_admin_action')->default(false); // ¿Requiere acción del admin?
            $table->integer('sort_order')->default(0); // Orden de visualización
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointment_statuses');
    }
};