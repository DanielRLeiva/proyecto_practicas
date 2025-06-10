@extends('layouts.app')

@section('title', 'Edición de Aulas')

@section('content')

<div class="container d-flex justify-content-center align-items-center mt-5" style="max-height: 800 px;">
    <div class="w-100 mb-5" style="max-width: 500px;">
        {{-- Título con el nombre del aula que se está editando --}}
        <h1 class="text-center">Editar Aula {{ $aula->nombre }}</h1>

        <hr>

        <form action="{{ route('aulas.update', $aula->id) }}" method="POST">
            @csrf {{-- Protección contra ataques CSRF --}}
            @method('PUT') {{-- Indica que este formulario enviará una petición PUT --}}

            {{-- Campo para editar el nombre del aula, con valor prellenado --}}
            <div class="form-group mt-5 mb-4">
                <label class="fw-bold mb-2" for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $aula->nombre }}" required>
            </div>

            {{-- Campo para editar la ubicación del aula, con valor prellenado --}}
            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="ubicacion">Ubicación</label>
                <input type="text" class="form-control" id="ubicacion" name="ubicacion" value="{{ $aula->ubicacion }}" required>
            </div>

            {{-- Campo para editar la descripción del aula, con valor prellenado --}}
            <div class="form-group mb-5">
                <label class="fw-bold mb-2" for="descripcion">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion">{{ $aula->descripcion }}</textarea>
            </div>

            {{-- Botones para actualizar o cancelar la edición --}}
            <div class="d-flex justify-content-between mb-3">
                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('aulas.index') }}" class="btn btn-primary ml-2">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection