@extends('layouts.app')

@section('title', 'Nuevo Profesor')

@section('content')

<div class="container d-flex justify-content-center align-items-center mt-5" style="max-height: 800px;">
    <div class="w-100 mb-5" style="max-width: 500px;">
        {{-- Título de la página --}}
        <h1 class="text-center">Crear Nuevo Profesor</h1>

        {{-- Línea horizontal separadora --}}
        <hr>

        {{-- Formulario para crear un nuevo profesor --}}
        <form action="{{ route('profesors.store') }}" method="POST">
            @csrf

            <div class="form-group mt-5 mb-4">
                <label class="fw-bold mb-2" for="nombre">Nombre</label>
                <input type="text" class="form-control" name="nombre" id="nombre" required>
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="apellido_1">Primer Apellido</label>
                <input type="text" class="form-control" name="apellido_1" id="apellido_1" required>
            </div>

            <div class="form-group mb-5">
                <label class="fw-bold mb-2" for="apellido_2">Segundo Apellido (Opcional)</label>
                <input type="text" class="form-control" name="apellido_2" id="apellido_2">
            </div>

            {{-- Botones para enviar o cancelar --}}
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Guardar Profesor</button>
                <a href="{{ route('profesors.index') }}" class="btn btn-primary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection
