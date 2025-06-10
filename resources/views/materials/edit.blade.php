@extends('layouts.app')

@section('title', 'Edición de Materiales')

@section('content')

<div class="container d-flex justify-content-center align-items-center mt-5">

    <div class="w-100 mb-5" style="max-width: 500px;">

        {{-- Título de la página mostrando la etiqueta del material --}}
        <h1 class="text-center">Editar Material {{ $material->etiqueta }}</h1>

        {{-- Línea horizontal separadora --}}
        <hr>

        {{-- Formulario para actualizar el material --}}
        <form action="{{ route('materials.update', $material) }}" method="POST">
            @csrf {{-- Token CSRF para seguridad --}}
            @method('PUT') {{-- Método PUT para actualización en Laravel --}}

            {{-- Campo Etiqueta --}}
            <div class="form-group mt-5 mb-4">
                <label class="fw-bold mb-2" for="etiqueta">Etiqueta</label>
                <input type="text" name="etiqueta" class="form-control" id="etiqueta" value="{{ old('etiqueta', $material->etiqueta) }}">
                @error('etiqueta')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Campo Descripción --}}
            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="descripcion">Descripción</label>
                <input type="text" name="descripcion" class="form-control" id="descripcion" value="{{ old('descripcion', $material->descripcion) }}">
                @error('descripcion')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Campo Marca --}}
            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="marca">Marca</label>
                <input type="text" name="marca" class="form-control" id="marca" value="{{ old('marca', $material->marca) }}">
                @error('marca')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Campo Modelo --}}
            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="modelo">Modelo</label>
                <input type="text" name="modelo" class="form-control" id="modelo" value="{{ old('modelo', $material->modelo) }}">
                @error('modelo')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Campo Número de serie --}}
            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="numero_serie">Número de serie</label>
                <input type="text" name="numero_serie" class="form-control" id="numero_serie" value="{{ old('numero_serie', $material->numero_serie) }}">
                @error('numero_serie')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Campo Características --}}
            <div class="form-group mb-5">
                <label class="fw-bold mb-2" for="caracteristicas">Características</label>
                <textarea name="caracteristicas" class="form-control" id="caracteristicas">{{ old('caracteristicas', $material->caracteristicas) }}</textarea>
                @error('caracteristicas')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Botones para actualizar o cancelar --}}
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Actualizar Material</button>
                <a href="{{ route('aulas.show', $material->aula_id) }}" class="btn btn-primary">Cancelar</a>
            </div>

            {{-- Campo oculto para mantener el aula relacionada --}}
            <input type="hidden" name="aula_id" value="{{ $material->aula_id }}">
        </form>
    </div>
</div>

@endsection
