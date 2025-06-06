@extends('layouts.app')

@section('title', 'Usufructos')

@section('content')

<div class="container-fluid my-5 px-1 px-md-2 px-lg-3 px-xl-4">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex flex-column">
            <span class="navbar-text fw-bold">
                Bienvenido, {{ Auth::user()->name }}
            </span>

            <h1>Portátiles</h1>
        </div>

        @role('admin|editor')
        <a href="{{ route('portatils.create') }}" class="btn btn-success mb-3">Nuevo Portatil</a>
        @endrole
    </div>
</div>

<hr>
</hr>

<!-- Tabla de Portátiles -->
<div class="table-responsive my-5" style="max-height: 600px; overflow-y: auto;">
    @if ($portatiles->isEmpty())
    <p class="container alert alert-warning text-center my-5">Aún no hay portátiles registrados.</p>

    @else
    <table class="table table-bordered table-striped align-middle mb-5">
        <thead>
            <tr>
                <th class="sticky-header">Marca y Modelo</th>
                <th class="sticky-header">Comentarios</th>
                <th class="sticky-header">Estado</th>
                @role('admin|editor')
                <th class="sticky-header">Acciones</th>
                @endrole
            </tr>
        </thead>
        <tbody>
            @foreach ($portatiles as $portatil)
            <tr class="{{ $portatil->activo }}">
                <td>{{ $portatil->marca_modelo }}</td>
                <td>{{ $portatil->comentarios }}</td>
                <td>
                    @switch($portatil->estado)
                    @case('Libre')
                    <span class="badge bg-success">Libre</span>
                    @break
                    @case('Asignado')
                    <span class="badge bg-warning text-dark">En Usufructo</span>
                    @break
                    @case('Baja')
                    <span class="badge bg-secondary">Inactivo</span>
                    @break
                    @endswitch
                </td>

                @role('admin|editor')
                <td>
                    <div class="d-flex justify-content-center gap-2">
                        <div>
                            @if ($portatil->estado === 'Libre' || $portatil->estado === 'Asignado')
                            <a href="{{ route('portatils.edit', $portatil->id) }}" class="btn btn-warning">Editar</a>
                            @endif
                        </div>

                        <div>
                            @if ($portatil->estado === 'Libre')

                            @role('admin')
                            <form action="{{ route('portatils.destroy', $portatil->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('¿Realmente desea DAR DE BAJA el Portátil?')">Baja</button>
                            </form>
                            @endrole
                        </div>

                        <div>
                            @elseif ($portatil->estado === 'Baja')
                            <form action="{{ route('portatils.activar', $portatil->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success"
                                    onclick="return confirm('¿Dar de ALTA el Portátil?')">Alta</button>
                            </form>
                        </div>
                    </div>
                    @endif
                </td>
                @endrole
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

<div class="text-center mb-5">
    <a href="{{ route('usufructos.index') }}" class="btn btn-primary">Volver a la lista de Usufructos</a>
</div>
</div>

@endsection