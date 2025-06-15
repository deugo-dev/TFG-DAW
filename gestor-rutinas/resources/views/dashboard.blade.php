@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex align-items-center">
                    <div class="bg-primary rounded-circle p-3 me-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-home text-white fs-4"></i>
                    </div>
                    <div>
                        <h1 class="mb-1 text-dark fw-bold">Mis Rutinas</h1>
                        <p class="text-muted mb-0">{{ $routines->count() }} rutinas en tu colección</p>
                    </div>
                </div>
                <button class="btn btn-success px-4 py-2" data-bs-toggle="modal" data-bs-target="#createRoutineModal" style="border-radius: 12px;">
                    <i class="fas fa-plus me-2"></i>Nueva rutina
                </button>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success border-0 shadow" style="border-radius: 12px;">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    </div>
    @endif

    <!-- Routines List -->
    <div class="row">
        <div class="col-12">
            @forelse ($routines as $routine)
            <div class="card mb-3 shadow border-0" style="border-radius: 12px; transition: transform 0.2s;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <!-- Icon -->
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-4" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-list text-primary"></i>
                        </div>

                        <!-- Content -->
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 class="fw-bold mb-1 text-dark">{{ $routine->name }}</h5>
                                    <div class="d-flex align-items-center text-muted small">
                                        <i class="fas fa-dumbbell me-1"></i>
                                        @php $count = $routine->exercises->count(); @endphp
                                        <span>{{ $count }} {{ Str::plural('ejercicio', $count) }}</span>
                                    </div>
                                </div>


                                <!-- Action Buttons -->
                                <div class="d-flex gap-2">
                                    <a href="{{ route('routines.show', $routine->id) }}" class="btn btn-primary btn-sm" style="border-radius: 8px;">
                                        <i class="fas fa-eye me-1"></i>Ver
                                    </a>
                                    <button type="button" class="btn btn-outline-secondary btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#editRoutineModal{{ $routine->id }}"
                                        style="border-radius: 8px;">
                                        <i class="fas fa-edit me-1"></i>Editar
                                    </button>
                                    <form action="{{ route('routines.delete', $routine->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                            style="border-radius: 8px;"
                                            onclick="return confirm('¿Estás seguro de que quieres eliminar esta rutina?')">
                                            <i class="fas fa-trash me-1"></i>Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>

                            @if($routine->description)
                            <p class="text-muted mb-0" style="font-size: 0.9rem;">
                                {{ Str::limit($routine->description, 300) }}
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="bg-light rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center"
                        style="width: 120px; height: 120px;">
                        <i class="fas fa-list text-muted fs-1"></i>
                    </div>
                    <h4 class="text-muted mb-2">No tienes rutinas aún</h4>
                    <p class="text-muted mb-4">Crea tu primera rutina de ejercicios personalizada</p>
                    <button class="btn btn-success px-4 py-2" data-bs-toggle="modal" data-bs-target="#createRoutineModal" style="border-radius: 12px;">
                        <i class="fas fa-plus me-2"></i>Crear primera rutina
                    </button>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

@foreach ($routines as $routine)
<div class="modal fade" id="editRoutineModal{{ $routine->id }}" tabindex="-1" aria-labelledby="editRoutineModalLabel{{ $routine->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <form action="{{ route('routines.update', $routine->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="editRoutineModalLabel{{ $routine->id }}">
                        <i class="fas fa-edit text-primary me-2"></i>Editar Rutina
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label for="name{{ $routine->id }}" class="form-label small fw-medium text-muted">NOMBRE *</label>
                        <input type="text" class="form-control border-0 bg-light" id="name{{ $routine->id }}" name="name"
                            value="{{ $routine->name }}" required style="border-radius: 8px;">
                    </div>
                    <div class="mb-3">
                        <label for="description{{ $routine->id }}" class="form-label small fw-medium text-muted">DESCRIPCIÓN</label>
                        <textarea class="form-control border-0 bg-light" id="description{{ $routine->id }}" name="description"
                            rows="3" style="border-radius: 8px;">{{ $routine->description }}</textarea>
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 8px;">Cancelar</button>
                    <button type="submit" class="btn btn-primary" style="border-radius: 8px;">
                        <i class="fas fa-save me-1"></i>Guardar cambios
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
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <form id="createRoutineForm" action="{{ route('routines.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="createRoutineModalLabel">
                        <i class="fas fa-plus text-success me-2"></i>Nueva Rutina
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label for="name" class="form-label small fw-medium text-muted">NOMBRE *</label>
                        <input type="text" class="form-control border-0 bg-light" name="name" required style="border-radius: 8px;" placeholder="Ej: Rutina de mañana">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label small fw-medium text-muted">DESCRIPCIÓN</label>
                        <textarea class="form-control border-0 bg-light" name="description" rows="3" style="border-radius: 8px;" placeholder="Describe tu rutina..."></textarea>
                    </div>

                    @if(auth()->user()->is_admin)
                    <div class="form-check p-3 bg-light rounded" style="border-radius: 8px;">
                        <input class="form-check-input" type="checkbox" name="is_template" value="1" id="is_template">
                        <label class="form-check-label fw-medium" for="is_template">
                            <i class="fas fa-star text-warning me-1"></i>Marcar como plantilla
                        </label>
                        <small class="form-text text-muted d-block mt-1">Las plantillas estarán disponibles para todos los usuarios</small>
                    </div>
                    @endif
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 8px;">Cancelar</button>
                    <button type="submit" class="btn btn-success" style="border-radius: 8px;">
                        <i class="fas fa-save me-1"></i>Crear rutina
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .card:hover {
        transform: translateY(-2px);
    }

    .form-control:focus,
    .form-select:focus {
        box-shadow: 0 0 0 0.2rem rgba(var(--bs-primary-rgb), 0.25);
        border-color: var(--bs-primary) !important;
    }

    .btn {
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .modal-content {
        backdrop-filter: blur(10px);
    }

    .form-check-input:checked {
        background-color: var(--bs-success);
        border-color: var(--bs-success);
    }

    .bg-opacity-10 {
        opacity: 0.1;
    }
</style>
@endsection