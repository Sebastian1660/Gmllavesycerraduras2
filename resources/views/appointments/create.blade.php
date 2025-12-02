@extends('layouts.app')

@section('title', 'Agendar Cita - GM Llaves y Cerraduras')

@section('content')

<section class="appointment-form-section">
    <div class="container">
        <div class="section-header">
            <h2>Agendar una Cita</h2>
            <p>Complete el formulario para solicitar nuestros servicios</p>
        </div>

        <div class="form-wrapper">
            <form action="{{ route('appointments.store') }}" method="POST" id="appointmentForm">
                @csrf
                
                <div class="form-section">
                    <h3><i class="fas fa-tools"></i> Seleccione el Servicio</h3>
                    
                    <div class="form-group">
                        <label for="service_id">Servicio Requerido *</label>
                        <select name="service_id" id="service_id" class="form-control" required>
                            <option value="">Seleccione un servicio...</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" 
                                        data-duration="{{ $service->estimated_duration }}"
                                        data-price="{{ $service->base_price }}"
                                        {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }}
                                    @if($service->base_price)
                                        - Desde {{ $service->formatted_price }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-section">
                    <h3><i class="fas fa-calendar-alt"></i> Fecha y Hora</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="appointment_date">Fecha de la Cita *</label>
                            <input type="date" 
                                   name="appointment_date" 
                                   id="appointment_date" 
                                   class="form-control" 
                                   min="{{ date('Y-m-d') }}"
                                   value="{{ old('appointment_date') }}"
                                   required>
                            @error('appointment_date')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="appointment_time">Hora de la Cita *</label>
                            <select name="appointment_time" id="appointment_time" class="form-control" required disabled>
                                <option value="">Primero seleccione una fecha...</option>
                            </select>
                            @error('appointment_time')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="info-box">
                        <i class="fas fa-info-circle"></i>
                        <p>Horario de atención: Lunes a Sábado de 8:00 AM a 6:00 PM. Domingos solo emergencias.</p>
                    </div>
                </div>

                <div class="form-section">
                    <h3><i class="fas fa-user"></i> Información de Contacto</h3>
                    
                    <div class="form-group">
                        <label for="client_name">Nombre Completo *</label>
                        <input type="text" 
                               name="client_name" 
                               id="client_name" 
                               class="form-control" 
                               value="{{ old('client_name', auth()->user()->name) }}"
                               required>
                        @error('client_name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="client_phone">Teléfono *</label>
                            <input type="tel" 
                                   name="client_phone" 
                                   id="client_phone" 
                                   class="form-control" 
                                   value="{{ old('client_phone', auth()->user()->phone) }}"
                                   placeholder="+57 300 000 0000"
                                   required>
                            @error('client_phone')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="client_email">Correo Electrónico *</label>
                            <input type="email" 
                                   name="client_email" 
                                   id="client_email" 
                                   class="form-control" 
                                   value="{{ old('client_email', auth()->user()->email) }}"
                                   required>
                            @error('client_email')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3><i class="fas fa-map-marker-alt"></i> Ubicación del Servicio</h3>
                    
                    <div class="form-group">
                        <label for="service_address">Dirección Completa *</label>
                        <textarea name="service_address" 
                                  id="service_address" 
                                  class="form-control" 
                                  rows="2"
                                  placeholder="Calle, número, barrio..."
                                  required>{{ old('service_address', auth()->user()->address) }}</textarea>
                        @error('service_address')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="address_references">Referencias de Ubicación</label>
                        <input type="text" 
                               name="address_references" 
                               id="address_references" 
                               class="form-control"
                               value="{{ old('address_references') }}"
                               placeholder="Ej: Cerca de la iglesia, portón azul, etc.">
                        @error('address_references')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-section">
                    <h3><i class="fas fa-comment-dots"></i> Detalles del Servicio</h3>
                    
                    <div class="form-group">
                        <label for="service_details">Describa el problema o servicio que necesita</label>
                        <textarea name="service_details" 
                                  id="service_details" 
                                  class="form-control" 
                                  rows="4"
                                  placeholder="Ej: La cerradura de la puerta principal no cierra bien, necesito duplicar 3 llaves, etc.">{{ old('service_details') }}</textarea>
                        @error('service_details')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('home') }}" class="btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-check"></i> Agendar Cita
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    .appointment-form-section {
        padding: 60px 0;
        background-color: #f8f9fa;
        min-height: 100vh;
        margin-top: 50px;
    }

    .form-wrapper {
        max-width: 900px;
        margin: 0 auto;
        background: white;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .form-section {
        margin-bottom: 35px;
        padding-bottom: 25px;
        border-bottom: 2px solid #f0f0f0;
    }

    .form-section:last-of-type {
        border-bottom: none;
    }

    .form-section h3 {
        color: #2c5aa0;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.3rem;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #333;
        font-weight: 500;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #2c5aa0;
        box-shadow: 0 0 0 3px rgba(44, 90, 160, 0.1);
    }

    .form-control:disabled {
        background-color: #f5f5f5;
        cursor: not-allowed;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .error-message {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 5px;
        display: block;
    }

    .info-box {
        background-color: #e3f2fd;
        border-left: 4px solid #2c5aa0;
        padding: 15px;
        border-radius: 5px;
        display: flex;
        align-items: start;
        gap: 10px;
        margin-top: 15px;
    }

    .info-box i {
        color: #2c5aa0;
        margin-top: 2px;
    }

    .info-box p {
        margin: 0;
        color: #555;
        font-size: 0.95rem;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 20px;
    }

    .form-actions .btn-primary,
    .form-actions .btn-secondary {
        padding: 12px 30px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .form-actions .btn-primary {
        background-color: #2c5aa0;
        color: white;
    }

    .form-actions .btn-primary:hover {
        background-color: #1e4a73;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(44, 90, 160, 0.3);
    }

    .form-actions .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .form-actions .btn-secondary:hover {
        background-color: #5a6268;
    }

    @media (max-width: 768px) {
        .form-wrapper {
            padding: 25px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .form-actions button,
        .form-actions a {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Cargar horarios disponibles cuando se selecciona una fecha
    const dateInput = document.getElementById('appointment_date');
    const timeSelect = document.getElementById('appointment_time');

    dateInput.addEventListener('change', function() {
        const selectedDate = this.value;
        
        if (!selectedDate) {
            timeSelect.disabled = true;
            timeSelect.innerHTML = '<option value="">Primero seleccione una fecha...</option>';
            return;
        }

        // Mostrar loading
        timeSelect.disabled = true;
        timeSelect.innerHTML = '<option value="">Cargando horarios...</option>';

        // Obtener horarios disponibles via AJAX
        fetch(`{{ route('api.available-slots') }}?date=${selectedDate}`)
            .then(response => response.json())
            .then(data => {
                timeSelect.innerHTML = '';
                
                if (data.slots.length === 0) {
                    timeSelect.innerHTML = '<option value="">No hay horarios disponibles para esta fecha</option>';
                    timeSelect.disabled = true;
                } else {
                    timeSelect.innerHTML = '<option value="">Seleccione una hora...</option>';
                    data.slots.forEach(slot => {
                        const option = document.createElement('option');
                        option.value = slot;
                        option.textContent = slot;
                        timeSelect.appendChild(option);
                    });
                    timeSelect.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                timeSelect.innerHTML = '<option value="">Error al cargar horarios</option>';
                timeSelect.disabled = true;
            });
    });

    // Validación del formulario
    document.getElementById('appointmentForm').addEventListener('submit', function(e) {
        const requiredFields = this.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.style.borderColor = '#dc3545';
            } else {
                field.style.borderColor = '#e0e0e0';
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Por favor complete todos los campos obligatorios (*)');
        }
    });
</script>
@endpush