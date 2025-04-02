<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Crear Profesor</h1>

        <form action="{{ route('profesores.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" required>
            </div>

            <div class="mb-3">
                <label for="apellido_1" class="form-label">Primer Apellido</label>
                <input type="text" class="form-control" name="apellido_1" required>
            </div>

            <div class="mb-3">
                <label for="apellido_2" class="form-label">Segundo Apellido (Opcional)</label>
                <input type="text" class="form-control" name="apellido_2">
            </div>

            <button type="submit" class="btn btn-success">Guardar Profesor</button>
        </form>

        <a href="{{ route('profesores.index') }}" class="btn btn-primary mt-3">Volver a la lista de Profesores</a>
    </div>
    <!-- Incluir Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>