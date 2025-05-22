@extends('layouts.app')

@section('title', 'Edición de Equipos')

@section('content')

<div class="container d-flex justify-content-center align-items-center mt-5">

    <div class="w-100 mb-5" style="max-width: 500px;">

        <h1 class="text-center mb-5">Editar Equipo: {{ $equipo->etiqueta_cpu }}</h1>

        <form action="{{ route('equipos.update', $equipo) }}" method="POST">
            @csrf
            @method('PUT') <!-- Esto es necesario para hacer un update en Laravel -->

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="etiqueta_cpu">Etiqueta CPU</label>
                <input type="text" id="etiqueta_cpu" name="etiqueta_cpu" class="form-control" value="{{ old('etiqueta_cpu', $equipo->etiqueta_cpu) }}">
                @error('etiqueta_cpu')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="marca_cpu">Marca CPU</label>
                <input type="text" id="marca_cpu" name="marca_cpu" class="form-control" value="{{ old('marca_cpu', $equipo->marca_cpu) }}">
                @error('marca_cpu')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="modelo_cpu">Modelo CPU</label>
                <input type="text" id="modelo_cpu" name="modelo_cpu" class="form-control" value="{{ old('modelo_cpu', $equipo->modelo_cpu) }}">
                @error('modelo_cpu')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="numero_serie_cpu">Número de Serie CPU</label>
                <input type="text" id="numero_serie_cpu" name="numero_serie_cpu" class="form-control" value="{{ old('numero_serie_cpu', $equipo->numero_serie_cpu) }}">
                @error('numero_serie_cpu')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="tipo_cpu">Tipo CPU</label>
                <input type="text" id="tipo_cpu" name="tipo_cpu" class="form-control" value="{{ old('tipo_cpu', $equipo->tipo_cpu) }}">
                @error('tipo_cpu')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="memoria">Memoria</label>
                <input type="text" id="memoria" name="memoria" class="form-control" value="{{ old('memoria', $equipo->memoria) }}">
                @error('memoria')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="disco_duro">Disco Duro</label>
                <input type="text" id="disco_duro" name="disco_duro" class="form-control" value="{{ old('disco_duro', $equipo->disco_duro) }}">
                @error('disco_duro')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="conectores_video">Conectores de Vídeo</label>
                <input type="text" id="conectores_video" name="conectores_video" class="form-control" value="{{ old('conectores_video', $equipo->conectores_video) }}">
                @error('conectores_video')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="etiqueta_monitor">Etiqueta Monitor</label>
                <input type="text" id="etiqueta_monitor" name="etiqueta_monitor" class="form-control" value="{{ old('etiqueta_monitor', $equipo->etiqueta_monitor) }}">
                @error('etiqueta_monitor')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="marca_monitor">Marca Monitor</label>
                <input type="text" id="marca_monitor" name="marca_monitor" class="form-control" value="{{ old('marca_monitor', $equipo->marca_monitor) }}">
                @error('marca_monitor')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="modelo_monitor">Modelo Monitor</label>
                <input type="text" id="modelo_monitor" name="modelo_monitor" class="form-control" value="{{ old('modelo_monitor', $equipo->modelo_monitor) }}">
                @error('modelo_monitor')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="conectores_monitor">Conectores Monitor</label>
                <input type="text" id="conectores_monitor" name="conectores_monitor" class="form-control" value="{{ old('conectores_monitor', $equipo->conectores_monitor) }}">
                @error('conectores_monitor')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="pulgadas">Pulgadas</label>
                <input type="number" step="0.1" id="pulgadas" name="pulgadas" class="form-control" value="{{ old('pulgadas', $equipo->pulgadas) }}">
                @error('pulgadas')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="numero_serie_monitor">Número de Serie Monitor</label>
                <input type="text" id="numero_serie_monitor" name="numero_serie_monitor" class="form-control" value="{{ old('numero_serie_monitor', $equipo->numero_serie_monitor) }}">
                @error('numero_serie_monitor')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="etiqueta_teclado">Etiqueta Teclado</label>
                <input type="text" id="etiqueta_teclado" name="etiqueta_teclado" class="form-control" value="{{ old('etiqueta_teclado', $equipo->etiqueta_teclado) }}">
                @error('etiqueta_teclado')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="etiqueta_raton">Etiqueta Ratón</label>
                <input type="text" id="etiqueta_raton" name="etiqueta_raton" class="form-control" value="{{ old('etiqueta_raton', $equipo->etiqueta_raton) }}">
                @error('etiqueta_raton')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="numero_inventario">Número de Inventario:</label>
                <input type="text" id="numero_inventario" name="numero_inventario" class="form-control" value="{{ old('numero_inventario', $equipo->numero_inventario) }}">
            </div>

            <div class="form-group mb-5">
                <label class="fw-bold mb-2" for="observaciones">Observaciones</label>
                <textarea id="observaciones" name="observaciones" class="form-control">{{ old('observaciones', $equipo->observaciones) }}</textarea>
                @error('observaciones')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between mb-3">
                <button type="submit" class="btn btn-success">Actualizar Equipo</button>

                <a href="{{ route('aulas.show', $equipo->aula_id) }}" class="btn btn-primary">Cancelar</a>
            </div>

            <input type="hidden" name="aula_id" value="{{ $equipo->aula_id }}">
        </form>
    </div>
</div>

@endsection