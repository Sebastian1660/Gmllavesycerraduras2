@extends('layouts.app')

@section('title', 'Todas las Citas - Admin')

@section('content')

<section class="admin-appointments">
    <div class="container">
        <div class="page-header">
            <div>
                <h2>Todas las Citas</h2>
                <p>Gestión completa de citas agendadas</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al Dashboard
            </a>
        </div>

        <!-- Filtros rápidos -->
        <div class="quick-filters">
            <a href="{{ route('admin.appointments.all') }}" class="filter-btn active">
                <i class="fas fa-list"></i> Todas
            </a>
            <a href="{{ route('admin.appointments.pending') }}" class="filter-btn">
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
            <div class="table-responsive">
                <table class="appointments-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Servicio</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Estado</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                        <tr>
                            <td><strong>#{{ $appointment->id }}</strong></td>
                            <td>{{ $appointment->client_name }}</td>
                            <td>{{ $appointment->service->name }}</td>
                            <td>{{ $appointment->formatted_date }}</td>
                            <td>{{ $appointment->formatted_time }}</td>
                            <td>{!! $appointment->status_badge !!}</td>
                            <td>{{ $appointment->client_phone }}</td>
                            <td class="actions">
                                <a href="{{ route('admin.appointments.show', $appointment) }}" 
                                   class="btn-action btn-view" 
                                   title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if($appointment->status === 'pending')
                                    <form action="{{ route('admin.appointments.confirm', $appointment) }}" 
                                          method="POST" 
                                          style="display: inline;">
                                        @csrf
                                        <button type="submit" 
                                                class="btn-action btn-confirm" 
                                                title="Confirmar">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper">
                {{ $appointments->links() }}
            </div>
        @else
            <div class="no-data">
                <i class="fas fa-calendar-times"></i>
                <h3>No hay citas registradas</h3>
                <p>Las citas aparecerán aquí cuando los clientes las agenden</p>
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

    .table-responsive {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow-x: auto;
    }

    .appointments-table {
        width: 100%;
        border-collapse: collapse;
    }

    .appointments-table thead {
        background: #2c5aa0;
        color: white;
    }

    .appointments-table th {
        padding: 15px;
        text-align: left;
        font-weight: 600;
        white-space: nowrap;
    }

    .appointments-table td {
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }

    .appointments-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .actions {
        display: flex;
        gap: 8px;
    }

    .btn-action {
        padding: 8px 12px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-view {
        background: #17a2b8;
        color: white;
    }

    .btn-view:hover {
        background: #138496;
    }

    .btn-confirm {
        background: #28a745;
        color: white;
    }

    .btn-confirm:hover {
        background: #218838;
    }

    .pagination-wrapper {
        margin-top: 20px;
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
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .appointments-table {
            font-size: 0.85rem;
        }

        .appointments-table th,
        .appointments-table td {
            padding: 10px;
        }
    }
</style>
@endpush