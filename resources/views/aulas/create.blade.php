@extends('layouts.app')

@section('title', 'Creación de Aulas')

@section('content')

<div class="container d-flex justify-content-center align-items-center mt-5" style="max-height: 800 px;">
    <div class="w-100 mb-5" style="max-width: 500px;">
        <h1 class="text-center">Crear Nueva Aula</h1>

        <hr>
        </hr>

        <form action="{{ route('aulas.store') }}" method="POST">
            @csrf

            <!-- Nombre del Aula -->
            <div class="form-group mt-5 mb-4">
                <label class="fw-bold mb-2" for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>

            <!-- Ubicación del Aula -->
            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="ubicacion">Ubicación</label>
                <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
            </div>

            <!-- Descripción del Aula -->
            <div class="form-group mb-5">
                <label class="fw-bold mb-2" for="descripcion">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
            </div>

            <!-- Botónes -->
            <div class="d-flex justify-content-between mb-3">
                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="{{ route('aulas.index') }}" class="btn btn-primary ml-2">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection