@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mi perfil</h1>

    {{-- Formulario para actualizar perfil --}}
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" value="{{ auth()->user()->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" name="email" value="{{ auth()->user()->email }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="profile_picture" class="form-label">Foto de perfil</label>
            <input type="file" name="profile_picture" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Guardar cambios</button>
    </form>

    {{-- Sección separada para mostrar y eliminar la foto de perfil --}}
    <div class="mt-4">
        @if (auth()->user()->profile_picture)
        <p>Esta es tu foto de perfil actual. Puedes cambiarla si lo deseas:</p>
        <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Foto de perfil"
            class="rounded-circle mb-3" width="100" height="100">

        {{-- Formulario separado para eliminar --}}
        <form action="{{ route('profile.removePicture') }}" method="POST"
            onsubmit="return confirm('¿Estás seguro de que quieres eliminar tu foto de perfil?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Eliminar foto de perfil</button>
        </form>
        @else
        <p class="text-muted">Aún no has añadido una foto de perfil. ¡Añádela para personalizar tu cuenta!</p>
        @endif
    </div>
</div>
@endsection