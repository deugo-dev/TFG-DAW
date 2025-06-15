@extends('layouts.app')

@section('content')
<div class="container py-4">
  <!-- Header Section -->
  <div class="row mb-4">
    <div class="col">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="d-flex align-items-center">
          <div class="bg-success rounded-circle p-3 me-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-dumbbell text-white fs-4"></i>
          </div>
          <div>
            <h1 class="mb-1 text-dark fw-bold">Mis Ejercicios</h1>
            <p class="text-muted mb-0">{{ $exercises->count() }} ejercicios en tu biblioteca</p>
          </div>
        </div>
        <button type="button" class="btn btn-success px-4 py-2" data-bs-toggle="modal" data-bs-target="#addExerciseModal" style="border-radius: 12px;">
          <i class="fas fa-plus me-2"></i>Añadir ejercicio
        </button>
      </div>
    </div>
  </div>

  @if(session('success'))
  <div class="alert alert-success border-0 shadow" style="border-radius: 12px;">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
  </div>
  @endif

  <form method="GET" action="{{ route('exercises.filter') }}" class="row g-3 mb-4">
    <div class="col-md-5">
      <select name="category" class="form-select">
        <option value="">Todas las categorías</option>
        @foreach(['cardio', 'fuerza', 'estiramiento', 'flexibilidad', 'movilidad', 'core', 'calistenia'] as $cat)
        <option value="{{ $cat }}" {{ session('filter_category') == $cat ? 'selected' : '' }}>
          {{ ucfirst($cat) }}
        </option>
        @endforeach
      </select>
    </div>

    <div class="col-md-5">
      <select name="difficulty_level" class="form-select">
        <option value="">Todas las dificultades</option>
        @foreach(['fácil', 'medio', 'difícil'] as $level)
        <option value="{{ $level }}" {{ session('filter_difficulty') == $level ? 'selected' : '' }}>
          {{ ucfirst($level) }}
        </option>
        @endforeach
      </select>
    </div>

    <div class="col-md-2 d-flex gap-2">
      <button type="submit" class="btn btn-success w-100">
        <i class="fas fa-filter me-1"></i> Filtrar
      </button>
      <a href="{{ route('exercises.clearFilters') }}" class="btn btn-outline-secondary w-100">
        <i class="fas fa-times-circle me-1"></i> Limpiar
      </a>
    </div>
  </form>

  @if (session('filter_category') || session('filter_difficulty'))
  <div class="alert alert-info">
    Mostrando ejercicios filtrados por:
    @if (session('filter_category')) <strong>Categoría:</strong> {{ session('filter_category') }} @endif
    @if (session('filter_difficulty')) <strong>Dificultad:</strong> {{ session('filter_difficulty') }} @endif
  </div>
  @endif


  <!-- Exercises Grid -->
  <div class="row g-4">
    @forelse ($exercises as $exercise)
    <div class="col-lg-6 col-xl-4">
      <div class="card h-100 shadow border-0" style="transition: transform 0.2s; border-radius: 12px;">
        <!-- Video Section -->
        <div class="position-relative" style="border-radius: 12px 12px 0 0; overflow: hidden;">
          <div class="ratio ratio-16x9">
            @if($exercise->getEmbedUrl())
            <iframe class="card-img-top" src="{{ $exercise->getEmbedUrl() }}" frameborder="0" allowfullscreen style="border-radius: 12px 12px 0 0;"></iframe>
            @else
            <div class="d-flex justify-content-center align-items-center bg-dark text-white">
              <div class="text-center">
                <i class="fas fa-play-circle fs-1 mb-2 opacity-50"></i>
                <p class="mb-0 small">Video no disponible</p>
              </div>
            </div>
            @endif
          </div>
          <!-- Category Badge -->
          <div class="position-absolute top-0 start-0 m-2">
            <span class="badge bg-primary fs-6">{{ ucfirst($exercise->category) }}</span>
          </div>
          <!-- Difficulty Badge -->
          <div class="position-absolute top-0 end-0 m-2">
            @php
            $difficultyColors = [
            'fácil' => 'success',
            'medio' => 'warning',
            'difícil' => 'danger'
            ];
            $color = $difficultyColors[$exercise->difficulty_level] ?? 'secondary';
            @endphp
            <span class="badge bg-{{ $color }} fs-6">{{ ucfirst($exercise->difficulty_level) }}</span>
          </div>
        </div>

        <!-- Card Body -->
        <div class="card-body p-4">
          <h5 class="card-title fw-bold mb-2 text-dark">{{ $exercise->title }}</h5>
          <p class="card-text text-muted mb-3" style="font-size: 0.9rem;">{{ Str::limit($exercise->description, 100) }}</p>

          <!-- Action Buttons -->
          <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-primary btn-sm flex-fill"
              data-bs-toggle="modal" data-bs-target="#editExerciseModal{{ $exercise->id }}"
              style="border-radius: 8px;">
              <i class="fas fa-edit me-1"></i> Editar
            </button>
            <form action="{{ route('exercises.delete', $exercise) }}" method="POST" class="flex-fill">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-outline-danger btn-sm w-100"
                style="border-radius: 8px;"
                onclick="return confirm('¿Eliminar ejercicio?')">
                <i class="fas fa-trash me-1"></i> Eliminar
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal: Editar ejercicio -->
    <div class="modal fade" id="editExerciseModal{{ $exercise->id }}" tabindex="-1" aria-labelledby="editExerciseModalLabel{{ $exercise->id }}" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
          <form action="{{ route('exercises.update', $exercise) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-header border-0 pb-0">
              <h5 class="modal-title fw-bold" id="editExerciseModalLabel{{ $exercise->id }}">
                <i class="fas fa-edit text-primary me-2"></i>Editar ejercicio
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body px-4">
              <div class="mb-3">
                <label for="title{{ $exercise->id }}" class="form-label small fw-medium text-muted">TÍTULO *</label>
                <input type="text" class="form-control border-0 bg-light" id="title{{ $exercise->id }}" name="title"
                  value="{{ $exercise->title }}" required maxlength="255" style="border-radius: 8px;">
              </div>

              <div class="mb-3">
                <label for="description{{ $exercise->id }}" class="form-label small fw-medium text-muted">DESCRIPCIÓN</label>
                <textarea class="form-control border-0 bg-light" id="description{{ $exercise->id }}" name="description" rows="3" style="border-radius: 8px;">{{ $exercise->description }}</textarea>
              </div>

              <div class="mb-3">
                <label for="video_url{{ $exercise->id }}" class="form-label small fw-medium text-muted">URL DEL VIDEO</label>
                <input type="url" class="form-control border-0 bg-light" id="video_url{{ $exercise->id }}" name="video_url"
                  value="{{ $exercise->video_url }}" style="border-radius: 8px;">
              </div>

              <div class="row g-3">
                <div class="col-6">
                  <label for="category{{ $exercise->id }}" class="form-label small fw-medium text-muted">CATEGORÍA *</label>
                  <select class="form-select border-0 bg-light" id="category{{ $exercise->id }}" name="category" required style="border-radius: 8px;">
                    @foreach(['cardio', 'fuerza', 'estiramiento', 'flexibilidad', 'movilidad', 'core', 'calistenia'] as $cat)
                    <option value="{{ $cat }}" {{ $exercise->category === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-6">
                  <label for="difficulty_level{{ $exercise->id }}" class="form-label small fw-medium text-muted">DIFICULTAD *</label>
                  <select class="form-select border-0 bg-light" id="difficulty_level{{ $exercise->id }}" name="difficulty_level" required style="border-radius: 8px;">
                    @foreach(['fácil', 'medio', 'difícil'] as $level)
                    <option value="{{ $level }}" {{ $exercise->difficulty_level === $level ? 'selected' : '' }}>{{ ucfirst($level) }}</option>
                    @endforeach
                  </select>
                </div>
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
    @empty
    <!-- Empty State -->
    <div class="col-12">
      <div class="text-center py-5">
        <div class="bg-light rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center"
          style="width: 120px; height: 120px;">
          <i class="fas fa-dumbbell text-muted fs-1"></i>
        </div>
        <h4 class="text-muted mb-2">No tienes ejercicios aún o no se han encontrado</h4>
        <p class="text-muted mb-4">Continua añadiendo un ejercicio</p>
        <button type="button" class="btn btn-success px-4 py-2" data-bs-toggle="modal" data-bs-target="#addExerciseModal" style="border-radius: 12px;">
          <i class="fas fa-plus me-2"></i>Añadir ejercicio
        </button>
      </div>
    </div>
    @endforelse
  </div>
</div>

<!-- Modal: Crear ejercicio -->
<div class="modal fade" id="addExerciseModal" tabindex="-1" aria-labelledby="addExerciseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
      <form action="{{ route('exercises.store') }}" method="POST">
        @csrf
        <div class="modal-header border-0 pb-0">
          <h5 class="modal-title fw-bold" id="addExerciseModalLabel">
            <i class="fas fa-plus text-success me-2"></i>Añadir ejercicio
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body px-4">
          <div class="mb-3">
            <label for="title" class="form-label small fw-medium text-muted">TÍTULO *</label>
            <input type="text" class="form-control border-0 bg-light" id="title" name="title" required maxlength="255" style="border-radius: 8px;">
          </div>

          <div class="mb-3">
            <label for="description" class="form-label small fw-medium text-muted">DESCRIPCIÓN</label>
            <textarea class="form-control border-0 bg-light" id="description" name="description" rows="3" style="border-radius: 8px;"></textarea>
          </div>

          <div class="mb-3">
            <label for="video_url" class="form-label small fw-medium text-muted">URL DEL VIDEO</label>
            <input type="url" class="form-control border-0 bg-light" id="video_url" name="video_url" style="border-radius: 8px;">
          </div>

          <div class="row g-3">
            <div class="col-6">
              <label for="category" class="form-label small fw-medium text-muted">CATEGORÍA *</label>
              <select class="form-select border-0 bg-light" id="category" name="category" required style="border-radius: 8px;">
                <option disabled selected>Selecciona categoría</option>
                @foreach(['cardio', 'fuerza', 'estiramiento', 'flexibilidad', 'movilidad', 'core', 'calistenia'] as $cat)
                <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-6">
              <label for="difficulty_level" class="form-label small fw-medium text-muted">DIFICULTAD *</label>
              <select class="form-select border-0 bg-light" id="difficulty_level" name="difficulty_level" required style="border-radius: 8px;">
                <option disabled selected>Selecciona dificultad</option>
                @foreach(['fácil', 'medio', 'difícil'] as $level)
                <option value="{{ $level }}">{{ ucfirst($level) }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer border-0 pt-0">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 8px;">Cancelar</button>
          <button type="submit" class="btn btn-success" style="border-radius: 8px;">
            <i class="fas fa-save me-1"></i>Guardar ejercicio
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

  .badge {
    font-weight: 500;
  }
</style>
@endsection