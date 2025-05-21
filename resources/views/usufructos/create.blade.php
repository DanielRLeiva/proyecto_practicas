@extends('layouts.app')

@section('title', 'Creación de Aulas')

@section('content')

<div class="container d-flex justify-content-center align-items-center mt-5" style="max-height: 800 px;">
    <div class="w-100 mb-5" style="max-width: 500px;">
        <h1 class="text-center mb-5">Asignar Usufructo</h1>

        <form action="{{ route('usufructos.store') }}" method="POST">
            @csrf

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="profesor_id">Profesor</label>
                <select name="profesor_id" id="profesor_id" class="form-select" required>
                    <option value="">Seleccione un profesor</option>
                    @foreach ($profesores as $profesor)
                    <option value="{{ $profesor->id }}">{{ $profesor->nombre }} {{ $profesor->apellido_1 }} {{ $profesor->apellido_2 }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="portatil_id">Portátil</label>
                <select name="portatil_id" id="portatil_id" class="form-select" required>
                    <option value="">Seleccione un portátil</option>
                    @foreach ($portatiles as $portatil)
                    <option value="{{ $portatil->id }}">{{ $portatil->marca_modelo }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Fecha de inicio del usufructo, Fecha de fin del usufructo (opcional) -->
            <div class="mb-5">
                <div class="d-flex gap-3">
                    <div class="flex-fill d-flex flex-column">
                        <label class="fw-bold mb-2" for="fecha_inicio" class="fw-bold">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
                    </div>

                    <div class="flex-fill d-flex flex-column">
                        <label class="fw-bold mb-2" for="fecha_fin" class="fw-bold">Fecha Fin</label>
                        <input type="date" name="fecha_fin" id="fecha_fin" class="form-control">
                    </div>
                </div>
            </div>

            <!-- Botónes -->
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Crear Usufructo</button>

                <!-- Botón para regresar a la lista de profesores -->
                <a href="{{ route('usufructos.index') }}" class="btn btn-primary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection