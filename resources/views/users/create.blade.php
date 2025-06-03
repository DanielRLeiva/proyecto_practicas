@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')

<div class="container d-flex justify-content-center align-items-center mt-5" style="max-height: 800 px;">
    <div class="w-100 mb-5" style="max-width: 500px;">
        <h1 class="text-center">Crear un Nuevo Usuario</h1>

        <hr>
        </hr>

        <form action="{{ route('users.store') }}" method="POST" class="row g-3">
            @csrf
            <div class="form-group mt-5 mb-3">
                <label for="name" class="fw-bold mb-2">Nombre</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="name" class="fw-bold mb-2">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="name" class="fw-bold mb-2">Rol</label>
                <select name="role" class="form-select" required>
                    <option value="">Selecciona un rol</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="name" class="fw-bold mb-2">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group mb-5">
                <label for="name" class="fw-bold mb-2">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Crear</button>
                <a href="{{ route('users.index') }}" class="btn btn-primary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection