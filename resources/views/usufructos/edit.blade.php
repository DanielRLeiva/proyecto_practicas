@extends('layouts.app')

@section('title', 'Creación de Aulas')

@section('content')

<div class="container d-flex justify-content-center align-items-center mt-5" style="max-height: 800 px;">
    <div class="w-100 mb-5" style="max-width: 500px;">

        {{-- Título principal del formulario --}}
        <h1 class="text-center">Editar Usufructo</h1>

        {{-- Línea separadora --}}
        <hr>

        {{-- Formulario para actualizar un usufructo existente --}}
        <form action="{{ route('usufructos.update', $usufructo->id) }}" method="POST">
            @csrf {{-- Token de seguridad contra CSRF --}}
            @method('PUT') {{-- Método HTTP para actualización --}}

            {{-- Selector de profesor con opción seleccionada según el usufructo --}}
            <div class="form-group mt-5 mb-4">
                <label class="fw-bold mb-2" for="profesor_id">Profesor</label>
                <select name="profesor_id" id="profesor_id" class="form-select" required>
                    <option value="">Seleccione un profesor</option>
                    @foreach ($profesores as $profesor)
                    <option value="{{ $profesor->id }}" {{ $profesor->id == $usufructo->profesor_id ? 'selected' : '' }}>
                        {{ $profesor->nombre }} {{ $profesor->apellido_1 }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Selector de portátil con opción seleccionada según el usufructo --}}
            <div class="form-group mb-4">
                <label class="fw-bold mb-2" for="portatil_id">Portátil</label>
                <select name="portatil_id" id="portatil_id" class="form-select" required>
                    <option value="">Seleccione un portátil</option>
                    @foreach ($portatiles as $portatil)
                    <option value="{{ $portatil->id }}" {{ $portatil->id == $usufructo->portatil_id ? 'selected' : '' }}>
                        {{ $portatil->marca_modelo }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Campos para la fecha de inicio y fin del usufructo --}}
            <div class="form-group mb-5">
                <div class="d-flex gap-3">
                    {{-- Fecha inicio con valor prellenado --}}
                    <div class="flex-fill d-flex flex-column">
                        <label class="fw-bold mb-2" for="fecha_inicio">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ $usufructo->fecha_inicio }}" required>
                    </div>

                    {{-- Fecha fin con valor prellenado --}}
                    <div class="flex-fill d-flex flex-column">
                        <label class="fw-bold mb-2" for="fecha_fin">Fecha Fin</label>
                        <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ $usufructo->fecha_fin }}" required>
                    </div>
                </div>
            </div>

            {{-- Botones para enviar formulario o cancelar --}}
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Actualizar Usufructo</button>
                <a href="{{ route('usufructos.index') }}" class="btn btn-primary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

{{-- Se incluye un script adicional para manejo o validación de fechas --}}
@push('scripts')
<script src="{{ asset('js/fechasForm.js') }}"></script>
@endpush

@endsection