@extends('layouts.app')

@section('title', 'Detalle de Cita - GM Llaves y Cerraduras')

@section('content')

<section class="appointment-detail-section">
    <div class="container">
        <div class="detail-wrapper">
            <div class="detail-header">
                <div>
                    <h2>Detalle de la Cita</h2>
                    <p class="appointment-id">Cita #{{ $appointment->id }}</p>
                </div>
                {!! $appointment->status_badge !!}
            </div>

            <div class="detail-content">
                <div class="detail-section">
                    <h3><i class="fas fa-tools"></i> Servicio Solicitado</h3>
                    <div class="detail-info">
                        <p class="service-name">{{ $appointment->service->name }}</p>
                        <p class="service-description">{{ $appointment->service->description }}</p>
                        @if($appointment->estimated_price)
                            <p class="price-info">
                                <strong>Precio estimado:</strong> ${{ number_format($appointment->estimated_price, 0, ',', '.') }}
                            </p>
                        @endif
                        @if($appointment->final_price)
                            <p class="price-info final">
                                <strong>Precio final:</strong> ${{ number_format($appointment->final_price, 0, ',', '.') }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="detail-section">
                    <h3><i class="fas fa-calendar-alt"></i> Fecha y Hora</h3>
                    <div class="detail-info">
                        <div class="info-grid">
                            <div>
                                <strong>Fecha:</strong>
                                <p>{{ $appointment->formatted_date }}</p>
                            </div>
                            <div>
                                <strong>Hora:</strong>
                                <p>{{ $appointment->formatted_time }}</p>
                            </div>
                        </div>
                        <div class="timeline">
                            <div class="timeline-item {{ $appointment->created_at ? 'active' : '' }}">
                                <i class="fas fa-plus-circle"></i>
                                <div>
                                    <strong>Creada</strong>
                                    <span>{{ $appointment->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                            @if($appointment->confirmed_at)
                            <div class="timeline-item active">
                                <i class="fas fa-check-circle"></i>
                                <div>
                                    <strong>Confirmada</strong>
                                    <span>{{ $appointment->confirmed_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                            @endif
                            @if($appointment->started_at)
                            <div class="timeline-item active">
                                <i class="fas fa-play-circle"></i>
                                <div>
                                    <strong>Iniciada</strong>
                                    <span>{{ $appointment->started_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                            @endif
                            @if($appointment->completed_at)
                            <div class="timeline-item active">
                                <i class="fas fa-check-double"></i>
                                <div>
                                    <strong>Completada</strong>
                                    <span>{{ $appointment->completed_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                            @endif
                            @if($appointment->cancelled_at)
                            <div class="timeline-item active cancelled">
                                <i class="fas fa-times-circle"></i>
                                <div>
                                    <strong>Cancelada</strong>
                                    <span>{{ $appointment->cancelled_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="detail-section">
                    <h3><i class="fas fa-user"></i> Información de Contacto</h3>
                    <div class="detail-info">
                        <div class="info-grid">
                            <div>
                                <strong>Nombre:</strong>
                                <p>{{ $appointment->client_name }}</p>
                            </div>
                            <div>
                                <strong>Teléfono:</strong>
                                <p>{{ $appointment->client_phone }}</p>
                            </div>
                            <div>
                                <strong>Email:</strong>
                                <p>{{ $appointment->client_email }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="detail-section">
                    <h3><i class="fas fa-map-marker-alt"></i> Ubicación del Servicio</h3>
                    <div class="detail-info">
                        <p><strong>Dirección:</strong></p>
                        <p>{{ $appointment->service_address }}</p>
                        @if($appointment->address_references)
                            <p class="mt-2"><strong>Referencias:</strong></p>
                            <p>{{ $appointment->address_references }}</p>
                        @endif
                    </div>
                </div>

                @if($appointment->service_details)
                <div class="detail-section">
                    <h3><i class="fas fa-comment-dots"></i> Detalles del Servicio</h3>
                    <div class="detail-info">
                        <p>{{ $appointment->service_details }}</p>
                    </div>
                </div>
                @endif

                @if($appointment->admin_notes)
                <div class="detail-section">
                    <h3><i class="fas fa-sticky-note"></i> Notas del Administrador</h3>
                    <div class="detail-info alert-info">
                        <p>{{ $appointment->admin_notes }}</p>
                    </div>
                </div>
                @endif

                @if($appointment->client_notes)
                <div class="detail-section">
                    <h3><i class="fas fa-note-sticky"></i> Notas Adicionales</h3>
                    <div class="detail-info">
                        <p>{{ $appointment->client_notes }}</p>
                    </div>
                </div>
                @endif
            </div>

            <div class="detail-actions">
                <a href="{{ route('appointments.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver a Mis Citas
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
    </div>
</section>

@endsection

@push('styles')
<style>
    .appointment-detail-section {
        padding: 60px 0;
        background-color: #f8f9fa;
        min-height: 100vh;
    }

    .detail-wrapper {
        max-width: 900px;
        margin: 0 auto;
        background: white;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 3px solid #2c5aa0;
    }

    .detail-header h2 {
        margin: 0;
        color: #2c5aa0;
        font-size: 2rem;
    }

    .appointment-id {
        color: #666;
        margin-top: 5px;
        font-size: 0.9rem;
    }

    .detail-section {
        margin-bottom: 30px;
        padding-bottom: 25px;
        border-bottom: 1px solid #f0f0f0;
    }

    .detail-section:last-child {
        border-bottom: none;
    }

    .detail-section h3 {
        color: #2c5aa0;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.2rem;
    }

    .detail-info {
        color: #555;
        line-height: 1.8;
    }

    .service-name {
        font-size: 1.3rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
    }

    .price-info {
        margin-top: 10px;
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 5px;
    }

    .price-info.final {
        background-color: #d4edda;
        border-left: 4px solid #28a745;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .info-grid strong {
        display: block;
        color: #2c5aa0;
        margin-bottom: 5px;
    }

    .timeline {
        margin-top: 20px;
        padding-left: 20px;
    }

    .timeline-item {
        display: flex;
        align-items: start;
        gap: 15px;
        padding: 15px 0;
        opacity: 0.4;
        position: relative;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: 11px;
        top: 40px;
        width: 2px;
        height: calc(100% + 15px);
        background-color: #ddd;
    }

    .timeline-item:last-child::before {
        display: none;
    }

    .timeline-item.active {
        opacity: 1;
    }

    .timeline-item i {
        font-size: 1.5rem;
        color: #28a745;
        min-width: 24px;
    }

    .timeline-item.cancelled i {
        color: #dc3545;
    }

    .timeline-item strong {
        display: block;
        color: #333;
    }

    .timeline-item span {
        font-size: 0.9rem;
        color: #666;
    }

    .alert-info {
        background-color: #d1ecf1;
        border-left: 4px solid #17a2b8;
        padding: 15px;
        border-radius: 5px;
    }

    .detail-actions {
        display: flex;
        gap: 15px;
        justify-content: space-between;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid #f0f0f0;
    }

    .btn-secondary,
    .btn-cancel {
        padding: 12px 24px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    .btn-cancel {
        background-color: #dc3545;
        color: white;
    }

    .btn-cancel:hover {
        background-color: #c82333;
    }

    .mt-2 {
        margin-top: 10px;
    }

    @media (max-width: 768px) {
        .detail-wrapper {
            padding: 25px;
        }

        .detail-header {
            flex-direction: column;
            gap: 15px;
        }

        .detail-actions {
            flex-direction: column-reverse;
        }

        .detail-actions button,
        .detail-actions a {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush