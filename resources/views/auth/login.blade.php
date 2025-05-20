@extends('layouts.app')

@section('title', 'Login Gestión de Inventario')

@section('content')

<div class="container d-flex justify-content-center align-items-center mt-5" style="max-height: 800 px;">
    <div class="w-100 mb-5" style="max-width: 500px;">
        <h1 class="text-center mb-5">Login CPIFP Alan Turing</h1>

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="email" class="fw-bold mb-2">Correo Electrónico</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Correo Electrónico" required>
                @error('email')
                <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-5">
                <label for="password" class="fw-bold mb-2">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                @error('password')
                <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Login</button>
                <a href="{{ route('register') }}" class="btn btn-primary">Registrarse</a>
            </div>
        </form>
    </div>
</div>

@endsection