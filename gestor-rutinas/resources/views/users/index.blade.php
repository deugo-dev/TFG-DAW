@extends('layouts.app', ['noFooter' => true])

@section('content')
@if(Auth::user()->is_admin)
<div class="container py-5" style="max-width: 900px;">
    <h1 class="mb-4 fw-bold text-success">Lista de Usuarios</h1>

    @if(session('success'))
    <div class="alert alert-success rounded-3 shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="table-responsive rounded shadow-sm border">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th style="width: 180px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-success me-2 mb-1">
                            Editar
                        </a>

                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline-block mb-1" onsubmit="return confirm('¿Seguro que quieres eliminar este usuario?');">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="btn btn-sm {{ ($user->is_admin || $user->id === Auth::id()) ? 'btn-secondary' : 'btn-danger' }}"
                                @if($user->is_admin || $user->id === Auth::id()) disabled @endif
                                title="{{ ($user->is_admin || $user->id === Auth::id()) ? 'No puedes eliminar a este usuario' : '' }}"
                                >
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
<div class="container mt-4">
    <div class="alert alert-danger rounded-3 shadow-sm">
        No tienes permiso para acceder a esta página.
    </div>
</div>
@endif
@endsection