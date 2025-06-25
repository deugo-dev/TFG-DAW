@extends('layouts.app', ['noFooter' => true])

@section('content')
@if(Auth::user()->is_admin)
<div class="container py-5" style="max-width: 600px;">
    <h1 class="mb-4 fw-bold text-success">Editar Usuario</h1>

    @if ($errors->any())
    <div class="alert alert-danger rounded-3 shadow-sm">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('users.update', $user) }}" method="POST" novalidate class="border rounded p-4 shadow-sm bg-light">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Nombre:</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $user->name) }}"
                class="form-control"
                required
                maxlength="255">
        </div>

        <div class="mb-4">
            <label for="email" class="form-label fw-semibold">Email:</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email', $user->email) }}"
                class="form-control"
                required
                maxlength="255">
        </div>

        <button type="submit" class="btn btn-success px-4 w-100 mb-2">Guardar Cambios</button>

        <a href="{{ route('users.index') }}" class="btn btn-link w-100 text-center">Volver a la lista</a>
    </form>
</div>
@else
<div class="container mt-4">
    <div class="alert alert-danger rounded-3 shadow-sm">
        No tienes permiso para acceder a esta página.
    </div>
</div>
@endif
@endsection