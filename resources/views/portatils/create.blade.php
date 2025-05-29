@extends('layouts.app')

@section('title', 'Creación de Aulas')

@section('content')

<div class="container d-flex justify-content-center align-items-center mt-5" style="max-height: 800 px;">
    <div class="w-100 mb-5" style="max-width: 500px;">
        <h1 class="text-center mb-5">Nuevo Portátil</h1>

        <hr>
        </hr>

        <!-- Formulario para crear un portátil -->
        <form action="{{ route('portatils.store') }}" method="POST">
            @csrf

            <div class="form-group mt-5 mb-4">
                <label class="fw-bold mb-2" for="marca_modelo">Marca y Modelo</label>
                <input type="text" class="form-control" name="marca_modelo" id="marca_modelo" value="{{ old('marca_modelo') }}" required>
            </div>

            <div class="form-group mb-5">
                <label class="fw-bold mb-2" for="comentarios">Comentarios</label>
                <textarea class="form-control" name="comentarios" id="comentarios">{{ old('comentarios') }}</textarea>
            </div>

            <!-- Botónes -->
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Crear Portátil</button>
                <a href="{{ route('portatils.index') }}" class="btn btn-primary ml-2">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection