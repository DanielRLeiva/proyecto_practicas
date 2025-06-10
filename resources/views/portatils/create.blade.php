@extends('layouts.app')

@section('title', 'Creación de Aulas')

@section('content')

<div class="container d-flex justify-content-center align-items-center mt-5" style="max-height: 800px;">
    <div class="w-100 mb-5" style="max-width: 500px;">
        {{-- Título de la página --}}
        <h1 class="text-center mb-5">Nuevo Portátil</h1>

        {{-- Línea horizontal separadora --}}
        <hr>

        {{-- Formulario para crear un nuevo portátil --}}
        <form action="{{ route('portatils.store') }}" method="POST">
            @csrf {{-- Token CSRF para seguridad --}}

            {{-- Campo Marca y Modelo --}}
            <div class="form-group mt-5 mb-4">
                <label class="fw-bold mb-2" for="marca_modelo">Marca y Modelo</label>
                <input type="text" class="form-control" name="marca_modelo" id="marca_modelo" value="{{ old('marca_modelo') }}" required>
            </div>

            {{-- Campo Comentarios --}}
            <div class="form-group mb-5">
                <label class="fw-bold mb-2" for="comentarios">Comentarios</label>
                <textarea class="form-control" name="comentarios" id="comentarios">{{ old('comentarios') }}</textarea>
            </div>

            {{-- Botones Crear y Cancelar --}}
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Crear Portátil</button>
                <a href="{{ route('portatils.index') }}" class="btn btn-primary ml-2">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection
