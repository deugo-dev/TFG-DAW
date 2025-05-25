@extends('layouts.app')

@section('title', 'Registro')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">

            <div class="card">
                <div class="card-header text-center">
                    <h4>Crear cuenta</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('login') }}" class="text-decoration-none small">¿Ya tienes cuenta?</a>
                            <button type="submit" class="btn btn-primary">Registrarse</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
