<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\BusinessHour;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function __construct()
    {
        // Todas las rutas de este controlador requieren autenticación
        $this->middleware('auth');
    }

    public function index()
    {
        // Mostrar las citas del usuario autenticado
        $appointments = Appointment::where('user_id', auth()->id())
            ->with('service')
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(10);
        
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $services = Service::active()->get();
        $businessHours = BusinessHour::open()->get();
        
        return view('appointments.create', compact('services', 'businessHours'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:20',
            'client_email' => 'required|email|max:255',
            'service_address' => 'required|string|max:500',
            'address_references' => 'nullable|string|max:500',
            'service_details' => 'nullable|string|max:1000'
        ]);

        // Agregar el user_id del usuario autenticado
        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        // Crear la cita
        $appointment = Appointment::create($validated);

        return redirect()->route('appointments.show', $appointment)
            ->with('success', '¡Cita agendada exitosamente! Te contactaremos pronto para confirmar.');
    }

    public function show(Appointment $appointment)
    {
        // Verificar que el usuario puede ver esta cita
        if ($appointment->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'No tienes permiso para ver esta cita.');
        }

        return view('appointments.show', compact('appointment'));
    }

    public function cancel(Appointment $appointment)
    {
        // Verificar que el usuario puede cancelar esta cita
        if ($appointment->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para cancelar esta cita.');
        }

        // Solo se pueden cancelar citas pendientes o confirmadas
        if (!in_array($appointment->status, ['pending', 'confirmed'])) {
            return redirect()->back()
                ->with('error', 'Esta cita no puede ser cancelada.');
        }

        $appointment->cancel('Cancelada por el cliente');

        return redirect()->route('appointments.index')
            ->with('success', 'Cita cancelada exitosamente.');
    }

    // Método para obtener horarios disponibles (AJAX)
    public function getAvailableSlots(Request $request)
    {
        $date = $request->input('date');
        $dayOfWeek = Carbon::parse($date)->format('l'); // Monday, Tuesday, etc.
        $dayOfWeekLower = strtolower($dayOfWeek);

        $businessHour = BusinessHour::where('day_of_week', $dayOfWeekLower)
            ->where('is_open', true)
            ->first();

        if (!$businessHour) {
            return response()->json(['slots' => []]);
        }

        $availableSlots = $businessHour->getAvailableSlots();

        // Obtener citas ya agendadas para ese día
        $bookedSlots = Appointment::whereDate('appointment_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('appointment_time')
            ->map(function($time) {
                return Carbon::parse($time)->format('H:i');
            })
            ->toArray();

        // Filtrar slots disponibles
        $availableSlots = array_filter($availableSlots, function($slot) use ($bookedSlots) {
            return !in_array($slot, $bookedSlots);
        });

        return response()->json(['slots' => array_values($availableSlots)]);
    }
}