@extends('layouts.app')

@section('title', 'Citas Pendientes - Admin')

@section('content')

<section class="admin-appointments">
    <div class="container">
        <div class="page-header">
            <div>
                <h2>Citas Pendientes de Confirmar</h2>
                <p>Revisa y confirma las nuevas citas agendadas</p>
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
            <a href="{{ route('admin.appointments.pending') }}" class="filter-btn active">
                <i class="fas fa-clock"></i> Pendientes
            </a>
            <a href="{{ route('admin.appointments.today') }}" class="filter-btn">
                <i class="fas fa-calendar-day"></i> Hoy
            </a>
            <a href="{{ route('admin.appointments.upcoming') }}" class="filter-btn">
                <i class="fas fa-calendar-alt"></i> Próximas
            </a>
        </div>

        @if($appointments->count() > 0)
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>¡Atención!</strong> Tienes {{ $appointments->total() }} cita(s) pendiente(s) de confirmar.
            </div>

            <div class="appointments-grid">
                @foreach($appointments as $appointment)
                    <div class="appointment-card pending-card">
                        <div class="card-header">
                            <div>
                                <h3>{{ $appointment->service->name }}</h3>
                                <span class="appointment-id">#{{ $appointment->id }}</span>
                            </div>
                            <span class="badge badge-warning">Pendiente</span>
                        </div>

                        <div class="card-body">
                            <div class="info-row">
                                <i class="fas fa-user"></i>
                                <div>
                                    <strong>Cliente:</strong>
                                    <p>{{ $appointment->client_name }}</p>
                                </div>
                            </div>

                            <div class="info-row">
                                <i class="fas fa-phone"></i>
                                <div>
                                    <strong>Teléfono:</strong>
                                    <p>{{ $appointment->client_phone }}</p>
                                </div>
                            </div>

                            <div class="info-row">
                                <i class="fas fa-calendar"></i>
                                <div>
                                    <strong>Fecha y Hora:</strong>
                                    <p>{{ $appointment->formatted_date }} a las {{ $appointment->formatted_time }}</p>
                                </div>
                            </div>

                            <div class="info-row">
                                <i class="fas fa-map-marker-alt"></i>
                                <div>
                                    <strong>Dirección:</strong>
                                    <p>{{ $appointment->service_address }}</p>
                                </div>
                            </div>

                            @if($appointment->service_details)
                                <div class="info-row">
                                    <i class="fas fa-comment-dots"></i>
                                    <div>
                                        <strong>Detalles:</strong>
                                        <p>{{ Str::limit($appointment->service_details, 100) }}</p>
                                    </div>
                                </div>
                            @endif

                            <div class="info-row time-info">
                                <i class="fas fa-clock"></i>
                                <small>Solicitada hace {{ $appointment->created_at->diffForHumans() }}</small>
                            </div>
                        </div>

                        <div class="card-footer">
                            <a href="{{ route('admin.appointments.show', $appointment) }}" class="btn-view">
                                <i class="fas fa-eye"></i> Ver Detalles
                            </a>
                            <form action="{{ route('admin.appointments.confirm', $appointment) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn-confirm" onclick="return confirm('¿Confirmar esta cita?')">
                                    <i class="fas fa-check"></i> Confirmar Cita
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination-wrapper">
                {{ $appointments->links() }}
            </div>
        @else
            <div class="no-data success">
                <i class="fas fa-check-circle"></i>
                <h3>¡Todo al día!</h3>
                <p>No hay citas pendientes de confirmar</p>
                <a href="{{ route('admin.appointments.upcoming') }}" class="btn-primary">
                    Ver Próximas Citas 
                </a>
            </div>
        @endif
    </div>
</section>

@endsection

@push('styles')
<style>
    .admin-appointments {
        padding: 60px 0;
        background-color: #f8f9fa;
        min-height: 100vh;
        margin-top: 50px;
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

    .alert-warning {
        background-color: #fff3cd;
        border-left: 4px solid #ffc107;
        color: #856404;
    }

    .alert i {
        font-size: 1.5rem;
    }

    .appointments-grid {
        display: grid;
        gap: 20px;
    }

    .appointment-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .pending-card {
        border-left: 5px solid #ffc107;
    }

    .card-header {
        padding: 20px;
        background: #f8f9fa;
        border-bottom: 2px solid #e0e0e0;
        display: flex;
        justify-content: space-between;
        align-items: start;
    }

    .card-header h3 {
        margin: 0;
        color: #2c5aa0;
        font-size: 1.3rem;
    }

    .appointment-id {
        color: #666;
        font-size: 0.9rem;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .badge-warning {
        background-color: #ffc107;
        color: #333;
    }

    .card-body {
        padding: 20px;
    }

    .info-row {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
        align-items: start;
    }

    .info-row i {
        color: #2c5aa0;
        font-size: 1.2rem;
        width: 20px;
        margin-top: 3px;
    }

    .info-row strong {
        display: block;
        color: #333;
        margin-bottom: 3px;
    }

    .info-row p {
        margin: 0;
        color: #666;
    }

    .time-info {
        padding-top: 10px;
        border-top: 1px solid #f0f0f0;
        margin-top: 10px;
    }

    .time-info small {
        color: #999;
    }

    .card-footer {
        padding: 15px 20px;
        background: #f8f9fa;
        display: flex;
        gap: 10px;
        border-top: 1px solid #e0e0e0;
    }

    .btn-view,
    .btn-confirm {
        padding: 10px 20px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-view {
        background: #17a2b8;
        color: white;
        flex: 1;
        justify-content: center;
    }

    .btn-view:hover {
        background: #138496;
    }

    .btn-confirm {
        background: #28a745;
        color: white;
        flex: 2;
        justify-content: center;
    }

    .btn-confirm:hover {
        background: #218838;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }

    .pagination-wrapper {
        margin-top: 30px;
        display: flex;
        justify-content: center;
    }

    .no-data {
        background: white;
        padding: 60px 20px;
        text-align: center;
        border-radius: 10px;
    }

    .no-data.success i {
        font-size: 4rem;
        color: #28a745;
        margin-bottom: 20px;
    }

    .no-data h3 {
        color: #333;
        margin-bottom: 10px;
    }

    .no-data p {
        color: #666;
        margin-bottom: 25px;
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .card-footer {
            flex-direction: column;
        }

        .btn-view,
        .btn-confirm {
            width: 100%;
        }
    }
</style>
@endpush