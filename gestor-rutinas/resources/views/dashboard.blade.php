@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h2>Mis Rutinas</h2>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createRoutineModal">Nueva rutina</button>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @forelse ($routines as $routine)
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $routine->name }}</h5>
            <p class="card-text">{{ $routine->description }}</p>
            <a href="{{ route('routines.show', $routine->id) }}" class="btn btn-primary btn-sm">Ver</a>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editRoutineModal{{ $routine->id }}">
                Editar
            </button>
            <form action="{{ route('routines.delete', $routine->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta rutina?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
            </form>

        </div>

        <!-- Modal de edición -->
        <div class="modal fade" id="editRoutineModal{{ $routine->id }}" tabindex="-1" aria-labelledby="editRoutineModalLabel{{ $routine->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form action="{{ route('routines.update', $routine->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title" id="editRoutineModalLabel{{ $routine->id }}">Editar Rutina</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name{{ $routine->id }}" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="name{{ $routine->id }}" name="name" value="{{ $routine->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="description{{ $routine->id }}" class="form-label">Descripción</label>
                                <textarea class="form-control" id="description{{ $routine->id }}" name="description" rows="3" required>{{ $routine->description }}</textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
    @empty
    <p>No tienes rutinas aún.</p>
    @endforelse
</div>

<!-- Modal -->
<div class="modal fade" id="createRoutineModal" tabindex="-1" aria-labelledby="createRoutineModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="createRoutineForm" class="modal-content" action="{{ route('routines.store') }}" method="POST">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="createRoutineModalLabel">Nueva Rutina</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea class="form-control" name="description"></textarea>
                </div>


                @if(auth()->user()->is_admin)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_template" value="1" id="is_template">
                    <label class="form-check-label" for="is_template">Es plantilla</label>
                </div>
                @endif

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>

@endsection