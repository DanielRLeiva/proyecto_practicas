@extends('layouts.app')

@section('title', 'Confirmar Borrado de Auditorías')

@section('content')

<div class="concontainer-fluid my-5 px-1 px-md-2 px-lg-3 px-xl-4">
    {{-- Encabezado con bienvenida y botón de regreso --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex flex-column">
            <span class="navbar-text fw-bold">
                Bienvenido, {{ Auth::user()->name }}
            </span>

            <h1>Confirmar Borrado</h1>
        </div>

        <a href="{{ route('auditoria.index') }}" class="btn btn-primary">Volver a Auditorías</a>
    </div>
</div>

<hr> {{-- Separador visual --}}

@if($auditorias->isEmpty())
{{-- Mensaje si no hay auditorías para mostrar --}}
<p class="container alert alert-warning text-center my-5">No hay registros que coincidan con los filtros seleccionados.</p>

<div class="text-center mb-5">
    <a href="{{ route('auditoria.index') }}" class="btn btn-primary">Volver a Auditorías</a>
</div>

@else

{{-- Formulario para eliminar registros seleccionados --}}
<form action="{{ route('auditoria.destroySelected') }}" method="POST">
    @csrf
    @method('DELETE')

    {{-- Reenvío de filtros aplicados en la búsqueda --}}
    <input type="hidden" name="usuario" value="{{ $request->usuario }}">
    <input type="hidden" name="fecha_inicio" value="{{ $request->fecha_inicio }}">
    <input type="hidden" name="fecha_fin" value="{{ $request->fecha_fin }}">
    <input type="hidden" name="modelo" value="{{ $request->modelo }}">
    <input type="hidden" name="accion" value="{{ $request->accion }}">

    <div class="my-3">
        <h2>Selecciona los registros a eliminar.</h2>
    </div>

    {{-- Tabla con registros de auditoría --}}
    <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
        <table class="table table-bordered table-striped align-middle mb-5">
            <thead>
                <tr>
                    {{-- Checkbox para selección múltiple --}}
                    <th class="sticky-header"><input type="checkbox" id="select-all"></th>
                    <th class="sticky-header">Usuario</th>
                    <th class="sticky-header">Acción</th>
                    <th class="sticky-header">Elemento</th>
                    <th class="sticky-header">Modelo</th>
                    <th class="sticky-header">Fecha</th>
                </tr>
            </thead>
            <tbody>
                {{-- Iteración de registros --}}
                @foreach($auditorias as $audit)
                <tr>
                    <td>
                        <input type="checkbox" name="selected_ids[]" value="{{ $audit->id }}">
                    </td>
                    <td>{{ optional($audit->user)->name ?? 'Sistema' }}</td>
                    <td>
                        {{-- Etiqueta según tipo de evento --}}
                        @switch($audit->event)
                        @case('created') <span class="badge bg-success">Creado</span> @break
                        @case('updated') <span class="badge bg-warning text-dark">Actualizado</span> @break
                        @case('deleted') <span class="badge bg-danger">Eliminado</span> @break
                        @default <span class="badge bg-secondary">{{ $audit->event }}</span> @endswitch
                    </td>
                    <td>{{ $audit->label }}</td>
                    <td>{{ $audit->modelName }}</td>
                    <td>{{ $audit->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Botones de acción --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <button type="submit" class="btn btn-danger me-2" onclick="return confirm('¿Estás seguro de que quieres borrar las auditorías seleccionadas? Esta acción es irreversible!');">
            Borrar seleccionados
        </button>

        <a href="{{ route('auditoria.index') }}" class="btn btn-primary">Cancelar</a>
    </div>
</form>

@endif
</div>

{{-- Script para manejar la selección de checkboxes --}}
<script src="{{ asset('js/confirmar-borrado.js') }}"></script>

@endsection