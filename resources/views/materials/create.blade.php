@extends('layouts.app')

@section('title', 'Creación de Materiales')

@section('content')

<div class="container d-flex justify-content-center align-items-center mt-5">

    <div class="w-100 mb-5" style="max-width: 500px;">

        <h1 class="text-center">Crear Material - Aula: {{ $aula->nombre }}</h1>

        <hr>
        </hr>

        <form action="{{ route('materials.store') }}" method="POST">
            @csrf
            <input type="hidden" name="aula_id" value="{{ $aula->id }}">

            <div class="form-group mt-5 mb-4">
                <label class="fw-bold mb-2" for="etiqueta">Etiqueta</label>
                <input type="text" name="etiqueta" class="form-control" id="etiqueta" value="{{ old('etiqueta') }}">
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="descripcion">Descripción</label>
                <input type="text" name="descripcion" class="form-control" id="descripcion" value="{{ old('descripcion') }}">
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="marca">Marca</label>
                <input type="text" name="marca" class="form-control" id="marca" value="{{ old('marca') }}">
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="modelo">Modelo</label>
                <input type="text" name="modelo" class="form-control" id="modelo" value="{{ old('modelo') }}">
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="numero_serie">Número de serie</label>
                <input type="text" name="numero_serie" class="form-control" id="numero_serie" value="{{ old('numero_serie') }}">
            </div>

            <div class="form-group mb-5">
                <label class="fw-bold mb-2" for="caracteristicas">Características</label>
                <textarea name="caracteristicas" class="form-control" id="caracteristicas">{{ old('caracteristicas') }}</textarea>
            </div>

            <div class="d-flex justify-content-between mb-3">
                <button type="submit" class="btn btn-success">Guardar Material</button>
                <a href="{{ route('aulas.show', $aula->id) }}" class="btn btn-primary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection