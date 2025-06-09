@extends('layouts.app')

@section('content')
<div class="container mt-4">

  <div class="d-flex justify-content-between mb-3">
    <h2>Mis ejercicios</h2>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addExerciseModal">
      Añadir ejercicio nuevo
    </button>
  </div>
  @if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  {{-- Modal: Crear ejercicio --}}
  <div class="modal fade" id="addExerciseModal" tabindex="-1" aria-labelledby="addExerciseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="{{ route('exercises.store') }}" method="POST">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="addExerciseModalLabel">Añadir ejercicio</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="title" class="form-label">Título *</label>
              <input type="text" class="form-control" id="title" name="title" required maxlength="255">
            </div>

            <div class="mb-3">
              <label for="description" class="form-label">Descripción</label>
              <textarea class="form-control" id="description" name="description"></textarea>
            </div>

            <div class="mb-3">
              <label for="video_url" class="form-label">URL del video</label>
              <input type="url" class="form-control" id="video_url" name="video_url">
            </div>

            <div class="mb-3">
              <label for="category" class="form-label">Categoría *</label>
              <select class="form-select" id="category" name="category" required>
                <option disabled selected>Selecciona categoría</option>
                @foreach(['cardio', 'fuerza', 'estiramiento', 'flexibilidad', 'movilidad', 'core', 'calistenia'] as $cat)
                <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label for="difficulty_level" class="form-label">Nivel de dificultad *</label>
              <select class="form-select" id="difficulty_level" name="difficulty_level" required>
                <option disabled selected>Selecciona dificultad</option>
                @foreach(['fácil', 'medio', 'difícil'] as $level)
                <option value="{{ $level }}">{{ ucfirst($level) }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar ejercicio</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Lista de ejercicios --}}
  <div class="row">
    @forelse ($exercises as $exercise)
    <div class="col-md-4 mb-4">
      <div class="card shadow-sm">

        @if($exercise->getEmbedUrl())
        <iframe class="card-img-top" width="100%" height="200" src="{{ $exercise->getEmbedUrl() }}" frameborder="0" allowfullscreen></iframe>
        @endif

        <div class="card-body">
          <h5 class="card-title">{{ $exercise->title }}</h5>
          <p class="card-text">{{ $exercise->description }}</p>
          <p><strong>Categoría:</strong> {{ ucfirst($exercise->category) }}</p>
          <p><strong>Dificultad:</strong> {{ ucfirst($exercise->difficulty_level) }}</p>

          <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editExerciseModal{{ $exercise->id }}">
            Editar
          </button>
          <form action="{{ route('exercises.delete', $exercise) }}" method="POST" class="d-inline-block">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar ejercicio?')">Eliminar</button>
          </form>
        </div>
      </div>
    </div>

    {{-- Modal: Editar ejercicio --}}
    <div class="modal fade" id="editExerciseModal{{ $exercise->id }}" tabindex="-1" aria-labelledby="editExerciseModalLabel{{ $exercise->id }}" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form action="{{ route('exercises.update', $exercise) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-header">
              <h5 class="modal-title" id="editExerciseModalLabel{{ $exercise->id }}">Editar ejercicio</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="title{{ $exercise->id }}" class="form-label">Título *</label>
                <input type="text" class="form-control" id="title{{ $exercise->id }}" name="title"
                  value="{{ $exercise->title }}" required maxlength="255">
              </div>

              <div class="mb-3">
                <label for="description{{ $exercise->id }}" class="form-label">Descripción</label>
                <textarea class="form-control" id="description{{ $exercise->id }}" name="description">{{ $exercise->description }}</textarea>
              </div>

              <div class="mb-3">
                <label for="video_url{{ $exercise->id }}" class="form-label">URL del video</label>
                <input type="url" class="form-control" id="video_url{{ $exercise->id }}" name="video_url"
                  value="{{ $exercise->video_url }}">
              </div>

              <div class="mb-3">
                <label for="category{{ $exercise->id }}" class="form-label">Categoría *</label>
                <select class="form-select" id="category{{ $exercise->id }}" name="category" required>
                  @foreach(['cardio', 'fuerza', 'estiramiento', 'flexibilidad', 'movilidad', 'core', 'calistenia'] as $cat)
                  <option value="{{ $cat }}" {{ $exercise->category === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label for="difficulty_level{{ $exercise->id }}" class="form-label">Nivel de dificultad *</label>
                <select class="form-select" id="difficulty_level{{ $exercise->id }}" name="difficulty_level" required>
                  @foreach(['fácil', 'medio', 'difícil'] as $level)
                  <option value="{{ $level }}" {{ $exercise->difficulty_level === $level ? 'selected' : '' }}>{{ ucfirst($level) }}</option>
                  @endforeach
                </select>
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
    @empty
    <p>No tienes ejercicios guardados todavía.</p>
    @endforelse
  </div>
</div>
@endsection