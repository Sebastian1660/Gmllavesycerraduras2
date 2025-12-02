@extends('layouts.app')

@section('title', 'Próximas Citas - Admin')

@section('content')

<section class="admin-appointments">
    <div class="container">
        <div class="page-header">
            <div>
                <h2>Próximas Citas</h2>
                <p>Citas confirmadas y pendientes para los próximos días</p>
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
            <a href="{{ route('admin.appointments.today') }}" class="filter-btn">
                <i class="fas fa-calendar-day"></i> Hoy
            </a>
            <a href="{{ route('admin.appointments.upcoming') }}" class="filter-btn active">
                <i class="fas fa-calendar-alt"></i> Próximas
            </a>
        </div>

        @if($appointments->count() > 0)
            <div class="calendar-view">
                @php
                    $currentDate = null;
                @endphp

                @foreach($appointments as $appointment)
                    @php
                        $appointmentDate = $appointment->appointment_date->format('Y-m-d');
                    @endphp

                    @if($currentDate !== $appointmentDate)
                        @if($currentDate !== null)
                            </div> <!-- Cerrar grupo anterior -->
                        @endif

                        @php
                            $currentDate = $appointmentDate;
                        @endphp

                        <div class="date-group">
                            <div class="date-header">
                                <div class="date-box">
                                    <span class="day">{{ $appointment->appointment_date->format('d') }}</span>
                                    <span class="month">{{ $appointment->appointment_date->format('M') }}</span>
                                </div>
                                <div class="date-info">
                                    <h3>{{ $appointment->appointment_date->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</h3>
                                    <p>{{ $appointment->appointment_date->diffForHumans() }}</p>
                                </div>
                            </div>

                            <div class="appointments-list">
                    @endif

                    <div class="appointment-item {{ $appointment->status }}">
                        <div class="time-badge">
                            {{ $appointment->formatted_time }}
                        </div>

                        <div class="appointment-content">
                            <div class="appointment-header">
                                <div>
                                    <h4>{{ $appointment->service->name }}</h4>
                                    <p class="client-info">
                                        <i class="fas fa-user"></i> {{ $appointment->client_name }}
                                        <span class="separator">•</span>
                                        <i class="fas fa-phone"></i> {{ $appointment->client_phone }}
                                    </p>
                                </div>
                                {!! $appointment->status_badge !!}
                            </div>

                            <div class="appointment-details">
                                <div class="detail-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $appointment->service_address }}</span>
                                </div>
                                @if($appointment->service_details)
                                    <div class="detail-item">
                                        <i class="fas fa-comment-dots"></i>
                                        <span>{{ Str::limit($appointment->service_details, 80) }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="appointment-actions">
                                <a href="{{ route('admin.appointments.show', $appointment) }}" class="btn-sm btn-view">
                                    <i class="fas fa-eye"></i> Ver
                                </a>

                                @if($appointment->status === 'pending')
                                    <form action="{{ route('admin.appointments.confirm', $appointment) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-sm btn-success">
                                            <i class="fas fa-check"></i> Confirmar
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($loop->last)
                        </div> <!-- Cerrar appointments-list -->
                        </div> <!-- Cerrar date-group -->
                    @endif
                @endforeach
            </div>

            <div class="pagination-wrapper">
                {{ $appointments->links() }}
            </div>
        @else
            <div class="no-data">
                <i class="fas fa-calendar-check"></i>
                <h3>No hay citas próximas</h3>
                <p>No tienes citas confirmadas o pendientes para los próximos días</p>
                <a href="{{ route('admin.appointments.all') }}" class="btn-primary">
                    Ver Todas las Citas
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

    .calendar-view {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    .date-group {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .date-header {
        background: linear-gradient(135deg, #2c5aa0 0%, #1e4a73 100%);
        color: white;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .date-box {
        background: white;
        color: #2c5aa0;
        padding: 10px 15px;
        border-radius: 8px;
        text-align: center;
        min-width: 70px;
    }

    .date-box .day {
        display: block;
        font-size: 2rem;
        font-weight: bold;
        line-height: 1;
    }

    .date-box .month {
        display: block;
        font-size: 0.9rem;
        text-transform: uppercase;
        margin-top: 5px;
    }

    .date-info h3 {
        margin: 0;
        font-size: 1.3rem;
        text-transform: capitalize;
    }

    .date-info p {
        margin: 5px 0 0 0;
        opacity: 0.9;
    }

    .appointments-list {
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .appointment-item {
        display: flex;
        gap: 20px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid #6c757d;
        transition: all 0.3s ease;
    }

    .appointment-item:hover {
        transform: translateX(5px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .appointment-item.pending {
        border-left-color: #ffc107;
    }

    .appointment-item.confirmed {
        border-left-color: #28a745;
    }

    .time-badge {
        background: #2c5aa0;
        color: white;
        padding: 10px 15px;
        border-radius: 8px;
        font-weight: bold;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 80px;
        height: fit-content;
    }

    .appointment-content {
        flex: 1;
    }

    .appointment-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 10px;
    }

    .appointment-header h4 {
        margin: 0 0 5px 0;
        color: #2c5aa0;
        font-size: 1.1rem;
    }

    .client-info {
        margin: 0;
        color: #666;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .separator {
        color: #ddd;
    }

    .appointment-details {
        margin-bottom: 10px;
    }

    .detail-item {
        display: flex;
        align-items: start;
        gap: 10px;
        margin-bottom: 8px;
        color: #666;
        font-size: 0.9rem;
    }

    .detail-item i {
        color: #2c5aa0;
        width: 16px;
        margin-top: 2px;
    }

    .appointment-actions {
        display: flex;
        gap: 8px;
    }

    .btn-sm {
        padding: 6px 12px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
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

    .no-data i {
        font-size: 4rem;
        color: #ddd;
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

        .date-header {
            flex-direction: column;
            text-align: center;
        }

        .appointment-item {
            flex-direction: column;
        }

        .time-badge {
            width: 100%;
        }

        .appointment-header {
            flex-direction: column;
            gap: 10px;
        }

        .appointment-actions {
            flex-direction: column;
        }

        .btn-sm {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush