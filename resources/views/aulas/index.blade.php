@extends('layouts.app')

@section('title', 'Lista de Aulas')

@section('content')

<div class="container-fluid my-5 px-1 px-md-2 px-lg-3 px-xl-4">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex flex-column">
            <span class="navbar-text fw-bold">
                Bienvenido, {{ Auth::user()->name }}
            </span>

            <h1>Lista de Aulas</h1>
        </div>

        <!-- Botón para crear un nuevo aula -->
        <div>
            @role('admin')
            <a href="{{ route('aulas.create') }}" class="btn btn-success">Crear Aula</a>
            @endrole
        </div>
    </div>
</div>

<hr>
</hr>

@if ($aulas->isEmpty())
<p>No hay aulas registradas aún.</p>
@else

<!-- Tabla de aulas -->
<div class="table-responsive mt-5 mb-5" style="max-height: 600px; overflow-y: auto;">
    <table class="table table-bordered table-striped align-middle mb-5">
        <thead>
            <tr>
                <th class="sticky-header">Nombre</th>
                <th class="sticky-header">Ubicación</th>
                <th class="sticky-header">Descripción</th>
                <th class="sticky-header">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($aulas as $aula)
            <tr>
                <td>{{ $aula->nombre }}</td>
                <td>{{ $aula->ubicacion }}</td>
                <td>{{ $aula->descripcion }}</td>
                <td>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('aulas.show', $aula->id) }}" class="btn btn-info">Ver</a>
                        @role('admin')
                        <a href="{{ route('aulas.edit', $aula->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('aulas.destroy', $aula->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Eliminar aula?')">Eliminar</button>
                        </form>
                        @endrole
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endif

@endsection