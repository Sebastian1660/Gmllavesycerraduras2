@extends('layouts.app')

@section('title', 'Detalle de Cita #' . $appointment->id . ' - Admin')

@section('content')

<section class="appointment-detail-admin">
    <div class="container">
        <div class="detail-header">
            <div>
                <h2>Cita #{{ $appointment->id }}</h2>
                <p>Gestión completa de la cita</p>
            </div>
            <div class="header-actions">
                {!! $appointment->status_badge !!}
                <a href="{{ route('admin.appointments.all') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>

        <div class="detail-grid">
            <!-- Información del Servicio -->
            <div class="detail-card">
                <h3><i class="fas fa-tools"></i> Servicio Solicitado</h3>
                <div class="card-content">
                    <div class="service-info">
                        <h4>{{ $appointment->service->name }}</h4>
                        <p>{{ $appointment->service->description }}</p>
                        <div class="service-meta">
                            <span><i class="fas fa-clock"></i> {{ $appointment->service->estimated_duration }} minutos</span>
                            @if($appointment->service->base_price)
                                <span><i class="fas fa-dollar-sign"></i> Base: {{ $appointment->service->formatted_price }}</span>
                            @endif
                        </div>
                    </div>

                    @if($appointment->estimated_price || $appointment->final_price)
                        <div class="price-section">
                            @if($appointment->estimated_price)
                                <div class="price-item">
                                    <span>Precio Estimado:</span>
                                    <strong>${{ number_format($appointment->estimated_price, 0, ',', '.') }}</strong>
                                </div>
                            @endif
                            @if($appointment->final_price)
                                <div class="price-item final">
                                    <span>Precio Final:</span>
                                    <strong>${{ number_format($appointment->final_price, 0, ',', '.') }}</strong>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Información del Cliente -->
            <div class="detail-card">
                <h3><i class="fas fa-user"></i> Información del Cliente</h3>
                <div class="card-content">
                    <div class="info-list">
                        <div class="info-row">
                            <span class="label">Nombre:</span>
                            <span class="value">{{ $appointment->client_name }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Teléfono:</span>
                            <span class="value">
                                <a href="tel:{{ $appointment->client_phone }}">{{ $appointment->client_phone }}</a>
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="label">Email:</span>
                            <span class="value">
                                <a href="mailto:{{ $appointment->client_email }}">{{ $appointment->client_email }}</a>
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="label">Usuario:</span>
                            <span class="value">{{ $appointment->user->name }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fecha y Hora -->
            <div class="detail-card">
                <h3><i class="fas fa-calendar-alt"></i> Fecha y Hora</h3>
                <div class="card-content">
                    <div class="datetime-display">
                        <div class="date-box">
                            <span class="day">{{ $appointment->appointment_date->format('d') }}</span>
                            <span class="month">{{ $appointment->appointment_date->format('M') }}</span>
                            <span class="year">{{ $appointment->appointment_date->format('Y') }}</span>
                        </div>
                        <div class="time-info">
                            <strong>{{ $appointment->formatted_time }}</strong>
                            <span>{{ $appointment->appointment_date->locale('es')->isoFormat('dddd') }}</span>
                            <small>{{ $appointment->appointment_date->diffForHumans() }}</small>
                        </div>
                    </div>

                    <div class="timeline">
                        @if($appointment->created_at)
                            <div class="timeline-item active">
                                <i class="fas fa-plus-circle"></i>
                                <div>
                                    <strong>Creada</strong>
                                    <span>{{ $appointment->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        @endif

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

            <!-- Ubicación -->
            <div class="detail-card full-width">
                <h3><i class="fas fa-map-marker-alt"></i> Ubicación del Servicio</h3>
                <div class="card-content">
                    <div class="location-info">
                        <p><strong>Dirección:</strong></p>
                        <p class="address">{{ $appointment->service_address }}</p>
                        @if($appointment->address_references)
                            <p><strong>Referencias:</strong></p>
                            <p class="references">{{ $appointment->address_references }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Detalles del Servicio -->
            @if($appointment->service_details)
                <div class="detail-card full-width">
                    <h3><i class="fas fa-comment-dots"></i> Detalles del Servicio</h3>
                    <div class="card-content">
                        <p>{{ $appointment->service_details }}</p>
                    </div>
                </div>
            @endif

            <!-- Notas del Administrador -->
            <div class="detail-card full-width">
                <h3><i class="fas fa-sticky-note"></i> Notas del Administrador</h3>
                <div class="card-content">
                    <form action="{{ route('admin.appointments.notes', $appointment) }}" method="POST">
                        @csrf
                        <textarea name="admin_notes" class="form-control" rows="4" placeholder="Agrega notas internas sobre esta cita...">{{ $appointment->admin_notes }}</textarea>
                        <button type="submit" class="btn-primary mt-2">
                            <i class="fas fa-save"></i> Guardar Notas
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="quick-actions">
            <h3>Acciones</h3>
            <div class="actions-grid">
                @if($appointment->status === 'pending')
                    <form action="{{ route('admin.appointments.confirm', $appointment) }}" method="POST">
                        @csrf
                        <button type="submit" class="action-btn confirm">
                            <i class="fas fa-check-circle"></i>
                            <span>Confirmar Cita</span>
                        </button>
                    </form>
                @endif

                @if($appointment->status === 'confirmed')
                    <form action="{{ route('admin.appointments.start', $appointment) }}" method="POST">
                        @csrf
                        <button type="submit" class="action-btn start">
                            <i class="fas fa-play-circle"></i>
                            <span>Iniciar Servicio</span>
                        </button>
                    </form>
                @endif

                @if($appointment->status === 'in_progress')
                    <button type="button" class="action-btn complete" onclick="showCompleteModal()">
                        <i class="fas fa-check-double"></i>
                        <span>Completar Servicio</span>
                    </button>
                @endif

                @if(!in_array($appointment->status, ['completed', 'cancelled']))
                    <button type="button" class="action-btn cancel" onclick="showCancelModal()">
                        <i class="fas fa-times-circle"></i>
                        <span>Cancelar Cita</span>
                    </button>
                @endif

                <a href="tel:{{ $appointment->client_phone }}" class="action-btn call">
                    <i class="fas fa-phone"></i>
                    <span>Llamar Cliente</span>
                </a>

                <a href="mailto:{{ $appointment->client_email }}" class="action-btn email">
                    <i class="fas fa-envelope"></i>
                    <span>Enviar Email</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Modal Completar -->
<div id="completeModal" class="modal" style="display: none;">
    <div class="modal-content">
        <h3>Completar Servicio</h3>
        <form action="{{ route('admin.appointments.complete', $appointment) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="final_price">Precio Final</label>
                <input type="number" name="final_price" id="final_price" class="form-control" step="1000" min="0" placeholder="Ingrese el precio final del servicio">
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-secondary" onclick="closeCompleteModal()">Cancelar</button>
                <button type="submit" class="btn-primary">Completar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Cancelar -->
<div id="cancelModal" class="modal" style="display: none;">
    <div class="modal-content">
        <h3>Cancelar Cita</h3>
        <form action="{{ route('admin.appointments.cancel', $appointment) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="reason">Motivo de Cancelación</label>
                <textarea name="reason" id="reason" class="form-control" rows="3" placeholder="Explica el motivo de la cancelación..."></textarea>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-secondary" onclick="closeCancelModal()">Volver</button>
                <button type="submit" class="btn-danger">Confirmar Cancelación</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
<style>
    .appointment-detail-admin {
        padding: 60px 0;
        background-color: #f8f9fa;
        min-height: 100vh;
        margin-top: 50px;
    }

    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .detail-header h2 {
        color: #2c5aa0;
        font-size: 2rem;
        margin: 0;
    }

    .detail-header p {
        color: #666;
        margin: 5px 0 0 0;
    }

    .header-actions {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .detail-card {
        background: white;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .detail-card.full-width {
        grid-column: 1 / -1;
    }

    .detail-card h3 {
        color: #2c5aa0;
        margin: 0 0 20px 0;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.2rem;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }

    .service-info h4 {
        margin: 0 0 10px 0;
        color: #333;
        font-size: 1.3rem;
    }

    .service-meta {
        display: flex;
        gap: 20px;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #f0f0f0;
    }

    .service-meta span {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #666;
    }

    .price-section {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px solid #f0f0f0;
    }

    .price-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px;
        background: #f8f9fa;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .price-item.final {
        background: #d4edda;
        border-left: 4px solid #28a745;
    }

    .info-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .info-row {
        display: grid;
        grid-template-columns: 120px 1fr;
        gap: 15px;
    }

    .info-row .label {
        font-weight: 600;
        color: #666;
    }

    .info-row .value a {
        color: #2c5aa0;
        text-decoration: none;
    }

    .datetime-display {
        display: flex;
        gap: 20px;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 2px solid #f0f0f0;
    }

    .date-box {
        background: linear-gradient(135deg, #2c5aa0 0%, #1e4a73 100%);
        color: white;
        padding: 15px;
        border-radius: 10px;
        text-align: center;
        min-width: 80px;
    }

    .date-box .day {
        display: block;
        font-size: 2.5rem;
        font-weight: bold;
        line-height: 1;
    }

    .date-box .month {
        display: block;
        font-size: 1rem;
        text-transform: uppercase;
        margin-top: 5px;
    }

    .date-box .year {
        display: block;
        font-size: 0.85rem;
        opacity: 0.8;
    }

    .time-info strong {
        display: block;
        font-size: 1.5rem;
        color: #2c5aa0;
    }

    .time-info span {
        display: block;
        color: #666;
        text-transform: capitalize;
    }

    .time-info small {
        display: block;
        color: #999;
        margin-top: 5px;
    }

    .timeline {
        padding-left: 20px;
    }

    .timeline-item {
        display: flex;
        align-items: start;
        gap: 15px;
        padding: 12px 0;
        opacity: 0.4;
        position: relative;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: 11px;
        top: 35px;
        width: 2px;
        height: calc(100% + 12px);
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

    .location-info .address,
    .location-info .references {
        margin: 10px 0;
        padding: 12px;
        background: #f8f9fa;
        border-radius: 5px;
        color: #666;
    }

    .form-control {
        width: 100%;
        padding: 12px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-family: inherit;
        font-size: 1rem;
    }

    .form-control:focus {
        outline: none;
        border-color: #2c5aa0;
    }

    .mt-2 {
        margin-top: 10px;
    }

    .quick-actions {
        background: white;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .quick-actions h3 {
        color: #2c5aa0;
        margin: 0 0 20px 0;
        font-size: 1.2rem;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .action-btn {
        padding: 15px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        text-decoration: none;
        color: white;
    }

    .action-btn i {
        font-size: 2rem;
    }

    .action-btn span {
        font-weight: 500;
    }

    .action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .action-btn.confirm {
        background: #28a745;
    }

    .action-btn.start {
        background: #17a2b8;
    }

    .action-btn.complete {
        background: #007bff;
    }

    .action-btn.cancel {
        background: #dc3545;
    }

    .action-btn.call {
        background: #20c997;
    }

    .action-btn.email {
        background: #6c757d;
    }

    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .modal-content {
        background: white;
        padding: 30px;
        border-radius: 10px;
        max-width: 500px;
        width: 90%;
    }

    .modal-content h3 {
        margin: 0 0 20px 0;
        color: #2c5aa0;
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

    .modal-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 20px;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
    }

    .btn-danger:hover {
        background: #c82333;
    }

    @media (max-width: 768px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }

        .detail-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .header-actions {
            width: 100%;
            justify-content: space-between;
        }

        .actions-grid {
            grid-template-columns: 1fr;
        }

        .datetime-display {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function showCompleteModal() {
        document.getElementById('completeModal').style.display = 'flex';
    }

    function closeCompleteModal() {
        document.getElementById('completeModal').style.display = 'none';
    }

    function showCancelModal() {
        document.getElementById('cancelModal').style.display = 'flex';
    }

    function closeCancelModal() {
        document.getElementById('cancelModal').style.display = 'none';
    }

    // Cerrar modales al hacer clic fuera
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.style.display = 'none';
            }
        });
    });
</script>
@endpush