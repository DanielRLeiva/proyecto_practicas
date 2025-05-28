@extends('layouts.app')

@section('title', 'Usufructos')

@section('content')

<div class="container-fluid my-5 px-1 px-md-2 px-lg-3 px-xl-4">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex flex-column">
            <span class="navbar-text fw-bold">
                Bienvenido, {{ Auth::user()->name }}
            </span>

            <h1>Usufructo de Portátiles</h1>
        </div>

        <div class="text-center">
            <a href="{{ route('aulas.index') }}" class="btn btn-primary">Volver a la lista de Aulas</a>
        </div>
    </div>
</div>

<hr>
</hr>

<!-- Botones de navegación -->
<div class="d-flex justify-content-between gap-2">
    <!-- Botón para ver Profesores -->
    <div class="text-center mt-4 mb-2">
        <a href="{{ route('profesors.index') }}" class="btn btn-primary">Profesores</a>
    </div>

    <!-- Botón para asignar un nuevo usufructo -->
    <div class="text-center mt-4 mb-2">
        @role('admin|editor')
        <a href="{{ route('usufructos.create') }}" class="btn btn-success mb-3">Asignar Nuevo Usufructo</a>
        @endrole
    </div>

    <!-- Botón para ver Portátiles -->
    <div class="text-center mt-4 mb-2">
        <a href="{{ route('portatils.index') }}" class="btn btn-primary">Portátiles</a>
    </div>
</div>

<hr>
</hr>

<!-- Tabla de usufructos (préstamos activos) -->
<h3 class="mt-4 mb-3">Préstamos Activos</h3>

@if($usufructosActivos->isEmpty())
<p>No hay usufructos activos.</p>
@else

<div class="table-responsive mb-5" style="max-height: 600px; overflow-y: auto;">
    <table class="table table-bordered table-striped align-middle mb-5">
        <thead>
            <tr>
                <th class="sticky-header">Profesor</th>
                <th class="sticky-header">Portátil</th>
                <th class="sticky-header">Comentarios</th>
                <th class="sticky-header">Fecha Inicio</th>
                <th class="sticky-header">Fecha Fin</th>
                @role('admin|editor')
                <th class="sticky-header">Acciones</th>
                @endrole
            </tr>
        </thead>
        <tbody>
            @foreach ($usufructosActivos as $usufructo)
            <tr>
                <td>{{ $usufructo->profesor->nombre }} {{ $usufructo->profesor->apellido_1 }} {{ $usufructo->profesor->apellido_2 }}</td>
                <td>{{ $usufructo->portatil->marca_modelo }}</td>
                <td>{{ $usufructo->portatil->comentarios }}</td>
                <td>{{ \Carbon\Carbon::parse($usufructo->fecha_inicio)->format('d-m-Y') }}</td>
                <td>{{ $usufructo->fecha_fin ?? 'En uso' }}</td>
                @role('admin|editor')
                <td class="text-center">
                    <a href="{{ route('usufructos.edit', $usufructo->id) }}" class="btn btn-warning">Finalizar</a>
                </td>
                @endrole
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<hr>
</hr>

<!-- Tabla de historial de usufructos (préstamos finalizados) -->
<h3 class="mt-4 mb-3">Historial de Préstamos</h3>

@if ($usufructosFinalizados->isEmpty())
<p>No hay historial de usufructos finalizados</p>
@else

<div class="table-responsive mb-5" style="max-height: 600px; overflow-y: auto;">
    <table class="table table-bordered table-striped align-middle mb-5">
        <thead>
            <tr>
                <th class="sticky-header">Profesor</th>
                <th class="sticky-header">Portátil</th>
                <th class="sticky-header">Comentarios</th>
                <th class="sticky-header">Fecha Inicio</th>
                <th class="sticky-header">Fecha Fin</th>
                @role('admin')
                <th class="sticky-header">Acciones</th>
                @endrole
            </tr>
        </thead>
        <tbody>
            @foreach ($usufructosFinalizados as $usufructo)
            <tr>
                <td>{{ $usufructo->profesor->nombre }} {{ $usufructo->profesor->apellido_1 }} {{ $usufructo->profesor->apellido_2 }}</td>
                <td>{{ $usufructo->portatil->marca_modelo }}</td>
                <td>{{ $usufructo->portatil->comentarios }}</td>
                <td>{{ \Carbon\Carbon::parse($usufructo->fecha_inicio)->format('d-m-Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($usufructo->fecha_fin)->format('d-m-Y') }}</td>

                @role('admin')
                <td class="text-center">
                    <form action="{{ route('usufructos.destroy', $usufructo->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Eliminar usufructo?')">Eliminar</button>
                    </form>
                    @endrole
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<div class="text-center mb-5">
    <a href="{{ route('aulas.index') }}" class="btn btn-primary">Volver a la lista de Aulas</a>
</div>
</div>

@endsection