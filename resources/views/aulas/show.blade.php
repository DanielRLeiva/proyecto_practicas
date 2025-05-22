@extends('layouts.app')

@section('title', 'Equipos y Materiales de Aula')

@section('content')

@push('styles')
<style>
    .sticky-header {
        position: sticky;
        top: 0;
        z-index: 2;
        padding: 1rem !important;
        border: 1px solid #dee2e6;
        white-space: nowrap;
    }
</style>
@endpush

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex flex-column">
            <span class="navbar-text">
                Bienvenido, {{ Auth::user()->name }}
            </span>

            <a href="{{ route('aulas.index') }}" class="btn btn-primary mt-4 mb-5">Volver a la lista de aulas</a>
        </div>

        <div>
            <h2>{{ $aula->nombre }}</h2>
            <p><strong>Ubicación:</strong> {{ $aula->ubicacion }}</p>

            @if (!empty($aula->descripcion))
            <p><strong>Descripción:</strong> {{ $aula->descripcion }}</p>
            @endif
        </div>
    </div>

    <hr>
    </hr>

    <div class="d-flex justify-content-between mt-4 mb-4">
        <h3>Equipos</h3>

        @role('admin|editor')
        <a href="{{ route('equipos.create', $aula->id) }}" class="btn btn-success mb-3">Crear equipo</a>
        @endrole
    </div>

    @if($aula->equipos->isEmpty())
    <p class="mt-5 mb-5">No hay equipos registrados para esta aula.</p>
    @else

    <div class="table-responsive mb-5" style="max-height: 600px; overflow-y: auto;">
        <table class="table table-bordered table-striped align-middle mb-5">
            <thead>
                <tr>
                    <th class="sticky-header">Etiqueta CPU</th>
                    <th class="sticky-header">Marca CPU</th>
                    <th class="sticky-header">Modelo CPU</th>
                    <th class="sticky-header">Nº de serie CPU</th>
                    <th class="sticky-header">Tipo CPU</th>
                    <th class="sticky-header">Memoria</th>
                    <th class="sticky-header">Disco Duro</th>
                    <th class="sticky-header">Conectores de Vídeo</th>
                    <th class="sticky-header">Etiqueta Monitor</th>
                    <th class="sticky-header">Marca Monitor</th>
                    <th class="sticky-header">Modelo Monitor</th>
                    <th class="sticky-header">Conectores Monitor</th>
                    <th class="sticky-header">Pulgadas</th>
                    <th class="sticky-header">Nº de serie Monitor</th>
                    <th class="sticky-header">Etiqueta Teclado</th>
                    <th class="sticky-header">Etiqueta Ratón</th>
                    <th class="sticky-header">Nº de Inventario</th>
                    <th class="sticky-header">Observaciones</th>
                    @role('admin|editor')
                    <th class="sticky-header">Acciones</th>
                    @endrole
                </tr>
            </thead>
            <tbody>
                @foreach($aula->equipos as $equipo)
                <tr>
                    <td>{{ $equipo->etiqueta_cpu }}</td>
                    <td>{{ $equipo->marca_cpu }}</td>
                    <td>{{ $equipo->modelo_cpu }}</td>
                    <td>{{ $equipo->numero_serie_cpu }}</td>
                    <td>{{ $equipo->tipo_cpu }}</td>
                    <td>{{ $equipo->memoria }}</td>
                    <td>{{ $equipo->disco_duro }}</td>
                    <td>{{ $equipo->conectores_video }}</td>
                    <td>{{ $equipo->etiqueta_monitor }}</td>
                    <td>{{ $equipo->marca_monitor }}</td>
                    <td>{{ $equipo->modelo_monitor }}</td>
                    <td>{{ $equipo->conectores_monitor }}</td>
                    <td>{{ $equipo->pulgadas }}</td>
                    <td>{{ $equipo->numero_serie_monitor }}</td>
                    <td>{{ $equipo->etiqueta_teclado }}</td>
                    <td>{{ $equipo->etiqueta_raton }}</td>
                    <td>{{ $equipo->numero_inventario }}</td>
                    <td>{{ $equipo->observaciones }}</td>
                    @role('admin|editor')
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('equipos.edit', ['equipo' => $equipo->id, 'aula_id' => $aula->id]) }}" class="btn btn-warning">Editar</a>

                            <a href="{{ route('equipos.create', ['aula_id' => $aula->id]) }}? duplicar={{ $equipo->id }}" class="btn btn-info">Duplicar</a>
                            @role('admin')
                            <form action="{{ route('equipos.destroy', $equipo->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este equipo?')">Eliminar</button>
                            </form>
                            @endrole
                        </div>
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

    <div class="d-flex justify-content-between mt-4 mb-4">
        <h3>Materiales</h3>

        @role('admin|editor')
        <a href="{{ route('materials.create', $aula->id) }}" class="btn btn-success mb-3">Crear material</a>
        @endrole
    </div>

    @if($aula->materiales->isEmpty())
    <p class="mt-5 mb-5">No hay materiales registrados para esta aula.</p>
    @else

    <div class="table-responsive mb-5" style="max-height: 600px; overflow-y: auto;">
        <table class="table table-bordered table-striped align-middle mb-5">
            <thead>
                <tr>
                    <th class="sticky-header">Etiqueta</th>
                    <th class="sticky-header">Descripción</th>
                    <th class="sticky-header">Marca</th>
                    <th class="sticky-header">Modelo</th>
                    <th class="sticky-header">Nº de serie</th>
                    <th class="sticky-header">Características</th>
                    @role('admin|editor')
                    <th class="sticky-header">Acciones</th>
                    @endrole
                </tr>
            </thead>
            <tbody>
                @foreach($aula->materiales as $material)
                <tr>
                    <td>{{ $material->etiqueta }}</td>
                    <td>{{ $material->descripcion }}</td>
                    <td>{{ $material->marca }}</td>
                    <td>{{ $material->modelo }}</td>
                    <td>{{ $material->numero_serie }}</td>
                    <td>{{ $material->caracteristicas }}</td>
                    @role('admin|editor')
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('materials.edit', ['material' => $material->id, 'aula_id' => $aula->id]) }}" class="btn btn-warning">Editar</a>

                            @role('admin')
                            <form action="{{ route('materials.destroy', $material->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este material?')">Eliminar</button>
                            </form>
                            @endrole
                        </div>
                    </td>
                    @endrole
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @endif

    <div class="text-center">
        <a href="{{ route('aulas.index') }}" class="btn btn-primary mb-5">Volver a la lista de aulas</a>
    </div>
</div>

@endsection