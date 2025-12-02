<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmed;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentAdminController extends Controller
{
    // Ver todas las citas
    public function index()
    {
        $appointments = Appointment::with(['user', 'service'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(20);
        
        return view('admin.appointments.index', compact('appointments'));
    }

    // Ver citas pendientes
    public function pending()
    {
        $appointments = Appointment::with(['user', 'service'])
            ->pending()
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.appointments.pending', compact('appointments'));
    }

    // Ver citas de hoy
    public function today()
    {
        $appointments = Appointment::with(['user', 'service'])
            ->today()
            ->orderBy('appointment_time', 'asc')
            ->get();
        
        return view('admin.appointments.today', compact('appointments'));
    }

    // Ver próximas citas
    public function upcoming()
    {
        $appointments = Appointment::with(['user', 'service'])
            ->upcoming()
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->paginate(20);
        
        return view('admin.appointments.upcoming', compact('appointments'));
    }

    // Ver detalle de una cita
    public function show(Appointment $appointment)
    {
        $appointment->load(['user', 'service']);
        return view('admin.appointments.show', compact('appointment'));
    }

    // Confirmar una cita
    public function confirm(Appointment $appointment)
{
    if ($appointment->status !== 'pending') {
        return redirect()->back()->with('error', 'Solo se pueden confirmar citas pendientes.');
    }

    $appointment->confirm();

    // Enviar email de confirmación
    try {
        Mail::to($appointment->client_email)->send(new AppointmentConfirmed($appointment));
        $message = 'Cita confirmada y email enviado al cliente.';
    } catch (\Exception $e) {
        // Si falla el envío del email, la cita igual se confirma
        \Log::error('Error enviando email: ' . $e->getMessage());
        $message = 'Cita confirmada. No se pudo enviar el email.';
    }

    return redirect()->back()->with('success', $message);
}

    // Iniciar una cita
    public function start(Appointment $appointment)
    {
        if (!in_array($appointment->status, ['pending', 'confirmed'])) {
            return redirect()->back()->with('error', 'Esta cita no puede ser iniciada.');
        }

        $appointment->start();

        return redirect()->back()->with('success', 'Cita marcada como en progreso.');
    }

    // Completar una cita
    public function complete(Request $request, Appointment $appointment)
    {
        if (!in_array($appointment->status, ['confirmed', 'in_progress'])) {
            return redirect()->back()->with('error', 'Esta cita no puede ser completada.');
        }

        $validated = $request->validate([
            'final_price' => 'nullable|numeric|min:0'
        ]);

        $appointment->complete($validated['final_price'] ?? null);

        return redirect()->back()->with('success', 'Cita completada exitosamente.');
    }

    // Cancelar una cita
    public function cancel(Request $request, Appointment $appointment)
    {
        if (in_array($appointment->status, ['completed', 'cancelled'])) {
            return redirect()->back()->with('error', 'Esta cita no puede ser cancelada.');
        }

        $validated = $request->validate([
            'reason' => 'nullable|string|max:500'
        ]);

        $appointment->cancel($validated['reason'] ?? null);

        return redirect()->back()->with('success', 'Cita cancelada exitosamente.');
    }

    // Actualizar notas del administrador
    public function updateNotes(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'admin_notes' => 'required|string|max:1000'
        ]);

        $appointment->update([
            'admin_notes' => $validated['admin_notes']
        ]);

        return redirect()->back()->with('success', 'Notas actualizadas exitosamente.');
    }
}