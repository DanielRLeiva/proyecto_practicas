@extends('layouts.app')

@section('title', 'Registro de Usuarios')

@section('content')

{{-- Contenedor principal centrado vertical y horizontalmente --}}
<div class="container d-flex justify-content-center align-items-center mt-5">
    <div class="w-100 mb-5" style="max-width: 550px;">
        {{-- Título del formulario de registro --}}
        <h1 class="text-center mb-5">Registro CPIFP Alan Turing</h1>

        {{-- Formulario para registrar nuevos usuarios --}}
        <form action="{{ route('register') }}" method="POST">
            {{-- Token CSRF para protección contra ataques CSRF --}}
            @csrf

            {{-- Campo para el nombre del usuario --}}
            <div class="form-group mb-3">
                <label for="name" class="fw-bold mb-2">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nombre" required>
            </div>

            {{-- Campo para el correo electrónico --}}
            <div class="form-group mb-3">
                <label for="email" class="fw-bold mb-2">Correo Electrónico</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Correo Electrónico" required>
            </div>

            {{-- Campo para la contraseña --}}
            <div class="form-group mb-3">
                <label for="password" class="fw-bold mb-2">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
            </div>

            {{-- Campo para confirmar la contraseña --}}
            <div class="form-group mb-5">
                <label for="password_confirmation" class="fw-bold mb-2">Confirmar Contraseña</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirmar Contraseña" required>
            </div>

            {{-- Botones para enviar el formulario o volver al login --}}
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Registro</button>
                <a href="{{ route('login') }}" class="btn btn-primary ml-2">Volver al Login</a>
            </div>
        </form>
    </div>
</div>

@endsection