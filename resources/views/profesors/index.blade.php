@extends('layouts.app')

@section('title', 'Lista de Aulas')

@section('content')

<div class="container-fluid my-5 px-1 px-md-2 px-lg-3 px-xl-4">
    <div class="d-flex justify-content-between align-items-center">
        {{-- Saludo con el nombre del usuario autenticado --}}
        <div class="d-flex flex-column">
            <span class="navbar-text fw-bold">
                Bienvenido, {{ Auth::user()->name }}
            </span>

            {{-- Título principal --}}
            <h1>Profesores</h1>
        </div>

        {{-- Botón para crear nuevo profesor, visible solo para roles admin o editor --}}
        <div>
            @role('admin|editor')
            <a href="{{ route('profesors.create') }}" class="btn btn-success mb-3">Nuevo Profesor</a>
            @endrole
        </div>
    </div>
</div>

{{-- Línea horizontal separadora (correcto uso, hr no se cierra con </hr>) --}}
<hr>

{{-- Tabla responsive con lista de profesores --}}
<div class="table-responsive my-5" style="max-height: 600px; overflow-y: auto;">
    {{-- Si no hay profesores, mostrar alerta --}}
    @if ($profesores->isEmpty())
    <p class="container alert alert-warning text-center my-5">Aún no hay profesores registrados.</p>
    @else
    <table class="table table-bordered table-striped align-middle mb-5">
        <thead>
            <tr>
                <th class="sticky-header">Nombre</th>
                <th class="sticky-header">Apellido 1</th>
                <th class="sticky-header">Apellido 2</th>
                <th class="sticky-header">Estado</th>
                {{-- Columna de acciones solo para admin o editor --}}
                @role('admin|editor')
                <th class="sticky-header">Acciones</th>
                @endrole
            </tr>
        </thead>
        <tbody>
            {{-- Recorrer cada profesor --}}
            @foreach ($profesores as $profesor)
            <tr class="{{ $profesor->activo }}">
                <td>{{ $profesor->nombre }}</td>
                <td>{{ $profesor->apellido_1 }}</td>
                <td>{{ $profesor->apellido_2 }}</td>
                <td>
                    {{-- Mostrar estado con badge según el atributo activo --}}
                    @if($profesor->activo)
                    <span class="badge bg-success">Activo</span>
                    @else
                    <span class="badge bg-secondary">Inactivo</span>
                    @endif
                </td>

                @role('admin|editor')
                <td>
                    {{-- Acciones de editar o activar/desactivar --}}
                    <div class="d-flex justify-content-center gap-2">
                        @if($profesor->activo)
                        {{-- Editar profesor activo --}}
                        <a href="{{ route('profesors.edit', $profesor->id) }}" class="btn btn-warning">Editar</a>

                        {{-- Formulario para desactivar profesor --}}
                        <form action="{{ route('profesors.destroy', $profesor->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('¿Desactivar profesor?')">Baja</button>
                        </form>
                    </div>

                    <div class="d-flex justify-content-center gap-2">
                        @else
                        {{-- Formulario para activar profesor inactivo --}}
                        <form action="{{ route('profesors.activar', $profesor->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')

                            <button type="submit" class="btn btn-success"
                                onclick="return confirm('¿Activar profesor?')">Alta</button>
                        </form>
                        @endif
                    </div>
                </td>
                @endrole
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

{{-- Botón para regresar a la lista de usufructos --}}
<div class="text-center mb-5">
    <a href="{{ route('usufructos.index') }}" class="btn btn-primary">Volver a la lista de Usufructos</a>
</div>

@endsection