@extends('layouts.app', ['noFooter' => true])

@section('content')
<div class="container py-5" style="max-width: 600px;">
    <h1 class="mb-4 fw-bold text-primary">Mi perfil</h1>

    {{-- Formulario para actualizar perfil --}}
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="border rounded p-4 shadow-sm bg-light">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Nombre</label>
            <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Correo electrónico</label>
            <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" class="form-control" required>
        </div>

        <div class="mb-4">
            <label for="profile_picture" class="form-label fw-semibold">Foto de perfil</label>
            <input type="file" id="profile_picture" name="profile_picture" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary w-100">Guardar cambios</button>
    </form>

    {{-- Sección para mostrar y eliminar la foto --}}
    <div class="mt-5 text-center">
        @if (auth()->user()->profile_picture)
        <p class="mb-3">Esta es tu foto de perfil actual. Puedes cambiarla si lo deseas:</p>
        <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Foto de perfil"
            class="rounded-circle mb-3 border border-3 border-primary" width="120" height="120">

        <form action="{{ route('profile.removePicture') }}" method="POST"
            onsubmit="return confirm('¿Estás seguro de que quieres eliminar tu foto de perfil?');" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">Eliminar foto de perfil</button>
        </form>
        @else
        <p class="text-muted fst-italic">Aún no has añadido una foto de perfil. ¡Añádela para personalizar tu cuenta!</p>
        @endif
    </div>
</div>
@endsection