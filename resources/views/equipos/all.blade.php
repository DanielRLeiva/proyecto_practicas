@extends('layouts.app')

@section('title', 'Todos los Equipos')

@section('content')

{{-- Contenedor principal con margenes y padding responsivo --}}
<div class="container-fluid my-5 px-1 px-md-2 px-lg-3 px-xl-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        {{-- Saludo con el nombre del usuario autenticado --}}
        <div class="d-flex flex-column">
            <span class="navbar-text fw-bold">
                Bienvenido, {{ Auth::user()->name }}
            </span>

            {{-- Título de la página --}}
            <h1>Todos los Equipos</h1>
        </div>

        {{-- Botones para volver y para mostrar/ocultar filtro --}}
        <div class="d-flex flex-column gap-2">
            {{-- Enlace para volver a la lista de ubicaciones (aulas) --}}
            <a href="{{ route('aulas.index') }}" class="btn btn-primary">Volver a la Lista de Ubicaciones</a>

            {{-- Botón que despliega el formulario de filtrado --}}
            <button type="button" class="btn btn-primary mb-4" data-bs-toggle="collapse" data-bs-target="#filterFormCollapse">Desplegar Filtrado</button>
        </div>
    </div>
</div>

<hr>

{{-- Formulario colapsable para filtrar equipos --}}
<div class="collapse mt-4" id="filterFormCollapse">
    <div class="mx-auto" style="max-width: 500px;">

        {{-- Formulario GET para filtrar la lista --}}
        <form method="GET" action="{{ route('equipos.all') }}">

            {{-- Selector para cantidad de registros por página --}}
            <div class="mb-3">
                <label class="fw-bold mb-2" for="per_page" class="form-label">Registros por página</label>
                <select name="per_page" id="per_page" class="form-select">
                    {{-- Opciones predefinidas para paginación --}}
                    @foreach([10, 20, 30, 50] as $cantidad)
                    <option value="{{ $cantidad }}" {{ request('per_page', 5) == $cantidad ? 'selected' : '' }}>
                        {{ $cantidad }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="row g-3 align-items-end">
                {{-- Filtro por aula --}}
                <div class="form-group mb-3">
                    <label class="fw-bold form-label" for="aula_id">Aula</label>
                    <select name="aula_id" id="aula_id" class="form-control">
                        <option value="">-- Aula --</option>
                        {{-- Opciones dinámicas según aulas disponibles --}}
                        @foreach ($aulas as $aula)
                        <option value="{{ $aula->id }}" {{ request('aula_id') == $aula->id ? 'selected' : '' }}>
                            {{ $aula->nombre }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filtro por marca de CPU --}}
                <div class="form-group mb-3">
                    <label class="fw-bold form-label" for="marca_cpu">Marca de CPU</label>
                    <input type="text" name="marca_cpu" class="form-control" placeholder="Marca CPU" value="{{ request('marca_cpu') }}">
                </div>

                {{-- Filtro por número de inventario --}}
                <div class="form-group mb-3">
                    <label class="fw-bold form-label" for="numero_inventario">Número de Inventario</label>
                    <input type="text" name="numero_inventario" class="form-control" placeholder="N° Inventario" value="{{ request('numero_inventario') }}">
                </div>

                {{-- Botones para enviar o limpiar filtros --}}
                <div class="d-flex justify-content-between mb-4">
                    <button type="submit" class="btn btn-primary mt-3">Filtrar</button>
                    <a href="{{ route('equipos.all') }}" class="btn btn-secondary mt-3">Limpiar</a>
                </div>
            </div>
        </form>

        <hr>
    </div>
</div>

{{-- Tabla responsiva para mostrar equipos --}}
<div class="table-responsive mt-5 mb-5" style="max-height: 600px; overflow-y: auto;">

    {{-- Mensaje si no hay equipos --}}
    @if($equipos->isEmpty())
    <p class="container alert alert-warning text-center text-muted my-5">
        No se encontraron equipos.
    </p>

    @else
    {{-- Tabla con listado de equipos --}}
    <table class="table table-bordered table-striped align-middle mb-5">
        <thead>
            <tr>
                {{-- Encabezados con sticky para que queden fijos al hacer scroll --}}
                <th class="sticky-header">Aula</th>
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
            </tr>
        </thead>
        <tbody>
            {{-- Recorremos cada equipo y mostramos sus datos --}}
            @foreach($equipos as $equipo)
            <tr class="equipo-row" data-id="{{ $equipo->id }}" data-aula-id="{{ $equipo->aula->id ?? 0 }}">
                <td>{{ $equipo->aula->nombre ?? 'Sin aula' }}</td>
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
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Menú contextual para acciones en equipos --}}
    <div id="equipoContextMenu" class="card shadow p-2" style="display: none; position: absolute; z-index: 1000;">
        <div class="d-flex gap-2">
            {{-- Enlace para editar equipo --}}
            <a id="equipoContextEdit" href="#" class="btn btn-warning btn-sm">Editar</a>

            {{-- Enlace para duplicar equipo --}}
            <a id="equipoContextDuplicate" href="#" class="btn btn-info btn-sm">Duplicar</a>

            {{-- Formulario para eliminar equipo con confirmación --}}
            <form id="equipoContextDeleteForm" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar este equipo?')">Eliminar</button>
            </form>
        </div>
    </div>

</div>
@endif

{{-- Paginación Bootstrap para la lista de equipos --}}
<div class="d-flex justify-content-center mb-5">
    {{ $equipos->links('pagination::bootstrap-4') }}
</div>

{{-- Enlace para volver a la lista de aulas --}}
<div class="text-center mb-5">
    <a href="{{ route('aulas.index') }}" class="btn btn-primary">Volver a la Lista de Aulas</a>
</div>
</div>

{{-- Incluye el script para detalles de aula (probablemente para manejar interacciones) --}}
@push('scripts')
<script src="{{ asset('js/aula-detalle.js') }}"></script>
@endpush

@endsection