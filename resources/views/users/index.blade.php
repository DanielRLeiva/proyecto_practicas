@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')

<div class="container-fluid my-5 px-1 px-md-2 px-lg-3 px-xl-4">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex flex-column mb-4">
            {{-- Mostrar nombre del usuario autenticado --}}
            <span class="navbar-text fw-bold">
                Bienvenido, {{ Auth::user()->name }}
            </span>

            {{-- Título principal --}}
            <h1>Usuarios Registrados</h1>
        </div>

        <div>
            {{-- Botón para crear un nuevo usuario --}}
            <a href="{{ route('users.create') }}" class="btn btn-success">Nuevo usuario</a>
        </div>
    </div>
</div>

{{-- Línea horizontal separadora --}}
<hr>

{{-- Subtítulo de la lista --}}
<h3>Lista de Usuarios</h3>

{{-- Mostrar mensaje si no hay usuarios --}}
@if ($users->isEmpty())
<p class="container alert alert-warning text-center my-5">No hay Usuarios registradas aún.</p>

@else
<div class="table-responsive mb-5">
    {{-- Tabla con usuarios --}}
    <table class="table table-bordered table-striped align-middle mt-2 mb-5">
        <thead>
            <tr>
                <th class="sticky-header">Nombre</th>
                <th class="sticky-header">Email</th>
                <th class="sticky-header">Rol</th>
                <th class="sticky-header">Acción</th>
            </tr>
        </thead>
        <tbody>
            {{-- Recorrer usuarios --}}
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                {{-- Mostrar el primer rol o 'Sin rol' --}}
                <td>{{ $user->getRoleNames()->first() ?? 'Sin rol' }}</td>
                <td class="d-flex justify-content-center gap-2">
                    {{-- No permitir editar/eliminar al usuario autenticado --}}
                    @if ($user->id !== Auth::id())
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Editar</a>

                    {{-- Formulario para eliminar usuario --}}
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este usuario?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                    @else
                    {{-- Mensaje cuando el usuario es el mismo autenticado --}}
                    <em>No editable</em>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

{{-- Botón para regresar a la lista de ubicaciones --}}
<div class="text-center mb-5">
    <a href="{{ route('aulas.index') }}" class="btn btn-primary">Volver a la Lista de Ubicaciones</a>
</div>
</div>

@endsection
