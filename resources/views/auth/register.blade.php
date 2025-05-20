@extends('layouts.app')

@section('title', 'Registro de Usuarios')

@section('content')

<div class="container d-flex justify-content-center align-items-center mt-5">
    <div class="w-100 mb-5" style="max-width: 500px;">
        <h1 class="text-center mb-5">Registro CPIFP Alan Turing</h1>

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="fw-bold mb-2">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nombre" required>
                @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="fw-bold mb-2"">Correo Electrónico</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Correo Electrónico" required>
                @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="fw-bold mb-2"">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-5">
                <label for="password_confirmation" class="fw-bold mb-2"">Confirmar Contraseña</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirmar Contraseña" required>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Registro</button>

                <a href="{{ route('login') }}" class="btn btn-primary ml-2">Volver al Login</a>
            </div>
        </form>
    </div>
</div>

@endsection