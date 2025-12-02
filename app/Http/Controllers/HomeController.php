<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        // Obtener todos los servicios activos para mostrar en la página principal
        $services = Service::active()->get();
        
        return view('welcome', compact('services'));
    }
    
    public function showAppointmentForm()
    {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            // Si no está autenticado, redirigir al login con un mensaje
            return redirect()->route('login')
                ->with('message', 'Debes iniciar sesión para agendar una cita');
        }
        
        // Si está autenticado, mostrar el formulario de agendamiento
        $services = Service::active()->get();
        return view('appointments.create', compact('services'));
    }
}