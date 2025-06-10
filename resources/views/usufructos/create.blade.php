@extends('layouts.app')

@section('title', 'Creación de Aulas')

@section('content')

<div class="container d-flex justify-content-center align-items-center mt-5" style="max-height: 800 px;">
    <div class="w-100 mb-5" style="max-width: 500px;">
        {{-- Título de la página --}}
        <h1 class="text-center">Asignar Nuvo Usufructo</h1>

        {{-- Línea horizontal separadora --}}
        <hr>

        {{-- Formulario para crear un nuevo usufructo --}}
        <form action="{{ route('usufructos.store') }}" method="POST">
            @csrf {{-- Protección contra CSRF --}}

            {{-- Selector de profesor --}}
            <div class="form-group mt-5 mb-4">
                <label class="fw-bold mb-2" for="profesor_id">Profesor</label>
                <select name="profesor_id" id="profesor_id" class="form-select" required>
                    <option value="">Seleccione un profesor</option>
                    {{-- Listado dinámico de profesores --}}
                    @foreach ($profesores as $profesor)
                    <option value="{{ $profesor->id }}">{{ $profesor->nombre }} {{ $profesor->apellido_1 }} {{ $profesor->apellido_2 }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Selector de portátil --}}
            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="portatil_id">Portátil</label>
                <select name="portatil_id" id="portatil_id" class="form-select" required>
                    <option value="">Seleccione un portátil</option>
                    {{-- Listado dinámico de portátiles --}}
                    @foreach ($portatiles as $portatil)
                    <option value="{{ $portatil->id }}">{{ $portatil->marca_modelo }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Fechas de inicio y fin del usufructo --}}
            <div class="mb-5">
                <div class="d-flex gap-3">
                    {{-- Fecha de inicio (requerida) --}}
                    <div class="flex-fill d-flex flex-column">
                        <label class="fw-bold mb-2" for="fecha_inicio">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
                    </div>

                    {{-- Fecha de fin (opcional) --}}
                    <div class="flex-fill d-flex flex-column">
                        <label class="fw-bold mb-2" for="fecha_fin">Fecha Fin</label>
                        <input type="date" name="fecha_fin" id="fecha_fin" class="form-control">
                    </div>
                </div>
            </div>

            {{-- Botones para enviar o cancelar --}}
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Crear Usufructo</button>

                {{-- Enlace para volver a la lista de usufructos --}}
                <a href="{{ route('usufructos.index') }}" class="btn btn-primary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

{{-- Incluir script para validación o lógica adicional de fechas --}}
@push('scripts')
<script src="{{ asset('js/fechasForm.js') }}"></script>
@endpush

@endsection