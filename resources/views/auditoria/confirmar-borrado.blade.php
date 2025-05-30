@extends('layouts.app')

@section('title', 'Confirmar Borrado')

@section('content')
<div class="mt-5">
    <h2 class="mt-4">Confirmar Borrado</h2>

    <hr>
    </hr>

    @if($auditorias->isEmpty())
    <div class="alert alert-warning my-5">No hay registros que coincidan con los filtros seleccionados.</div>

    <div class="text-center mb-5">
        <a href="{{ route('auditoria.index') }}" class="btn btn-primary">Volver a Auditorías</a>
    </div>

    @else

    <form action="{{ route('auditoria.destroySelected') }}" method="POST">
        @csrf
        @method('DELETE')

        <!-- Filtros reenviados -->
        <input type="hidden" name="usuario" value="{{ $request->usuario }}">
        <input type="hidden" name="fecha_inicio" value="{{ $request->fecha_inicio }}">
        <input type="hidden" name="fecha_fin" value="{{ $request->fecha_fin }}">
        <input type="hidden" name="modelo" value="{{ $request->modelo }}">
        <input type="hidden" name="accion" value="{{ $request->accion }}">

        <div class="mt-5">
            <h5>Selecciona los registros que deseas eliminar. Esta acción es irreversible.</h5>
        </div>

        <div class="table-responsive mt-5" style="max-height: 600px; overflow-y: auto;">
            <table class="table table-bordered table-striped align-middle mb-5">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>Usuario</th>
                        <th>Acción</th>
                        <th>Modelo</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($auditorias as $audit)
                    <tr>
                        <td>
                            <input type="checkbox" name="selected_ids[]" value="{{ $audit->id }}">
                        </td>
                        <td>{{ optional($audit->user)->name ?? 'Sistema' }}</td>
                        <td>
                            @switch($audit->event)
                            @case('created') <span class="badge bg-success">Creado</span> @break
                            @case('updated') <span class="badge bg-warning text-dark">Actualizado</span> @break
                            @case('deleted') <span class="badge bg-danger">Eliminado</span> @break
                            @default <span class="badge bg-secondary">{{ $audit->event }}</span> @endswitch
                        </td>
                        <td>{{ $audit->modelName }}</td>
                        <td>{{ $audit->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-5">
            <button type="submit" class="btn btn-danger me-2" onclick="return confirm('¿Estás seguro de que quieres borrar las auditorías seleccionadas?');">
                Borrar seleccionados
            </button>

            <a href="{{ route('auditoria.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>

    @endif
</div>

<script src="{{ asset('js/confirmar-borrado.js') }}"></script>

@endsection