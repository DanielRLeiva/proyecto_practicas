@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')

<div class="container d-flex justify-content-center align-items-center mt-5" style="max-height: 800 px;">
    <div class="w-100 mb-5" style="max-width: 500px;">
        <h2 class="text-center">Editar Usuario</h2>

        <hr>
        </hr>

        <form action="{{ route('users.update', $user->id) }}" method="POST" class="row g-3">
            @csrf
            @method('PUT')

            <div class="form-group mt-5 mb-3">
                <label for="name" class="fw-bold mb-2">Nombre</label>
                <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="name" class="fw-bold mb-2">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
            </div>

            <div class="form-group mb-5">
                <label for="name" class="fw-bold mb-2">Rol</label>
                <select name="role" class="form-select" required>
                    @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('users.index') }}" class="btn btn-primary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection