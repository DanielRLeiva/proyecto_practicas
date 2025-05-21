@extends('layouts.app')

@section('title', 'Creación de Aulas')

@section('content')

<div class="container d-flex justify-content-center align-items-center mt-5" style="max-height: 800 px;">
    <div class="w-100 mb-5" style="max-width: 500px;">
        <h1 class="text-center mb-5">Editar Portátil</h1>

        <!-- Formulario para editar un portátil -->
        <form action="{{ route('portatils.update', $portatil->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="marca_modelo">Marca y Modelo</label>
                <input type="text" class="form-control" name="marca_modelo" id="marca_modelo" value="{{ old('marca_modelo', $portatil->marca_modelo) }}" required>
            </div>

            <div class="form-group mb-5">
                <label class="fw-bold mb-2" for="comentarios">Comentarios</label>
                <textarea class="form-control" name="comentarios" id="comentarios">{{ old('comentarios', $portatil->comentarios) }}</textarea>
            </div>


            <!-- Botónes -->
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Actualizar Portátil</button>

                <a href="{{ route('portatils.index') }}" class="btn btn-primary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection