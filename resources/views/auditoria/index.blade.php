@extends('layouts.app')

@section('title', 'Auditoría')

@section('content')

<div class="concontainer-fluid my-5 px-1 px-md-2 px-lg-3 px-xl-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex flex-column">
            {{-- Nombre usuario autenticado --}}
            <span class="navbar-text fw-bold">
                Bienvenido, {{ Auth::user()->name }}
            </span>

            <h1>Registro de Auditoría</h1>
        </div>

        <div class="d-flex flex-column gap-2">
            {{-- Link a lista de ubicaciones --}}
            <a href="{{ route('aulas.index') }}" class="btn btn-primary">Volver a la lista de Ubicaciones</a>

            {{-- Botón para mostrar/ocultar formulario de filtros --}}
            <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#filterFormCollapse">Desplegar Filtrado</button>
        </div>
    </div>
</div>

<hr>

<div class="collapse my-4" id="filterFormCollapse">
    <div class="mx-auto" style="max-width: 600px;">
        <form method="GET" action="{{ route('auditoria.index') }}" class="mb-5">

            {{-- Selector de cantidad de registros por página --}}
            <div class="mb-3">
                <label class="fw-bold mb-2" for="per_page">Registros por página</label>
                <select name="per_page" id="per_page" class="form-select">
                    @foreach([10, 20, 30, 50] as $cantidad)
                    <option value="{{ $cantidad }}" {{ request('per_page', 5) == $cantidad ? 'selected' : '' }}>
                        {{ $cantidad }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="row g-3 align-items-end">
                {{-- Filtro usuario --}}
                <div class="form-group mb-2">
                    <label class="fw-bold mb-2" for="usuario">Usuario</label>
                    <select name="usuario" id="usuario" class="form-control">
                        <option value="">Todos</option>
                        <option value="Sistema" {{ request('usuario') == 'Sistema' ? 'selected' : '' }}>Sistema</option>
                        @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->name }}" {{ request('usuario') == $usuario->name ? 'selected' : '' }}>
                            {{ $usuario->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filtro rango fechas --}}
                <div class="form-group mb-2 w-100">
                    <div class="d-flex gap-3">
                        <div class="flex-fill d-flex flex-column">
                            <label for="fecha_inicio" class="fw-bold mb-2">Desde</label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ request('fecha_inicio') }}">
                        </div>
                        <div class="flex-fill d-flex flex-column">
                            <label for="fecha_fin" class="fw-bold mb-2">Hasta</label>
                            <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}">
                        </div>
                    </div>
                </div>

                {{-- Filtro modelo --}}
                <div class="form-group mb-3">
                    <label class="fw-bold mb-2" for="modelo">Modelo</label>
                    <select name="modelo" id="modelo" class="form-control">
                        <option value="">Todos</option>
                        <option value="Ubicacion" {{ request('modelo') == 'Ubicacion' ? 'selected' : '' }}>Ubicación</option>
                        <option value="Equipo" {{ request('modelo') == 'Equipo' ? 'selected' : '' }}>Equipo</option>
                        <option value="Material" {{ request('modelo') == 'Material' ? 'selected' : '' }}>Material</option>
                        <option value="Portatil" {{ request('modelo') == 'Portatil' ? 'selected' : '' }}>Portátil</option>
                        <option value="Profesor" {{ request('modelo') == 'Profesor' ? 'selected' : '' }}>Profesor</option>
                        <option value="Usufructo" {{ request('modelo') == 'Usufructo' ? 'selected' : '' }}>Usufructo</option>
                        <option value="User" {{ request('modelo') == 'User' ? 'selected' : '' }}>Usuario</option>
                    </select>
                </div>

                {{-- Filtro acción --}}
                <div class="form-group mb-2">
                    <label class="fw-bold mb-2" for="accion">Acción</label>
                    <select name="accion" id="accion" class="form-control">
                        <option value="">Todas</option>
                        <option value="created" {{ request('accion') == 'created' ? 'selected' : '' }}>Creado</option>
                        <option value="updated" {{ request('accion') == 'updated' ? 'selected' : '' }}>Actualizado</option>
                        <option value="deleted" {{ request('accion') == 'deleted' ? 'selected' : '' }}>Eliminado</option>
                    </select>
                </div>

                {{-- Botones filtrar y limpiar --}}
                <div class="d-flex justify-content-between  mt-5">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                    <a href="{{ route('auditoria.index') }}" class="btn btn-secondary">Limpiar</a>
                </div>
            </div>
        </form>
    </div>
    <hr>
</div>

<div class="container-fluid my-4 px-1 px-md-2 px-lg-3 px-xl-4">
    <div class="d-flex justify-content-between align-items-center">
        <h3>Modificaciones</h3>

        {{-- Formulario para borrar registros filtrados --}}
        <form action="{{ route('auditoria.confirmarBorrado') }}" method="POST">
            @csrf
            {{-- Envío de filtros actuales para borrar --}}
            <input type="hidden" name="usuario" value="{{ request('usuario') }}">
            <input type="hidden" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
            <input type="hidden" name="fecha_fin" value="{{ request('fecha_fin') }}">
            <input type="hidden" name="modelo" value="{{ request('modelo') }}">
            <input type="hidden" name="accion" value="{{ request('accion') }}">

            <button type="submit" class="btn btn-danger">
                Borrar registros filtrados
            </button>
        </form>
    </div>
</div>

<div class="table-responsive mt-3" style="max-height: 600px; overflow-y: auto;">
    @if (!$auditorias->isNotEmpty())
    {{-- Mensaje si no hay registros --}}
    <p class="container alert alert-warning text-center my-5">No hay registros de auditoría aún.</p>

    @else
    <table class="table table-bordered table-striped align-middle mb-5">
        <thead>
            <tr>
                <th class="sticky-header">Usuario</th>
                <th class="sticky-header">Acción</th>
                <th class="sticky-header">Elemento</th>
                <th class="sticky-header">Modelo</th>
                <th class="sticky-header">Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($auditorias as $audit)
            <tr>
                {{-- Nombre usuario o 'Sistema' --}}
                <td>{{ optional($audit->user)->name ?? 'Sistema' }}</td>

                {{-- Badge según tipo de acción --}}
                <td>
                    @switch($audit->event)
                    @case('created') <span class="badge bg-success">Creado</span> @break
                    @case('updated') <span class="badge bg-warning text-dark">Actualizado</span> @break
                    @case('deleted') <span class="badge bg-danger">Eliminado</span>
                    @break
                    @default
                    <span class="badge bg-secondary">{{ $audit->event }}</span>
                    @endswitch
                </td>

                {{-- Elemento auditado --}}
                <td>{{ $audit->label }}</td>
                {{-- Modelo del registro --}}
                <td>{{ $audit->modelName }}</td>
                {{-- Fecha y hora formateada --}}
                <td>{{ $audit->created_at->format('d/m/Y H:i') }}</td>
            </tr>

            {{-- Mostrar detalles de modificaciones si fue actualización --}}
            @if($audit->event === 'updated')
            <tr>
                <td colspan="5">
                    <button class="btn btn-link p-0" type="button" data-bs-toggle="collapse" data-bs-target="#detalles-{{ $audit->id }}">
                        Ver cambios
                    </button>
                    <div class="collapse mt-2" id="detalles-{{ $audit->id }}">
                        <ul class="mb-0">
                            @foreach($audit->modificaciones_formateadas as $mod)
                            <li>
                                <strong>{{ $mod['field'] }}:</strong>
                                <span class="text-danger">{{ $mod['old'] }}</span> →
                                <span class="text-success">{{ $mod['new'] }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </td>
            </tr>
            @endif

            @endforeach
        </tbody>
    </table>
    @endif
</div>

{{-- Paginación --}}
<div class="d-flex justify-content-center mb-4">
    {{ $auditorias->links('pagination::bootstrap-4') }}
</div>

{{-- Botón para volver a lista de ubicaciones --}}
<div class="text-center mb-5">
    <a href="{{ route('aulas.index') }}" class="btn btn-primary">Volver a la lista de Ubicaciones</a>
</div>

{{-- Script para manejo de fechas en formulario --}}
@push('scripts')
<script src="{{ asset('js/fechasForm.js') }}"></script>
@endpush

@endsection