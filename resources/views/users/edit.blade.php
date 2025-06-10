@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')

<div class="container d-flex justify-content-center align-items-center mt-5" style="max-height: 800px;">
    <div class="w-100 mb-5" style="max-width: 500px;">
        {{-- Título que muestra el nombre del usuario --}}
        <h1 class="text-center">Editar Usuario {{ $user->name }}</h1>

        {{-- Línea horizontal separadora --}}
        <hr>

        {{-- Formulario para actualizar los datos del usuario --}}
        <form action="{{ route('users.update', $user->id) }}" method="POST" class="row g-3">
            @csrf {{-- Protección contra CSRF --}}
            @method('PUT') {{-- Usar método PUT para actualización --}}

            {{-- Campo para el nombre --}}
            <div class="form-group mt-5 mb-3">
                <label for="name" class="fw-bold mb-2">Nombre</label>
                <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
            </div>

            {{-- Campo para el email --}}
            <div class="form-group mb-3">
                <label for="email" class="fw-bold mb-2">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
            </div>

            {{-- Selector para el rol --}}
            <div class="form-group mb-5">
                <label for="role" class="fw-bold mb-2">Rol</label>
                <select name="role" class="form-select" required>
                    {{-- Listar roles y seleccionar el actual --}}
                    @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Botones para enviar o cancelar --}}
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('users.index') }}" class="btn btn-primary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection