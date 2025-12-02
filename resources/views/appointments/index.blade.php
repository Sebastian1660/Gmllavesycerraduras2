@extends('layouts.app')

@section('title', 'Mis Citas - GM Llaves y Cerraduras')

@section('content')

<section class="appointments-section">
    <div class="container">
        <div class="section-header">
            <h2>Mis Citas</h2>
            <p>Administra tus citas agendadas</p>
        </div>

        <div class="appointments-actions">
            <a href="{{ route('appointments.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Agendar Nueva Cita
            </a>
        </div>

        @if($appointments->count() > 0)
            <div class="appointments-list">
                @foreach($appointments as $appointment)
                    <div class="appointment-card">
                        <div class="appointment-header">
                            <h3>{{ $appointment->service->name }}</h3>
                            {!! $appointment->status_badge !!}
                        </div>
                        
                        <div class="appointment-body">
                            <div class="appointment-info">
                                <div class="info-item">
                                    <i class="fas fa-calendar"></i>
                                    <span>{{ $appointment->formatted_date }}</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-clock"></i>
                                    <span>{{ $appointment->formatted_time }}</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $appointment->service_address }}</span>
                                </div>
                                @if($appointment->estimated_price)
                                    <div class="info-item">
                                        <i class="fas fa-dollar-sign"></i>
                                        <span>Precio estimado: ${{ number_format($appointment->estimated_price, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                            </div>

                            @if($appointment->service_details)
                                <div class="appointment-details">
                                    <strong>Detalles:</strong>
                                    <p>{{ $appointment->service_details }}</p>
                                </div>
                            @endif

                            @if($appointment->admin_notes && in_array($appointment->status, ['confirmed', 'in_progress', 'completed']))
                                <div class="appointment-notes">
                                    <strong>Notas del administrador:</strong>
                                    <p>{{ $appointment->admin_notes }}</p>
                                </div>
                            @endif
                        </div>
                        
                        <div class="appointment-footer">
                            <a href="{{ route('appointments.show', $appointment) }}" class="btn-view">
                                <i class="fas fa-eye"></i> Ver Detalles
                            </a>
                            
                            @if(in_array($appointment->status, ['pending', 'confirmed']))
                                <form action="{{ route('appointments.cancel', $appointment) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Estás seguro de cancelar esta cita?');">
                                    @csrf
                                    <button type="submit" class="btn-cancel">
                                        <i class="fas fa-times"></i> Cancelar Cita
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination">
                {{ $appointments->links() }}
            </div>
        @else
            <div class="no-appointments">
                <i class="fas fa-calendar-times"></i>
                <h3>No tienes citas agendadas</h3>
                <p>Agenda tu primera cita para recibir nuestros servicios profesionales de cerrajería</p>
                <a href="{{ route('appointments.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i> Agendar Primera Cita
                </a>
            </div>
        @endif
    </div>
</section>

@endsection

@push('styles')
<style>
    .appointments-section {
        padding: 80px 0;
        background-color: #f8f9fa;
        min-height: 70vh;
        margin-top: 50px;
        position: relatie;
    }

    .appointments-actions {
        margin-bottom: 50px;
        text-align: center;
    }

    .appointments-list {
        display: grid;
        gap: 20px;
    }

    .appointment-card {
        background: white;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }

    .appointment-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }

    .appointment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }

    .appointment-header h3 {
        margin: 0;
        color: #2c5aa0;
        font-size: 1.5rem;
    }

    .appointment-body {
        margin-bottom: 20px;
    }

    .appointment-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
        margin-bottom: 15px;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #666;
    }

    .info-item i {
        color: #2c5aa0;
        width: 20px;
    }

    .appointment-details,
    .appointment-notes {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-top: 15px;
    }

    .appointment-details strong,
    .appointment-notes strong {
        color: #2c5aa0;
        display: block;
        margin-bottom: 8px;
    }

    .appointment-footer {
        display: flex;
        gap: 10px;
        padding-top: 15px;
        border-top: 1px solid #f0f0f0;
    }

    .btn-view,
    .btn-cancel {
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-view {
        background-color: #2c5aa0;
        color: white;
    }

    .btn-view:hover {
        background-color: #1e4a73;
    }

    .btn-cancel {
        background-color: #dc3545;
        color: white;
    }

    .btn-cancel:hover {
        background-color: #c82333;
    }

    .no-appointments {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 10px;
    }

    .no-appointments i {
        font-size: 4rem;
        color: #ddd;
        margin-bottom: 20px;
    }

    .no-appointments h3 {
        color: #333;
        margin-bottom: 10px;
    }

    .no-appointments p {
        color: #666;
        margin-bottom: 25px;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .bg-warning {
        background-color: #ffc107;
        color: #333;
    }

    .bg-success {
        background-color: #28a745;
        color: white;
    }

    .bg-info {
        background-color: #17a2b8;
        color: white;
    }

    .bg-primary {
        background-color: #007bff;
        color: white;
    }

    .bg-danger {
        background-color: #dc3545;
        color: white;
    }

    .bg-secondary {
        background-color: #6c757d;
        color: white;
    }
</style>
@endpush