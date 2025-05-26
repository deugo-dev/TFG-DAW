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
                </div>
            </div>
        @empty
            <p>No tienes rutinas aún.</p>
        @endforelse
    </div>

    <!-- Modal -->
    <div class="modal fade" id="createRoutineModal" tabindex="-1" aria-labelledby="createRoutineModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <!-- Aquí el formulario con acción y método POST -->
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
