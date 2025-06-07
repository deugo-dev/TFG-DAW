@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Rutina: {{ $routine->name ?? 'Sin nombre' }}</h1>

  @if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addExerciseModal">
    Añadir ejercicio nuevo
  </button>

  <div class="modal fade" id="addExerciseModal" tabindex="-1" aria-labelledby="addExerciseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="{{ route('routine_exercises.store', $routine->id) }}" method="POST">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="addExerciseModalLabel">Añadir ejercicio</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">

            <div class="mb-3">
              <label for="title" class="form-label">Título *</label>
              <input type="text" class="form-control" id="title" name="title" required maxlength="255" value="{{ old('title') }}">
              @error('title')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <div class="mb-3">
              <label for="description" class="form-label">Descripción</label>
              <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
              <label for="video_url" class="form-label">URL Video</label>
              <input type="url" class="form-control" id="video_url" name="video_url" value="{{ old('video_url') }}">
              @error('video_url')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <div class="mb-3">
              <label for="category" class="form-label">Categoría</label>
              <select class="form-select" id="category" name="category" required>
                <option value="" disabled {{ old('category') ? '' : 'selected' }}>Selecciona categoría</option>
                <option value="cardio" {{ old('category') == 'cardio' ? 'selected' : '' }}>Cardio</option>
                <option value="fuerza" {{ old('category') == 'fuerza' ? 'selected' : '' }}>Fuerza</option>
                <option value="estiramiento" {{ old('category') == 'estiramientos' ? 'selected' : '' }}>Estiramientos</option>
                <option value="flexibilidad" {{ old('category') == 'flexibilidad' ? 'selected' : '' }}>Flexibilidad</option>
                <option value="movilidad" {{ old('category') == 'movilidad' ? 'selected' : '' }}>Movilidad</option>
                <option value="core" {{ old('category') == 'core' ? 'selected' : '' }}>Core</option>
                <option value="calistenia" {{ old('category') == 'calistenia' ? 'selected' : '' }}>Calistenia</option>
              </select>

            </div>

            <div class="mb-3">
              <label for="difficulty_level" class="form-label">Nivel de dificultad *</label>
              <select class="form-select" id="difficulty_level" name="difficulty_level" required>
                <option value="fácil" {{ old('difficulty_level') == 'fácil' ? 'selected' : '' }}>Fácil</option>
                <option value="medio" {{ old('difficulty_level') == 'medio' ? 'selected' : '' }}>Medio</option>
                <option value="difícil" {{ old('difficulty_level') == 'difícil' ? 'selected' : '' }}>Difícil</option>
              </select>
              @error('difficulty_level')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <div class="row">
              <div class="col-md-3 mb-3">
                <label for="exercise_order" class="form-label">Orden</label>
                <input type="number" class="form-control" id="exercise_order" name="exercise_order" min="1" value="{{ old('exercise_order', $routine->exercises->count() + 1) }}">
              </div>
              <div class="col-md-3 mb-3">
                <label for="reps" class="form-label">Repeticiones</label>
                <input type="number" class="form-control" id="reps" name="reps" min="0" value="{{ old('reps') }}">
              </div>
              <div class="col-md-3 mb-3">
                <label for="duration" class="form-label">Duración (seg)</label>
                <input type="number" class="form-control" id="duration" name="duration" min="0" value="{{ old('duration') }}">
              </div>
              <div class="col-md-3 mb-3">
                <label for="rest_time" class="form-label">Descanso (seg)</label>
                <input type="number" class="form-control" id="rest_time" name="rest_time" min="0" value="{{ old('rest_time') }}">
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar ejercicio</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <h2>Ejercicios de esta rutina</h2>
  <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    @foreach($routine->exercises as $exercise)
    <div class="col">
      <div class="card h-100 shadow-sm">
        @if($exercise->video_url)
        <iframe class="card-img-top" src="{{ $exercise->video_url }}" style="aspect-ratio:16/9;" allowfullscreen></iframe>
        @endif
        <div class="card-body">
          <h5 class="card-title">{{ $exercise->title }}</h5>
          <p class="card-text">{{ $exercise->description ?? 'Sin descripción' }}</p>
          <ul class="list-group list-group-flush mb-3">
            <li class="list-group-item"><strong>Orden:</strong> {{ $exercise->pivot->exercise_order }}</li>
            <li class="list-group-item"><strong>Repeticiones:</strong> {{ $exercise->pivot->reps ?? '-' }}</li>
            <li class="list-group-item"><strong>Duración (seg):</strong> {{ $exercise->pivot->duration ?? '-' }}</li>
            <li class="list-group-item"><strong>Descanso (seg):</strong> {{ $exercise->pivot->rest_time ?? '-' }}</li>
            <li class="list-group-item"><strong>Dificultad:</strong> {{ $exercise->difficulty_level ? ucfirst(strtolower($exercise->difficulty_level)) : '-' }}</li>
            <li class="list-group-item"><strong>Categoría:</strong> {{ $exercise->category ? ucfirst(strtolower($exercise->category)) : '-' }}</li>
          </ul>

          <div class="d-flex justify-content-end gap-2">
            <a href="#" class="btn btn-sm btn-primary">Editar</a>
            <form action="{{ route('routine_exercises.delete', ['routine' => $routine->id, 'exercise' => $exercise->id]) }}" method="POST" style="display:inline;">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('¿Seguro que quieres eliminar este ejercicio?')">Eliminar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection