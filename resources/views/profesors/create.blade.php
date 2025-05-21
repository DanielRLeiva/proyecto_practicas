@extends('layouts.app')

@section('title', 'Creación de Aulas')

@section('content')

<div class="container d-flex justify-content-center align-items-center mt-5" style="max-height: 800 px;">
    <div class="w-100 mb-5" style="max-width: 500px;">
        <h1 class="text-center mb-5">Crear Profesor</h1>

        <form action="{{ route('profesors.store') }}" method="POST">
            @csrf
            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="nombre">Nombre</label>
                <input type="text" class="form-control" name="nombre" required>
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="apellido_1">Primer Apellido</label>
                <input type="text" class="form-control" name="apellido_1" required>
            </div>

            <div class="form-group mb-5">
                <label class="fw-bold mb-2" for="apellido_2">Segundo Apellido (Opcional)</label>
                <input type="text" class="form-control" name="apellido_2">
            </div>

            <!-- Botónes -->
            <div class="d-flex justify-content-between mb-5">
                <button type="submit" class="btn btn-success">Guardar Profesor</button>
                <a href="{{ route('profesors.index') }}" class="btn btn-primary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection