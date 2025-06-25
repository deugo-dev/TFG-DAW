@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Estadísticas</h1>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Usuarios</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $usersCount }}</h5>
                    <p class="card-text">Número total de usuarios registrados.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Rutinas</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $routinesCount }}</h5>
                    <p class="card-text">Número total de rutinas creadas.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Ejercicios</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $exercisesCount }}</h5>
                    <p class="card-text">Número total de ejercicios creados.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection