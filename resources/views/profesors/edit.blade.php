@extends('layouts.app')

@section('title', 'Creación de Aulas')

@section('content')

<div class="container d-flex justify-content-center align-items-center mt-5" style="max-height: 800px;">
    <div class="w-100 mb-5" style="max-width: 500px;">
        {{-- Título con el nombre del profesor --}}
        <h1 class="text-center mb-5">Editar Profesor {{ $profesor->nombre }}</h1>

        {{-- Línea horizontal separadora --}}
        <hr>

        {{-- Formulario para editar un profesor --}}
        <form action="{{ route('profesors.update', $profesor->id) }}" method="POST">
            @csrf {{-- Protección contra CSRF --}}
            @method('PUT') {{-- Método PUT para actualización en Laravel --}}

            <div class="form-group mt-5 mb-4">
                <label class="fw-bold mb-2" for="nombre">Nombre</label>
                <input type="text" class="form-control" name="nombre" id="nombre" value="{{ old('nombre', $profesor->nombre) }}" required>
                @error('nombre')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="apellido_1">Primer Apellido</label>
                <input type="text" class="form-control" name="apellido_1" id="apellido_1" value="{{ old('apellido_1', $profesor->apellido_1) }}" required>
                @error('apellido_1')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-5">
                <label class="fw-bold mb-2" for="apellido_2">Segundo Apellido (Opcional)</label>
                <input type="text" class="form-control" name="apellido_2" id="apellido_2" value="{{ old('apellido_2', $profesor->apellido_2) }}">
                @error('apellido_2')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Botones para enviar el formulario o cancelar --}}
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('profesors.index') }}" class="btn btn-primary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection
