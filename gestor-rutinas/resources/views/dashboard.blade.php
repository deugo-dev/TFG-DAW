@extends('layouts.app', ['noFooter' => true])

@section('title', 'Dashboard')

@section('content')
<style>
    body {
        background: #f8f9fa;
    }

    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .dashboard-header {
        background: #000000;
        color: #FFFFFF;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dashboard-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .dashboard-subtitle {
        color: rgba(255, 255, 255, 0.8);
        font-size: 1.1rem;
    }

    .routine-card {
        background: #FFFFFF;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border-left: 4px solid #76B4AA;
    }

    .routine-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .routine-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #000000;
        margin-bottom: 0.5rem;
    }

    .routine-info {
        color: #666;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .routine-description {
        color: #666;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
    }

    .btn-custom {
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary-custom {
        background: #76B4AA;
        color: #FFFFFF;
    }

    .btn-primary-custom:hover {
        background: #5a8e85;
        color: #FFFFFF;
        transform: translateY(-2px);
    }

    .btn-secondary-custom {
        background: transparent;
        border: 2px solid #7C97A1;
        color: #7C97A1;
    }

    .btn-secondary-custom:hover {
        background: #7C97A1;
        color: #FFFFFF;
    }

    .btn-danger-custom {
        background: transparent;
        border: 2px solid #dc3545;
        color: #dc3545;
    }

    .btn-danger-custom:hover {
        background: #dc3545;
        color: #FFFFFF;
    }

    .btn-success-custom {
        background: #76B4AA;
        color: #FFFFFF;
    }

    .btn-success-custom:hover {
        background: #5a8e85;
        transform: translateY(-2px);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: #FFFFFF;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .empty-icon {
        width: 120px;
        height: 120px;
        background: #f8f9fa;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
    }

    .modal-content {
        border: none;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        background: #000000;
        color: #FFFFFF;
        border-bottom: none;
        border-radius: 16px 16px 0 0;
    }

    .btn-close {
        filter: invert(1);
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 0.75rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #76B4AA;
        box-shadow: 0 0 0 0.2rem rgba(118, 180, 170, 0.25);
    }
</style>

<div class="dashboard-container">
    <!-- Header -->
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title">Mis Rutinas</h1>
            <p class="dashboard-subtitle">{{ $routines->count() }} rutinas en tu colección</p>
        </div>
        <button class="btn-custom btn-success-custom" data-bs-toggle="modal" data-bs-target="#createRoutineModal">
            <i class="fas fa-plus"></i>Nueva rutina
        </button>
    </div>

    @if(session('success'))
    <div class="alert alert-success border-0 shadow" style="border-radius: 12px;">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    </div>
    @endif

    <!-- Routines List -->
    @forelse ($routines as $routine)
    <div class="routine-card">
        <h3 class="routine-title">{{ $routine->name }}</h3>

        <div class="routine-info">
            <i class="fas fa-dumbbell"></i>
            @php $count = $routine->exercises->count(); @endphp
            <span>{{ $count }} {{ Str::plural('ejercicio', $count) }}</span>
        </div>

        @if($routine->description)
        <p class="routine-description">{{ Str::limit($routine->description, 300) }}</p>
        @endif

        <div class="action-buttons">
            <a href="{{ route('routines.show', $routine->id) }}" class="btn-custom btn-primary-custom">
                <i class="fas fa-eye"></i>Ver
            </a>
            <button type="button" class="btn-custom btn-secondary-custom"
                data-bs-toggle="modal" data-bs-target="#editRoutineModal{{ $routine->id }}">
                <i class="fas fa-edit"></i>Editar
            </button>
            <form action="{{ route('routines.delete', $routine->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-custom btn-danger-custom"
                    onclick="return confirm('¿Estás seguro de que quieres eliminar esta rutina?')">
                    <i class="fas fa-trash"></i>Eliminar
                </button>
            </form>
        </div>
    </div>

    @empty
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-list text-muted fs-1"></i>
        </div>
        <h4 class="text-muted mb-2">No tienes rutinas aún</h4>
        <p class="text-muted mb-4">Crea tu primera rutina de ejercicios personalizada</p>
        <button class="btn-custom btn-success-custom" data-bs-toggle="modal" data-bs-target="#createRoutineModal">
            <i class="fas fa-plus"></i>Crear primera rutina
        </button>
    </div>
    @endforelse
</div>

@foreach ($routines as $routine)
<div class="modal fade" id="editRoutineModal{{ $routine->id }}" tabindex="-1" aria-labelledby="editRoutineModalLabel{{ $routine->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('routines.update', $routine->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="editRoutineModalLabel{{ $routine->id }}">
                        <i class="fas fa-edit me-2"></i>Editar Rutina
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name{{ $routine->id }}" class="form-label fw-medium">Nombre *</label>
                        <input type="text" class="form-control" id="name{{ $routine->id }}" name="name"
                            value="{{ $routine->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="description{{ $routine->id }}" class="form-label fw-medium">Descripción</label>
                        <textarea class="form-control" id="description{{ $routine->id }}" name="description"
                            rows="3">{{ $routine->description }}</textarea>
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn-custom btn-secondary-custom" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn-custom btn-primary-custom">
                        <i class="fas fa-save"></i>Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Modal: Crear rutina -->
<div class="modal fade" id="createRoutineModal" tabindex="-1" aria-labelledby="createRoutineModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('routines.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createRoutineModalLabel">
                        <i class="fas fa-plus me-2"></i>Nueva Rutina
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-medium">Nombre *</label>
                        <input type="text" class="form-control" name="name" required placeholder="Ej: Rutina de mañana">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label fw-medium">Descripción</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Describe tu rutina..."></textarea>
                    </div>

                    @if(auth()->user()->is_admin)
                    <div class="form-check p-3 bg-light rounded">
                        <input class="form-check-input" type="checkbox" name="is_template" value="1" id="is_template">
                        <label class="form-check-label fw-medium" for="is_template">
                            <i class="fas fa-star text-warning me-1"></i>Marcar como plantilla
                        </label>
                        <small class="form-text text-muted d-block mt-1">Las plantillas estarán disponibles para todos los usuarios</small>
                    </div>
                    @endif
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn-custom btn-secondary-custom" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn-custom btn-success-custom">
                        <i class="fas fa-save"></i>Crear rutina
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection