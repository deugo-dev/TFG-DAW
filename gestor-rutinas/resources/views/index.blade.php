@extends('layouts.app')

@section('title', 'Inicio ')

@section('content')
    <section class="hero" style="min-height: 70vh; display:flex; align-items:center; justify-content:center; background: linear-gradient(to bottom right, #007bff, #6c63ff); color: white; text-align:center; padding:2rem;">
        <div>
            <h1>Rhiannon</h1>
            <p>Tu plataforma personalizada para crear y gestionar rutinas de entrenamiento</p>
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-light mt-4">Ir a mi panel</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-light mt-4">Iniciar sesión</a>
            @endauth
        </div>
    </section>
@endsection
