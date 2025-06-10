@extends('layouts.app')

@section('title', 'Creación de Equipos')

@section('content')

<div class="container d-flex justify-content-center align-items-center mt-5">

    <div class="w-100 mb-5" style="max-width: 500px;">
        {{-- Título principal mostrando el nombre del aula --}}
        <h1 class="text-center">Crear Nuevo Equipo en {{ $aula->nombre }}</h1>

        <hr>
        </hr>

        {{-- Formulario para crear un nuevo equipo --}}
        <form action="{{ route('equipos.store', $aula_id) }}" method="POST">
            @csrf {{-- Protección CSRF para evitar ataques --}}

            {{-- Campos ocultos para mantener datos importantes --}}
            <input type="hidden" name="redirect_to" value="{{ url()->previous() }}">
            <input type="hidden" name="aula_id" value="{{ $equipo->aula_id ?? $aula_id }}">

            {{-- Campo para etiqueta CPU, con valor antiguo o duplicado --}}
            <div class="form-group mt-5 mb-4">
                <label class="fw-bold mb-2" for="etiqueta_cpu">Etiqueta CPU:</label>
                <input type="text" class="form-control" name="etiqueta_cpu" value="{{ old('etiqueta_cpu', $equipoDuplicado->etiqueta_cpu ?? '') }}">
            </div>

            {{-- Campo para marca CPU --}}
            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="marca_cpu">Marca CPU:</label>
                <input type="text" class="form-control" name="marca_cpu" value="{{ old('marca_cpu', $equipoDuplicado->marca_cpu ?? '') }}">
            </div>

            {{-- Campo para modelo CPU --}}
            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="modelo_cpu">Modelo CPU:</label>
                <input type="text" class="form-control" name="modelo_cpu" value="{{ old('modelo_cpu', $equipoDuplicado->modelo_cpu ?? '') }}">
            </div>

            {{-- Campo para número de serie CPU --}}
            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="numero_serie_cpu">Número de serie CPU:</label>
                <input type="text" class="form-control" name="numero_serie_cpu" value="{{ old('numero_serie_cpu', $equipoDuplicado->numero_serie_cpu ?? '') }}">
            </div>

            {{-- Campo para tipo CPU --}}
            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="tipo_cpu">Tipo CPU:</label>
                <input type="text" class="form-control" name="tipo_cpu" value="{{ old('tipo_cpu', $equipoDuplicado->tipo_cpu ?? '') }}">
            </div>

            {{-- Campo para memoria --}}
            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="memoria">Memoria:</label>
                <input type="text" class="form-control" name="memoria" value="{{ old('memoria', $equipoDuplicado->memoria ?? '') }}">
            </div>

            {{-- Campo para disco duro --}}
            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="disco_duro">Disco Duro:</label>
                <input type="text" class="form-control" name="disco_duro" value="{{ old('disco_duro', $equipoDuplicado->disco_duro ?? '') }}">
            </div>

            {{-- Campo para conectores video --}}
            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="conectores_video">Conectores Video:</label>
                <input type="text" class="form-control" name="conectores_video" value="{{ old('conectores_video', $equipoDuplicado->conectores_video ?? '') }}">
            </div>

            {{-- Campo para etiqueta monitor --}}
            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="etiqueta_monitor">Etiqueta Monitor:</label>
                <input type="text" class="form-control" name="etiqueta_monitor" value="{{ old('etiqueta_monitor', $equipoDuplicado->etiqueta_monitor ?? '') }}">
            </div>

            {{-- Campo para marca monitor --}}
            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="marca_monitor">Marca Monitor:</label>
                <input type="text" class="form-control" name="marca_monitor" value="{{ old('marca_monitor', $equipoDuplicado->marca_monitor ?? '') }}">
            </div>

            {{-- Campo para modelo monitor --}}
            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="modelo_monitor">Modelo Monitor:</label>
                <input type="text" class="form-control" name="modelo_monitor" value="{{ old('modelo_monitor', $equipoDuplicado->modelo_monitor ?? '') }}">
            </div>

            {{-- Campo para conectores monitor --}}
            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="conectores_monitor">Conectores Monitor:</label>
                <input type="text" class="form-control" name="conectores_monitor" value="{{ old('conectores_monitor', $equipoDuplicado->conectores_monitor ?? '') }}">
            </div>

            {{-- Campo para pulgadas (monitor) --}}
            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="pulgadas">Pulgadas:</label>
                <input type="number" step="0.1" class="form-control" name="pulgadas" value="{{ old('pulgadas', $equipoDuplicado->pulgadas ?? '') }}">
            </div>

            {{-- Campo para número de serie monitor --}}
            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="numero_serie_monitor">Número de serie Monitor:</label>
                <input type="text" class="form-control" name="numero_serie_monitor" value="{{ old('numero_serie_monitor', $equipoDuplicado->numero_serie_monitor ?? '') }}">
            </div>

            {{-- Campo para etiqueta teclado --}}
            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="etiqueta_teclado">Etiqueta Teclado:</label>
                <input type="text" class="form-control" name="etiqueta_teclado" value="{{ old('etiqueta_teclado', $equipoDuplicado->etiqueta_teclado ?? '') }}">
            </div>

            {{-- Campo para etiqueta ratón --}}
            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="etiqueta_raton">Etiqueta Ratón:</label>
                <input type="text" class="form-control" name="etiqueta_raton" value="{{ old('etiqueta_raton', $equipoDuplicado->etiqueta_raton ?? '') }}">
            </div>

            {{-- Campo para número de inventario --}}
            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="numero_inventario">Número de Inventario:</label>
                <input type="text" class="form-control" name="numero_inventario" value="{{ old('numero_inventario', $equipoDuplicado->numero_inventario ?? '') }}">
            </div>

            {{-- Campo para observaciones --}}
            <div class="form-group mb-5">
                <label class="fw-bold mb-2" for="observaciones">Observaciones:</label>
                <textarea class="form-control" name="observaciones"></textarea>
            </div>

            {{-- Botones para enviar o cancelar --}}
            <div class="d-flex justify-content-between mb-3">
                <button type="submit" class="btn btn-success">Crear Equipo</button>
                <a href="{{ url()->previous() }}" class="btn btn-primary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection