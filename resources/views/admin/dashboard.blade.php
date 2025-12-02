@extends('layouts.app')

@section('title', 'Panel de Administración - GM Llaves y Cerraduras')

@section('content')

<section class="admin-dashboard">
    <div class="container">
        <div class="dashboard-header">
            <h2>Panel de Administración</h2>
            <p>Bienvenido, {{ auth()->user()->name }}</p>
        </div>

        <!-- Estadísticas -->
        <div class="stats-grid">
            <div class="stat-card pending">
                <i class="fas fa-clock"></i>
                <div>
                    <h3>{{ $pendingAppointments }}</h3>
                    <p>Citas Pendientes</p>
                </div>
            </div>
            
            <div class="stat-card today">
                <i class="fas fa-calendar-day"></i>
                <div>
                    <h3>{{ $todayAppointments }}</h3>
                    <p>Citas de Hoy</p>
                </div>
            </div>
            
            <div class="stat-card clients">
                <i class="fas fa-users"></i>
                <div>
                    <h3>{{ $totalClients }}</h3>
                    <p>Total Clientes</p>
                </div>
            </div>
        </div>

        <!-- Menú de Gestión -->
        <div class="admin-menu">
            <h3>Gestión de Citas</h3>
            <div class="menu-grid">
                <a href="{{ route('admin.appointments.all') }}" class="menu-item">
                    <i class="fas fa-list"></i>
                    <span>Todas las Citas</span>
                </a>
                
                <a href="{{ route('admin.appointments.pending') }}" class="menu-item">
                    <i class="fas fa-hourglass-half"></i>
                    <span>Citas Pendientes</span>
                    @if($pendingAppointments > 0)
                        <span class="badge">{{ $pendingAppointments }}</span>
                    @endif
                </a>
                
                <a href="{{ route('admin.appointments.today') }}" class="menu-item">
                    <i class="fas fa-calendar-check"></i>
                    <span>Citas de Hoy</span>
                </a>
                
                <a href="{{ route('admin.appointments.upcoming') }}" class="menu-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Próximas Citas</span>
                </a>
            </div>
        </div>

        <!-- Últimas Citas Pendientes -->
        <div class="recent-appointments">
            <h3>Últimas Citas Pendientes de Confirmar</h3>
            @php
                $recentPending = \App\Models\Appointment::with(['user', 'service'])
                    ->pending()
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();
            @endphp

            @if($recentPending->count() > 0)
                <div class="appointments-table-wrapper">
                    <table class="appointments-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Servicio</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Teléfono</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentPending as $appointment)
                            <tr>
                                <td>#{{ $appointment->id }}</td>
                                <td>{{ $appointment->client_name }}</td>
                                <td>{{ $appointment->service->name }}</td>
                                <td>{{ $appointment->formatted_date }}</td>
                                <td>{{ $appointment->formatted_time }}</td>
                                <td>{{ $appointment->client_phone }}</td>
                                <td class="actions">
                                    <a href="{{ route('admin.appointments.show', $appointment) }}" class="btn-view" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.appointments.confirm', $appointment) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-confirm" title="Confirmar">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="view-all">
                    <a href="{{ route('admin.appointments.pending') }}" class="btn-primary">
                        Ver Todas las Pendientes <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            @else
                <div class="no-data">
                    <i class="fas fa-check-circle"></i>
                    <p>No hay citas pendientes de confirmar</p>
                </div>
            @endif
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    .admin-dashboard {
        padding: 60px 0;
        background-color: #f8f9fa;
        min-height: 100vh;
        margin-top: 50px;
    }

    .dashboard-header {
        margin-bottom: 40px;
    }

    .dashboard-header h2 {
        color: #2c5aa0;
        font-size: 2.5rem;
        margin-bottom: 5px;
    }

    .dashboard-header p {
        color: #666;
        font-size: 1.1rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: white;
        padding: 30px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        border-left: 5px solid;
    }

    .stat-card.pending {
        border-color: #ffc107;
    }

    .stat-card.today {
        border-color: #17a2b8;
    }

    .stat-card.clients {
        border-color: #28a745;
    }

    .stat-card i {
        font-size: 3rem;
        opacity: 0.7;
    }

    .stat-card.pending i {
        color: #ffc107;
    }

    .stat-card.today i {
        color: #17a2b8;
    }

    .stat-card.clients i {
        color: #28a745;
    }

    .stat-card h3 {
        font-size: 2.5rem;
        margin: 0;
        color: #333;
    }

    .stat-card p {
        margin: 0;
        color: #666;
        font-size: 0.95rem;
    }

    .admin-menu {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 40px;
    }

    .admin-menu h3 {
        color: #2c5aa0;
        margin-bottom: 20px;
        font-size: 1.5rem;
    }

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .menu-item {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        text-decoration: none;
        color: #333;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.3s ease;
        position: relative;
    }

    .menu-item:hover {
        background: #2c5aa0;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(44, 90, 160, 0.3);
    }

    .menu-item i {
        font-size: 1.5rem;
    }

    .menu-item .badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #dc3545;
        color: white;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: bold;
    }

    .recent-appointments {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .recent-appointments h3 {
        color: #2c5aa0;
        margin-bottom: 20px;
        font-size: 1.5rem;
    }

    .appointments-table-wrapper {
        overflow-x: auto;
        margin-bottom: 20px;
    }

    .appointments-table {
        width: 100%;
        border-collapse: collapse;
    }

    .appointments-table th {
        background: #2c5aa0;
        color: white;
        padding: 12px;
        text-align: left;
        font-weight: 600;
    }

    .appointments-table td {
        padding: 12px;
        border-bottom: 1px solid #f0f0f0;
    }

    .appointments-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .appointments-table .actions {
        display: flex;
        gap: 8px;
    }

    .btn-view,
    .btn-confirm {
        padding: 6px 10px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-view {
        background: #17a2b8;
        color: white;
        text-decoration: none;
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

    .view-all {
        text-align: center;
        padding-top: 20px;
    }

    .no-data {
        text-align: center;
        padding: 40px;
        color: #666;
    }

    .no-data i {
        font-size: 3rem;
        color: #28a745;
        margin-bottom: 15px;
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .menu-grid {
            grid-template-columns: 1fr;
        }

        .appointments-table {
            font-size: 0.85rem;
        }

        .appointments-table th,
        .appointments-table td {
            padding: 8px;
        }
    }
</style>
@endpush