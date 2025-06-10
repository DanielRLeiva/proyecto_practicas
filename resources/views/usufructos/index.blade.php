@extends('layouts.app')

@section('title', 'Usufructos')

@section('content')

<div class="container-fluid my-5 px-1 px-md-2 px-lg-3 px-xl-4">
    <div class="d-flex justify-content-between align-items-center">
        {{-- Saludo al usuario autenticado --}}
        <div class="d-flex flex-column">
            <span class="navbar-text fw-bold">
                Bienvenido, {{ Auth::user()->name }}
            </span>

            {{-- Título principal --}}
            <h1>Usufructo de Portátiles</h1>
        </div>

        {{-- Botón para volver a la lista de aulas --}}
        <div class="text-center">
            <a href="{{ route('aulas.index') }}" class="btn btn-primary">Volver a la lista de Aulas</a>
        </div>
    </div>
</div>

<hr>

<!-- Botones de navegación entre secciones -->
<div class="d-flex justify-content-between gap-2">
    {{-- Botón para ver lista de profesores --}}
    <div class="text-center mt-4 mb-2">
        <a href="{{ route('profesors.index') }}" class="btn btn-primary">Profesores</a>
    </div>

    {{-- Botón para asignar un nuevo usufructo, visible solo para roles admin y editor --}}
    <div class="text-center mt-4 mb-2">
        @role('admin|editor')
        <a href="{{ route('usufructos.create') }}" class="btn btn-success mb-3">Asignar Nuevo Usufructo</a>
        @endrole
    </div>

    {{-- Botón para ver lista de portátiles --}}
    <div class="text-center mt-4 mb-2">
        <a href="{{ route('portatils.index') }}" class="btn btn-primary">Portátiles</a>
    </div>
</div>

<hr>

<!-- Tabla de usufructos activos -->
<h3 class="mt-4 mb-3">Préstamos Activos</h3>

@if($usufructosActivos->isEmpty())
{{-- Mensaje si no hay usufructos activos --}}
<p class="container alert alert-warning text-center my-5">No hay usufructos activos.</p>
@else
<div class="table-responsive mb-5" style="max-height: 600px; overflow-y: auto;">
    <table class="table table-bordered table-striped align-middle mb-5">
        <thead>
            <tr>
                {{-- Encabezados de la tabla --}}
                <th class="sticky-header">Profesor</th>
                <th class="sticky-header">Portátil</th>
                <th class="sticky-header">Comentarios</th>
                <th class="sticky-header">Fecha Inicio</th>
                <th class="sticky-header">Fecha Fin</th>
                {{-- Columna acciones solo para roles admin y editor --}}
                @role('admin|editor')
                <th class="sticky-header">Acciones</th>
                @endrole
            </tr>
        </thead>
        <tbody>
            {{-- Recorremos los usufructos activos para mostrar sus datos --}}
            @foreach ($usufructosActivos as $usufructo)
            <tr>
                <td>{{ $usufructo->profesor->nombre }} {{ $usufructo->profesor->apellido_1 }} {{ $usufructo->profesor->apellido_2 }}</td>
                <td>{{ $usufructo->portatil->marca_modelo }}</td>
                <td>{{ $usufructo->portatil->comentarios }}</td>
                <td>{{ \Carbon\Carbon::parse($usufructo->fecha_inicio)->format('d-m-Y') }}</td>
                {{-- Si no hay fecha fin, se muestra "En uso" --}}
                <td>{{ $usufructo->fecha_fin ?? 'En uso' }}</td>

                @role('admin|editor')
                {{-- Botón para finalizar (editar) el usufructo --}}
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

<!-- Tabla de historial de usufructos finalizados -->
<h3 class="mt-4 mb-3">Historial de Préstamos</h3>

@if ($usufructosFinalizados->isEmpty())
{{-- Mensaje si no hay historial --}}
<p class="container alert alert-warning text-center my-5">No hay historial de usufructos finalizados.</p>
@else
<div class="table-responsive mb-5" style="max-height: 600px; overflow-y: auto;">
    <table class="table table-bordered table-striped align-middle mb-5">
        <thead>
            <tr>
                {{-- Encabezados --}}
                <th class="sticky-header">Profesor</th>
                <th class="sticky-header">Portátil</th>
                <th class="sticky-header">Comentarios</th>
                <th class="sticky-header">Fecha Inicio</th>
                <th class="sticky-header">Fecha Fin</th>
                {{-- Acciones solo para rol admin --}}
                @role('admin')
                <th class="sticky-header">Acciones</th>
                @endrole
            </tr>
        </thead>
        <tbody>
            {{-- Recorremos el historial --}}
            @foreach ($usufructosFinalizados as $usufructo)
            <tr>
                <td>{{ $usufructo->profesor->nombre }} {{ $usufructo->profesor->apellido_1 }} {{ $usufructo->profesor->apellido_2 }}</td>
                <td>{{ $usufructo->portatil->marca_modelo }}</td>
                <td>{{ $usufructo->portatil->comentarios }}</td>
                <td>{{ \Carbon\Carbon::parse($usufructo->fecha_inicio)->format('d-m-Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($usufructo->fecha_fin)->format('d-m-Y') }}</td>

                @role('admin')
                {{-- Formulario para eliminar un usufructo finalizado --}}
                <td class="text-center">
                    <form action="{{ route('usufructos.destroy', $usufructo->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Eliminar usufructo?')">Eliminar</button>
                    </form>
                </td>
                @endrole
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

{{-- Botón para regresar a la lista de aulas --}}
<div class="text-center mb-5">
    <a href="{{ route('aulas.index') }}" class="btn btn-primary">Volver a la lista de Aulas</a>
</div>
</div>

@endsection