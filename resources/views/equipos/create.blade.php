@extends('layouts.app')

@section('title', 'Lista de Aulas')

@section('content')

<div class="container d-flex justify-content-center align-items-center mt-5">

    <div class="w-100 mb-5" style="max-width: 500px;">
        <h2 class="text-center mb-5">Crear Nuevo Equipo</h2>

        <form action="{{ route('equipos.store', $aula_id) }}" method="POST">
            @csrf

            <!-- Campo oculto para el aula_id -->
            <input type="hidden" name="aula_id" value="{{ $aula_id }}">

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="etiqueta_cpu">Etiqueta CPU:</label>
                <input type="text" class="form-control" name="etiqueta_cpu" value="{{ old('etiqueta_cpu', $equipoDuplicado->etiqueta_cpu ?? '') }}">
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="marca_cpu">Marca CPU:</label>
                <input type="text" class="form-control" name="marca_cpu" value="{{ old('marca_cpu', $equipoDuplicado->marca_cpu ?? '') }}">
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="modelo_cpu">Modelo CPU:</label>
                <input type="text" class="form-control" name="modelo_cpu" value="{{ old('modelo_cpu', $equipoDuplicado->modelo_cpu ?? '') }}">
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="numero_serie_cpu">Número de serie CPU:</label>
                <input type="text" class="form-control" name="numero_serie_cpu" value="{{ old('numero_serie_cpu', $equipoDuplicado->numero_serie_cpu ?? '') }}">
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="tipo_cpu">Tipo CPU:</label>
                <input type="text" class="form-control" name="tipo_cpu" value="{{ old('tipo_cpu', $equipoDuplicado->tipo_cpu ?? '') }}">
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="memoria">Memoria:</label>
                <input type="text" class="form-control" name="memoria" value="{{ old('memoria', $equipoDuplicado->memoria ?? '') }}">
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="disco_duro">Disco Duro:</label>
                <input type="text" class="form-control" name="disco_duro" value="{{ old('disco_duro', $equipoDuplicado->disco_duro ?? '') }}">
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="conectores_video">Conectores Video:</label>
                <input type="text" class="form-control" name="conectores_video" value="{{ old('conectores_video', $equipoDuplicado->conectores_video ?? '') }}">
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="etiqueta_monitor">Etiqueta Monitor:</label>
                <input type="text" class="form-control" name="etiqueta_monitor" value="{{ old('etiqueta_monitor', $equipoDuplicado->etiqueta_monitor ?? '') }}">
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="marca_monitor">Marca Monitor:</label>
                <input type="text" class="form-control" name="marca_monitor" value="{{ old('marca_monitor', $equipoDuplicado->marca_monitor ?? '') }}">
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="modelo_monitor">Modelo Monitor:</label>
                <input type="text" class="form-control" name="modelo_monitor" value="{{ old('modelo_monitor', $equipoDuplicado->modelo_monitor ?? '') }}">
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="conectores_monitor">Conectores Monitor:</label>
                <input type="text" class="form-control" name="conectores_monitor" value="{{ old('conectores_monitor', $equipoDuplicado->conectores_monitor ?? '') }}">
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="pulgadas">Pulgadas:</label>
                <input type="number" step="0.1" class="form-control" name="pulgadas" value="{{ old('pulgadas', $equipoDuplicado->pulgadas ?? '') }}">
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="numero_serie_monitor">Número de serie Monitor:</label>
                <input type="text" class="form-control" name="numero_serie_monitor" value="{{ old('numero_serie_monitor', $equipoDuplicado->numero_serie_monitor ?? '') }}">
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="etiqueta_teclado">Etiqueta Teclado:</label>
                <input type="text" class="form-control" name="etiqueta_teclado" value="{{ old('etiqueta_teclado', $equipoDuplicado->etiqueta_teclado ?? '') }}">
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="etiqueta_raton">Etiqueta Ratón:</label>
                <input type="text" class="form-control" name="etiqueta_raton" value="{{ old('etiqueta_raton', $equipoDuplicado->etiqueta_raton ?? '') }}">
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="numero_inventario">Número de Inventario:</label>
                <input type="text" class="form-control" name="numero_inventario" value="{{ old('numero_inventario', $equipoDuplicado->numero_inventario ?? '') }}">
            </div>

            <div class="form-group mb-5">
                <label class="fw-bold mb-2" for="observaciones">Observaciones:</label>
                <textarea class="form-control" name="observaciones"></textarea>
            </div>

            <div class="d-flex justify-content-between mb-3">
                <button type="submit" class="btn btn-success">Crear Equipo</button>

                <a href="{{ route('aulas.show', $aula_id) }}" class="btn btn-primary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection