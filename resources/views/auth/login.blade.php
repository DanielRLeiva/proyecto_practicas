@extends('layouts.app')

@section('title', 'Login Gestión de Inventario')

@section('content')

{{-- Contenedor principal centrado vertical y horizontalmente --}}
<div class="container d-flex justify-content-center align-items-center mt-5" style="max-height: 800px;">
    <div class="w-100 mb-5" style="max-width: 550px;">
        {{-- Título del formulario de login --}}
        <h1 class="text-center mb-5">Login CPIFP Alan Turing</h1>

        {{-- Formulario para iniciar sesión --}}
        <form action="{{ route('login') }}" method="POST">
            {{-- Token CSRF para proteger contra ataques CSRF --}}
            @csrf

            {{-- Campo de correo electrónico --}}
            <div class="form-group mb-3">
                <label for="email" class="fw-bold mb-2">Correo Electrónico</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Correo Electrónico" required>
                {{-- Mostrar mensaje de error si la validación de email falla --}}
                @error('email')
                <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Campo de contraseña --}}
            <div class="form-group mb-5">
                <label for="password" class="fw-bold mb-2">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                {{-- Mostrar mensaje de error si la validación de contraseña falla --}}
                @error('password')
                <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Botones de envío y registro --}}
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Login</button>
                <a href="{{ route('register') }}" class="btn btn-primary">Registrarse</a>
            </div>
        </form>
    </div>
</div>

@endsection