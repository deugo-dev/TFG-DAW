@extends('layouts.app')

@section('content')
<div class="container py-4">
  <!-- Header Section -->
  <div class="row mb-4">
    <div class="col">
      <div class="d-flex align-items-center mb-3">
        <div class="bg-primary rounded-circle p-3 me-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
          <i class="fas fa-dumbbell text-white fs-4"></i>
        </div>
        <div>
          <h1 class="mb-1 text-dark fw-bold">{{ $routine->name }}</h1>
          <p class="text-muted mb-0">{{ $routine->exercises->count() }} ejercicios en la rutina</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Exercise Grid -->
  <div id="exercise-list" class="row g-4">
    @foreach($routine->exercises->sortBy('pivot.exercise_order') as $exercise)
    <div class="col-lg-6 col-xl-4" data-id="{{ $exercise->id }}">
      <div class="card h-100 shadow-sm border-0" style="transition: transform 0.2s; border-radius: 12px;">
        <!-- Video Section -->
        <div class="position-relative" style="border-radius: 12px 12px 0 0; overflow: hidden;">
          <div class="ratio ratio-16x9">
            @php
            $embedUrl = $exercise->getEmbedUrl();
            @endphp
            @if($embedUrl)
            <iframe class="card-img-top" src="{{ $embedUrl }}" frameborder="0" allowfullscreen style="border-radius: 12px 12px 0 0;"></iframe>
            @else
            <div class="d-flex justify-content-center align-items-center bg-dark text-white">
              <div class="text-center">
                <i class="fas fa-play-circle fs-1 mb-2 opacity-50"></i>
                <p class="mb-0 small">Video no disponible</p>
              </div>
            </div>
            @endif
          </div>
          <!-- Exercise Order Badge -->
          <div class="position-absolute top-0 start-0 m-2">
            <span class="badge bg-primary fs-6">#{{ $loop->iteration }}</span>
          </div>
        </div>

        <!-- Card Body -->
        <div class="card-body p-4">
          <h5 class="card-title fw-bold mb-3 text-dark">{{ $exercise->title }}</h5>

          <!-- Update Form -->
          <form action="{{ route('routine_exercises.update', [$routine, $exercise]) }}" method="POST" class="mb-3">
            @csrf
            @method('PUT')
            <div class="row g-2 mb-3">
              <div class="col-4">
                <label class="form-label small fw-medium text-muted">REPS</label>
                <input type="number" name="reps" value="{{ $exercise->pivot->reps }}"
                  class="form-control form-control-sm border-0 bg-light"
                  style="border-radius: 8px;">
              </div>
              <div class="col-4">
                <label class="form-label small fw-medium text-muted">DURACIÓN</label>
                <input type="number" name="duration" value="{{ $exercise->pivot->duration }}"
                  class="form-control form-control-sm border-0 bg-light"
                  style="border-radius: 8px;">
              </div>
              <div class="col-4">
                <label class="form-label small fw-medium text-muted">DESCANSO</label>
                <input type="number" name="rest_time" value="{{ $exercise->pivot->rest_time }}"
                  class="form-control form-control-sm border-0 bg-light"
                  style="border-radius: 8px;">
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary btn-sm flex-fill" style="border-radius: 8px;">
                <i class="fas fa-save me-1"></i> Actualizar
              </button>
            </div>
          </form>

          <!-- Delete Form -->
          <form action="{{ route('routine_exercises.delete', [$routine, $exercise]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger btn-sm w-100"
              style="border-radius: 8px;"
              onclick="return confirm('¿Estás seguro de eliminar este ejercicio?')">
              <i class="fas fa-trash me-1"></i> Eliminar de la rutina
            </button>
          </form>
        </div>
      </div>
    </div>
    @endforeach

    <!-- Add New Exercise Card -->
    <div class="col-lg-6 col-xl-4">
      <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="card-body d-flex flex-column justify-content-center p-4">
          <div class="text-center mb-4">
            <div class="bg-success rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
              style="width: 80px; height: 80px;">
              <i class="fas fa-plus text-white fs-2"></i>
            </div>
            <h5 class="fw-bold text-dark mb-2">Añadir Ejercicio</h5>
            <p class="text-muted small mb-0">Agrega un nuevo ejercicio a tu rutina</p>
          </div>

          <form action="{{ route('routine_exercises.attach', $routine) }}" method="POST">
            @csrf
            <div class="mb-3">
              <label class="form-label small fw-medium text-muted">EJERCICIO</label>
              <select name="exercise_id" class="form-select border-0 bg-white"
                style="border-radius: 8px;" required>
                <option value="" disabled selected>Selecciona un ejercicio</option>
                @foreach($availableExercises as $exercise)
                <option value="{{ $exercise->id }}">{{ $exercise->title }}</option>
                @endforeach
              </select>
            </div>

            <div class="row g-2 mb-3">
              <div class="col-4">
                <label class="form-label small fw-medium text-muted">REPS</label>
                <input type="number" name="reps" class="form-control form-control-sm border-0 bg-white"
                  style="border-radius: 8px;" placeholder="0">
              </div>
              <div class="col-4">
                <label class="form-label small fw-medium text-muted">DURACIÓN</label>
                <input type="number" name="duration" class="form-control form-control-sm border-0 bg-white"
                  style="border-radius: 8px;" placeholder="0">
              </div>
              <div class="col-4">
                <label class="form-label small fw-medium text-muted">DESCANSO</label>
                <input type="number" name="rest_time" class="form-control form-control-sm border-0 bg-white"
                  style="border-radius: 8px;" placeholder="0">
              </div>
            </div>

            <button type="submit" class="btn btn-success w-100" style="border-radius: 8px;">
              <i class="fas fa-plus me-2"></i>Añadir a la rutina
            </button>
          </form>

          <div class="text-center mt-3">
            <button class="btn btn-link text-muted small p-0" disabled>
              <i class="fas fa-magic me-1"></i>o crear uno nuevo
            </button>
          </div>
        </div>
      </div>
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
    border-color: var(--bs-primary);
  }

  .btn {
    transition: all 0.2s ease;
  }

  .btn:hover {
    transform: translateY(-1px);
  }
</style>
@endsection