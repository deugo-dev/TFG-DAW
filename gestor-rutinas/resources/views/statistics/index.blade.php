@extends('layouts.app', ['noFooter' => true])

@section('content')
<div class="container py-5" style="max-width: 900px;">
    <h1 class="mb-4 fw-bold text-success">Estadísticas</h1>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary shadow-sm rounded-3">
                <div class="card-header fs-5 fw-semibold">Usuarios</div>
                <div class="card-body">
                    <h5 class="card-title display-6">{{ $usersCount }}</h5>
                    <p class="card-text opacity-75">Número total de usuarios registrados.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-success shadow-sm rounded-3">
                <div class="card-header fs-5 fw-semibold">Rutinas</div>
                <div class="card-body">
                    <h5 class="card-title display-6">{{ $routinesCount }}</h5>
                    <p class="card-text opacity-75">Número total de rutinas creadas.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-info shadow-sm rounded-3">
                <div class="card-header fs-5 fw-semibold">Ejercicios</div>
                <div class="card-body">
                    <h5 class="card-title display-6">{{ $exercisesCount }}</h5>
                    <p class="card-text opacity-75">Número total de ejercicios creados.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection