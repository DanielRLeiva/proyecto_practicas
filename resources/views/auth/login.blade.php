<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Gestion de Inventario</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Login Inventario CPIFP Alan Turing</h1>
        @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif
        
        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="form-group mb-3 w-50">
                <label for="email" class="fw-bold">Correo Electrónico</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Correo Electrónico" required>
                @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-5">
                <label for="password" class="fw-bold">Contraseña</label>
                <input type="password" class="form-control w-50" id="password" name="password" placeholder="Contraseña" required>
                @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Login</button>

            <a href="{{ route('register') }}" class="btn btn-primary ml-2">Registrarse</a>
        </form>
    </div>

    <!-- Incluir Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>