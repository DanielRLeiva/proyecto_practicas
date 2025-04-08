<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Aula</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Crear Registro</h1>

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Errores encontrados:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <label for="name" class="fw-bold">Nombre</label>
                <input type="text" class="form-control w-50" id="name" name="name" placeholder="Nombre" required>
                @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="email" class="fw-bold">Correo Electrónico</label>
                <input type="text" class="form-control w-50" id="email" name="email" placeholder="Correo Electrónico" required>
                @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="password" class="fw-bold">Contraseña</label>
                <input type="password" class="form-control w-50" id="password" name="password" placeholder="Contraseña" required>
                @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-5">
                <label for="password_confirmation" class="fw-bold">Confirmar Contraseña</label>
                <input type="password" class="form-control w-50" id="password_confirmation" name="password_confirmation" placeholder="Confirmar Contraseña" required>
            </div>

            <button type="submit" class="btn btn-success">Registro</button>

            <a href="{{ route('login') }}" class="btn btn-primary ml-2">Volver al Login</a>
        </form>
    </div>

    <!-- Incluir Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>