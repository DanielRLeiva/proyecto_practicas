<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aula</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Editar Aula</h1>
        <form action="{{ route('aulas.update', $aula->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nombre del Aula -->
            <div class="form-group mb-2">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $aula->nombre }}" required>
            </div>

            <!-- Ubicación del Aula -->
            <div class="form-group mb-2">
                <label for="ubicacion">Ubicación</label>
                <input type="text" class="form-control" id="ubicacion" name="ubicacion" value="{{ $aula->ubicacion }}" required>
            </div>

            <!-- Descripción del Aula -->
            <div class="form-group mb-4">
                <label for="descripcion">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion">{{ $aula->descripcion }}</textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('aulas.index') }}" class="btn btn-primary ml-2">Cancelar</a>
            </div>
        </form>
    </div>

    <!-- Incluir Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>