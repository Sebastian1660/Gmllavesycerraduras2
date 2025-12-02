<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Cliente que agenda
            $table->foreignId('service_id')->constrained()->onDelete('restrict'); // Servicio solicitado
            
            // Información de la cita
            $table->date('appointment_date'); // Fecha de la cita
            $table->time('appointment_time'); // Hora de la cita
            $table->datetime('created_appointment')->useCurrent(); // Cuando se creó la cita
            
            // Ubicación del servicio
            $table->string('client_name'); // Nombre del cliente
            $table->string('client_phone'); // Teléfono de contacto
            $table->string('client_email'); // Email de contacto
            $table->text('service_address'); // Dirección donde se prestará el servicio
            $table->string('address_references')->nullable(); // Referencias de la dirección
            
            // Detalles del servicio
            $table->text('service_details')->nullable(); // Detalles específicos del problema/servicio
            $table->decimal('estimated_price', 10, 2)->nullable(); // Precio estimado
            $table->decimal('final_price', 10, 2)->nullable(); // Precio final (después del servicio)
            
            // Estado y seguimiento
            $table->enum('status', [
                'pending',      // Pendiente de confirmación
                'confirmed',    // Confirmada
                'in_progress',  // En progreso
                'completed',    // Completada
                'cancelled',    // Cancelada
                'no_show'       // Cliente no se presentó
            ])->default('pending');
            
            $table->text('admin_notes')->nullable(); // Notas del administrador
            $table->text('client_notes')->nullable(); // Notas adicionales del cliente
            
            // Campos de auditoría
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            
            $table->timestamps();
            
            // Índices para optimizar consultas
            $table->index(['appointment_date', 'appointment_time']);
            $table->index('status');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};