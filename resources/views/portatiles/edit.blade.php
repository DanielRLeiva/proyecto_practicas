<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Portátil</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Editar Portátil</h1>

        <!-- Mostrar errores de validación -->
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Formulario para editar un portátil -->
        <form action="{{ route('portatiles.update', $portatil->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="marca_modelo" class="form-label">Marca y Modelo</label>
                <input type="text" class="form-control" name="marca_modelo" id="marca_modelo" value="{{ old('marca_modelo', $portatil->marca_modelo) }}" required>
            </div>

            <div class="mb-3">
                <label for="comentarios" class="form-label">Comentarios</label>
                <textarea class="form-control" name="comentarios" id="comentarios">{{ old('comentarios', $portatil->comentarios) }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">Actualizar Portátil</button>
        </form>

        <a href="{{ route('portatiles.index') }}" class="btn btn-secondary mt-3">Volver a la lista de Portátiles</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
