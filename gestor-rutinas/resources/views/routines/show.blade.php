@extends('layouts.app')

@section('content')
<div class="container py-4">
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

  <div id="exercise-list" class="row g-4">
    @foreach($routine->exercises->sortBy('pivot.exercise_order') as $exercise)
    <div class="col-lg-6 col-xl-4" data-id="{{ $exercise->id }}">
      <div class="card h-100 shadow border-0" style="transition: transform 0.2s; border-radius: 12px;">
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
                <label class="form-label small fw-medium text-muted">SETS</label>
                <input type="number" name="sets" value="{{ $exercise->pivot->sets }}"
                  class="form-control form-control-sm border-0 bg-light"
                  style="border-radius: 8px;">
              </div>
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


            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary btn-sm flex-fill" style="border-radius: 8px;">
                <i class="fas fa-save me-1"></i> Actualizar
              </button>
            </div>
          </form>

          <!-- Delete -->
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

    <!-- Añadir ejercicio existente o crear uno nuevo -->
    <div class="col-lg-6 col-xl-4">
      <div class="card h-100 border-0 shadow" style="border-radius: 12px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">

        <!-- Pestañas de navegación -->
        <ul class="nav nav-tabs" id="exerciseTab" role="tablist" style="border: none; margin: 0;">
          <li class="nav-item" role="presentation" style="flex: 1;">
            <button class="nav-link active w-100" id="add-existing-tab" data-bs-toggle="tab"
              data-bs-target="#add-existing" type="button" role="tab"
              style="border: none; border-radius: 12px 0 0 0; background: transparent; color: #6c757d; font-weight: 500; font-size: 0.9rem; padding: 12px;">
              <i class="fas fa-list me-1"></i>Añadir Existente
            </button>
          </li>
          <li class="nav-item" role="presentation" style="flex: 1;">
            <button class="nav-link w-100" id="create-new-tab" data-bs-toggle="tab"
              data-bs-target="#create-new" type="button" role="tab"
              style="border: none; border-radius: 0 12px 0 0; background: transparent; color: #6c757d; font-weight: 500; font-size: 0.9rem; padding: 12px;">
              <i class="fas fa-plus me-1"></i>Crear Nuevo
            </button>
          </li>
        </ul>

        <!-- Contenido de las pestañas -->
        <div class="tab-content" style="background: white; border-radius: 0 0 12px 12px;">

          <!-- Pestaña: Añadir Ejercicio Existente -->
          <div class="tab-pane fade show active" id="add-existing" role="tabpanel">
            <div class="card-body d-flex flex-column justify-content-center p-4" style="border: none; background: transparent;">
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
                    <label class="form-label small fw-medium text-muted">SETS</label>
                    <input type="number" name="sets" class="form-control form-control-sm border-0 bg-white"
                      style="border-radius: 8px;" placeholder="0">
                  </div>
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
            </div>
          </div>

          <!-- Pestaña: Crear Nuevo Ejercicio -->
          <div class="tab-pane fade" id="create-new" role="tabpanel">
            <div class="card-body d-flex flex-column justify-content-center p-4 text-center" style="border: none; background: transparent;">
              <div class="bg-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                style="width: 80px; height: 80px;">
                <i class="fas fa-magic text-white fs-2"></i>
              </div>
              <h5 class="fw-bold text-dark mb-2">Crear Ejercicio</h5>
              <p class="text-muted small mb-4">Crea un nuevo ejercicio personalizado</p>

              <button type="button" class="btn btn-primary w-100" style="border-radius: 8px;" onclick="openExerciseModal()">
                <i class="fas fa-magic me-2"></i>Crear nuevo ejercicio
              </button>
            </div>
          </div>

        </div>
      </div>
    </div>


    <!-- Primer modal: Crear ejercicio -->
    <div class="modal fade" id="createExerciseModal" tabindex="-1" aria-labelledby="createExerciseModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
          <div class="modal-header border-0 pb-0">
            <h5 class="modal-title fw-bold" id="createExerciseModalLabel">
              <i class="fas fa-plus text-success me-2"></i>Crear ejercicio
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body px-4">
            <form id="createExerciseForm">
              @csrf
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
                    @foreach(['cardio','fuerza','estiramiento','flexibilidad','movilidad','core','calistenia'] as $cat)
                    <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-6">
                  <label for="difficulty_level" class="form-label small fw-medium text-muted">DIFICULTAD *</label>
                  <select class="form-select border-0 bg-light" id="difficulty_level" name="difficulty_level" required style="border-radius: 8px;">
                    <option disabled selected>Selecciona dificultad</option>
                    @foreach(['fácil','medio','difícil'] as $level)
                    <option value="{{ $level }}">{{ ucfirst($level) }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer border-0">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 8px;">Cancelar</button>
            <button type="button" class="btn btn-success" style="border-radius: 8px;" onclick="submitExerciseForm()">
              <i class="fas fa-check me-1"></i>Siguiente
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Segundo modal: Asociar a rutina -->
    <div class="modal fade" id="addToRoutineModal" tabindex="-1" aria-labelledby="addToRoutineModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
          <form id="addToRoutineForm" method="POST" action="{{ route('routine_exercises.attach', $routine) }}">
            @csrf
            <input type="hidden" name="exercise_id" id="newExerciseId">
            <div class="modal-header border-0 pb-0">
              <h5 class="modal-title fw-bold" id="addToRoutineModalLabel">
                <i class="fas fa-link text-primary me-2"></i>Asociar a rutina
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body px-4">
              <div class="row g-2">
                <div class="col-6">
                  <label class="form-label small fw-medium text-muted">SETS</label>
                  <input type="number" name="sets" class="form-control border-0 bg-light" style="border-radius: 8px;">
                </div>
                <div class="col-6">
                  <label class="form-label small fw-medium text-muted">REPS</label>
                  <input type="number" name="reps" class="form-control border-0 bg-light" style="border-radius: 8px;">
                </div>
                <div class="col-6">
                  <label class="form-label small fw-medium text-muted">DURACIÓN</label>
                  <input type="number" name="duration" class="form-control border-0 bg-light" style="border-radius: 8px;">
                </div>
                <div class="col-6">
                  <label class="form-label small fw-medium text-muted">DESCANSO</label>
                  <input type="number" name="rest_time" class="form-control border-0 bg-light" style="border-radius: 8px;">
                </div>
              </div>
            </div>
            <div class="modal-footer border-0">
              <button type="submit" class="btn btn-primary w-100" style="border-radius: 8px;">Añadir a la rutina</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script>
      function openExerciseModal() {
        new bootstrap.Modal(document.getElementById('createExerciseModal')).show();
      }

      function submitExerciseForm() {
        const form = document.getElementById('createExerciseForm');
        const formData = new FormData(form);

        fetch("{{ route('exercises.storeJson') }}", {
            method: "POST",
            headers: {
              'X-CSRF-TOKEN': document.querySelector('input[name=\"_token\"]').value
            },
            body: formData
          })
          .then(res => res.json())
          .then(data => {
            if (data.exercise?.id) {
              document.getElementById('newExerciseId').value = data.exercise.id;
              bootstrap.Modal.getInstance(document.getElementById('createExerciseModal')).hide();
              new bootstrap.Modal(document.getElementById('addToRoutineModal')).show();
            } else {
              alert('Error al crear ejercicio');
            }
          })
          .catch(err => {
            console.error(err);
            alert('Error en la solicitud');
          });
      }
    </script>

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

      .nav-tabs .nav-link {
        transition: all 0.2s ease;
      }

      .nav-tabs .nav-link:hover {
        background: rgba(25, 135, 84, 0.1);
        color: #198754 !important;
      }

      .nav-tabs .nav-link.active {
        background: #198754 !important;
        color: white !important;
      }
    </style>
    @endsection