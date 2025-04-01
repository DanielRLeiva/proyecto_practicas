<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Profesor</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Editar Profesor</h1>

        <!-- Mostrar mensaje de éxito -->
        @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif

        <!-- Formulario de edición del profesor -->
        <form action="{{ route('profesores.update', $profesor->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" id="nombre" value="{{ old('nombre', $profesor->nombre) }}" required>
                @error('nombre')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="apellido_1" class="form-label">Primer Apellido</label>
                <input type="text" class="form-control" name="apellido_1" id="apellido_1" value="{{ old('apellido_1', $profesor->apellido_1) }}" required>
                @error('apellido_1')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="apellido_2" class="form-label">Segundo Apellido (Opcional)</label>
                <input type="text" class="form-control" name="apellido_2" id="apellido_2" value="{{ old('apellido_2', $profesor->apellido_2) }}">
                @error('apellido_2')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Actualizar Profesor</button>
        </form>

        <!-- Botón para regresar a la lista de profesores -->
        <a href="{{ route('profesores.index') }}" class="btn btn-secondary mt-3">Volver a la lista de Profesores</a>
    </div>

    <!-- Incluir Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
