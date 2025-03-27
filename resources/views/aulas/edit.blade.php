<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aula</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Editar Aula</h1>
        <form action="{{ route('aulas.update', $aula->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Nombre del Aula -->
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $aula->nombre }}" required>
            </div>
            
            <!-- Ubicación del Aula -->
            <div class="form-group">
                <label for="ubicacion">Ubicación</label>
                <input type="text" class="form-control" id="ubicacion" name="ubicacion" value="{{ $aula->ubicacion }}" required>
            </div>
            
            <!-- Descripción del Aula -->
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion">{{ $aula->descripcion }}</textarea>
            </div>
            
            <!-- Botón de Enviar -->
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('aulas.index') }}" class="btn btn-secondary ml-2">Cancelar</a>
        </form>
    </div>

    <!-- Incluir Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
