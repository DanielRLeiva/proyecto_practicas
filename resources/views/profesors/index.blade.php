@extends('layouts.app')

@section('title', 'Lista de Aulas')

@section('content')

<div class="container mt-5 mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex flex-column">
            <span class="navbar-text">
                Bienvenido, {{ Auth::user()->name }}
            </span>

            <h1>Profesores</h1>
        </div>

        <div>
            @role('admin|editor')
            <a href="{{ route('profesors.create') }}" class="btn btn-success mb-3">Nuevo Profesor</a>
            @endrole
        </div>
    </div>

    <hr>
    </hr>

    <!-- Tabla de Profesores -->
    <div class="table-responsive mt-5 mb-5" style="max-height: 600px; overflow-y: auto;">
        <table class="table table-bordered table-striped align-middle mb-5">
            <thead>
                <tr>
                    <th class="sticky-header">Nombre</th>
                    <th class="sticky-header">Apellido 1</th>
                    <th class="sticky-header">Apellido 2</th>
                    <th class="sticky-header">Estado</th>
                    @role('admin|editor')
                    <th class="sticky-header">Acciones</th>
                    @endrole
                </tr>
            </thead>
            <tbody>
                @foreach ($profesores as $profesor)
                <tr class="{{ $profesor->activo }}">
                    <td>{{ $profesor->nombre }}</td>
                    <td>{{ $profesor->apellido_1 }}</td>
                    <td>{{ $profesor->apellido_2 }}</td>
                    <td>
                        @if($profesor->activo)
                        <span class="badge bg-success">Activo</span>
                        @else
                        <span class="badge bg-secondary">Inactivo</span>
                        @endif
                    </td>

                    @role('admin|editor')
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            @if($profesor->activo)
                            <a href="{{ route('profesors.edit', $profesor->id) }}" class="btn btn-warning">Editar</a>

                            <form action="{{ route('profesors.destroy', $profesor->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('¿Desactivar profesor?')">Baja</button>
                            </form>
                        </div>

                        <div class="d-flex justify-content-center gap-2">
                            @else
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
    </div>

    <div class="text-center">
        <a href="{{ route('usufructos.index') }}" class="btn btn-primary mb-4">Volver a la lista de Usufructos</a>
    </div>
</div>

@endsection