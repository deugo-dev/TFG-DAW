@extends('layouts.app')

@section('title', '¿Olvidaste tu contraseña?')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">

            <div class="card">
                <div class="card-header text-center">
                    <h4>¿Olvidaste tu contraseña?</h4>
                </div>

                <div class="card-body">
                    <p class="text-muted mb-4">
                        ¿Olvidaste tu contraseña? No hay problema. Solo dinos tu correo electrónico y te enviaremos un enlace para que puedas elegir una nueva.
                    </p>

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                Enviar enlace de restablecimiento
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
