@extends('layouts.app')

@section('title', 'Citas de Hoy - Admin')

@section('content')

<section class="admin-appointments">
    <div class="container">
        <div class="page-header">
            <div>
                <h2>Citas de Hoy</h2>
                <p>{{ now()->format('l, d \d\e F \d\e Y') }}</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al Dashboard
            </a>
        </div>

        <!-- Filtros rápidos -->
        <div class="quick-filters">
            <a href="{{ route('admin.appointments.all') }}" class="filter-btn">
                <i class="fas fa-list"></i> Todas
            </a>
            <a href="{{ route('admin.appointments.pending') }}" class="filter-btn">
                <i class="fas fa-clock"></i> Pendientes
            </a>
            <a href="{{ route('admin.appointments.today') }}" class="filter-btn active">
                <i class="fas fa-calendar-day"></i> Hoy
            </a>
            <a href="{{ route('admin.appointments.upcoming') }}" class="filter-btn">
                <i class="fas fa-calendar-alt"></i> Próximas
            </a>
        </div>

        @if($appointments->count() > 0)
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                <strong>Agenda del día:</strong> Tienes {{ $appointments->count() }} cita(s) programada(s) para hoy.
            </div>

            <div class="timeline-view">
                @foreach($appointments as $appointment)
                    <div class="timeline-item {{ $appointment->status }}">
                        <div class="timeline-time">
                            <strong>{{ $appointment->formatted_time }}</strong>
                            <span>{{ $appointment->service->estimated_duration }} min</span>
                        </div>

                        <div class="timeline-content">
                            <div class="content-header">
                                <div>
                                    <h3>{{ $appointment->service->name }}</h3>
                                    <p class="client-name">
                                        <i class="fas fa-user"></i> {{ $appointment->client_name }}
                                    </p>
                                </div>
                                {!! $appointment->status_badge !!}
                            </div>

                            <div class="content-body">
                                <div class="info-columns">
                                    <div class="info-item">
                                        <i class="fas fa-phone"></i>
                                        <a href="tel:{{ $appointment->client_phone }}">{{ $appointment->client_phone }}</a>
                                    </div>
                                    <div class="info-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>{{ $appointment->service_address }}</span>
                                    </div>
                                </div>

                                @if($appointment->service_details)
                                    <div class="details-box">
                                        <strong>Detalles:</strong>
                                        <p>{{ $appointment->service_details }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="content-actions">
                                <a href="{{ route('admin.appointments.show', $appointment) }}" class="btn-view">
                                    <i class="fas fa-eye"></i> Ver Detalles
                                </a>

                                @if($appointment->status === 'pending')
                                    <form action="{{ route('admin.appointments.confirm', $appointment) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-action btn-success">
                                            <i class="fas fa-check"></i> Confirmar
                                        </button>
                                    </form>
                                @endif

                                @if($appointment->status === 'confirmed')
                                    <form action="{{ route('admin.appointments.start', $appointment) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-action btn-info">
                                            <i class="fas fa-play"></i> Iniciar
                                        </button>
                                    </form>
                                @endif

                                @if($appointment->status === 'in_progress')
                                    <button type="button" class="btn-action btn-primary" onclick="showCompleteModal({{ $appointment->id }})">
                                        <i class="fas fa-check-double"></i> Completar
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-data">
                <i class="fas fa-calendar-check"></i>
                <h3>No hay citas programadas para hoy</h3>
                <p>Revisa las próximas citas o las pendientes de confirmar</p>
                <div style="display: flex; gap: 15px; justify-content: center; margin-top: 20px;">
                    <a href="{{ route('admin.appointments.pending') }}" class="btn-primary">
                        Ver Pendientes
                    </a>
                    <a href="{{ route('admin.appointments.upcoming') }}" class="btn-secondary">
                        Ver Próximas
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Modal para completar cita -->
<div id="completeModal" class="modal" style="display: none;">
    <div class="modal-content">
        <h3>Completar Cita</h3>
        <form id="completeForm" method="POST">
            @csrf
            <div class="form-group">
                <label for="final_price">Precio Final (opcional)</label>
                <input type="number" name="final_price" id="final_price" class="form-control" step="1000" min="0" placeholder="Ingrese el precio final">
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-secondary" onclick="closeCompleteModal()">Cancelar</button>
                <button type="submit" class="btn-primary">Completar Cita</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
<style>
    .admin-appointments {
        padding: 60px 0;
        background-color: #f8f9fa;
        min-height: 100vh;
        margiin-top: 50px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .page-header h2 {
        color: #2c5aa0;
        font-size: 2rem;
        margin: 0;
    }

    .page-header p {
        color: #666;
        margin: 5px 0 0 0;
        font-weight: 500;
    }

    .quick-filters {
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 10px 20px;
        background: white;
        color: #666;
        text-decoration: none;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .filter-btn:hover {
        background: #2c5aa0;
        color: white;
    }

    .filter-btn.active {
        background: #2c5aa0;
        color: white;
        border-color: #1e4a73;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .alert-info {
        background-color: #d1ecf1;
        border-left: 4px solid #17a2b8;
        color: #0c5460;
    }

    .timeline-view {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .timeline-item {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        display: flex;
        overflow: hidden;
        border-left: 5px solid #6c757d;
    }

    .timeline-item.pending {
        border-left-color: #ffc107;
    }

    .timeline-item.confirmed {
        border-left-color: #28a745;
    }

    .timeline-item.in_progress {
        border-left-color: #17a2b8;
    }

    .timeline-item.completed {
        border-left-color: #007bff;
        opacity: 0.7;
    }

    .timeline-time {
        padding: 20px;
        background: #f8f9fa;
        min-width: 120px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        border-right: 2px solid #e0e0e0;
    }

    .timeline-time strong {
        font-size: 1.3rem;
        color: #2c5aa0;
    }

    .timeline-time span {
        font-size: 0.85rem;
        color: #666;
    }

    .timeline-content {
        flex: 1;
        padding: 20px;
    }

    .content-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }

    .content-header h3 {
        margin: 0 0 5px 0;
        color: #2c5aa0;
        font-size: 1.2rem;
    }

    .client-name {
        margin: 0;
        color: #666;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .content-body {
        margin-bottom: 15px;
    }

    .info-columns {
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

    .info-item a {
        color: #2c5aa0;
        text-decoration: none;
    }

    .info-item a:hover {
        text-decoration: underline;
    }

    .details-box {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-top: 15px;
    }

    .details-box strong {
        display: block;
        color: #2c5aa0;
        margin-bottom: 8px;
    }

    .details-box p {
        margin: 0;
        color: #666;
    }

    .content-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-view,
    .btn-action {
        padding: 8px 16px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .btn-view {
        background: #6c757d;
        color: white;
    }

    .btn-view:hover {
        background: #5a6268;
    }

    .btn-success {
        background: #28a745;
        color: white;
    }

    .btn-success:hover {
        background: #218838;
    }

    .btn-info {
        background: #17a2b8;
        color: white;
    }

    .btn-info:hover {
        background: #138496;
    }

    .btn-primary {
        background: #007bff;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary:hover {
        background: #0056b3;
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

    .modal-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 20px;
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
        padding: 10px;
        border: 2px solid #e0e0e0;
        border-radius: 5px;
    }

    .no-data {
        background: white;
        padding: 60px 20px;
        text-align: center;
        border-radius: 10px;
    }

    .no-data i {
        font-size: 4rem;
        color: #ddd;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .timeline-item {
            flex-direction: column;
        }

        .timeline-time {
            min-width: auto;
            border-right: none;
            border-bottom: 2px solid #e0e0e0;
        }

        .content-actions {
            flex-direction: column;
        }

        .content-actions button,
        .content-actions a {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function showCompleteModal(appointmentId) {
        const modal = document.getElementById('completeModal');
        const form = document.getElementById('completeForm');
        form.action = `/admin/citas/${appointmentId}/completar`;
        modal.style.display = 'flex';
    }

    function closeCompleteModal() {
        document.getElementById('completeModal').style.display = 'none';
    }

    // Cerrar modal al hacer clic fuera
    document.getElementById('completeModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeCompleteModal();
        }
    });
</script>
@endpush