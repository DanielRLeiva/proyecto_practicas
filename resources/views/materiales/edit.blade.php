<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Material -  {{ $material->etiqueta }}</title>
    <!-- Agregar un enlace al CSS de Bootstrap para el diseño -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
</head>

<body>
    <div class="container mt-5">
        
        <h2>Editar Material - {{ $material->etiqueta }}</h2>

        <form action="{{ route('materiales.update', $material) }}" method="POST">
            @csrf
            @method('PUT') <!-- Esto es necesario para hacer un update en Laravel -->

            <div class="form-group">
                <label for="etiqueta">Etiqueta</label>
                <input type="text" name="etiqueta" class="form-control" id="etiqueta" value="{{ old('etiqueta', $material->etiqueta) }}" required>
                @error('etiqueta')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <input type="text" name="descripcion" class="form-control" id="descripcion" value="{{ old('descripcion', $material->descripcion) }}" required>
                @error('descripcion')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="marca">Marca</label>
                <input type="text" name="marca" class="form-control" id="marca" value="{{ old('marca', $material->marca) }}" required>
                @error('marca')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="modelo">Modelo</label>
                <input type="text" name="modelo" class="form-control" id="modelo" value="{{ old('modelo', $material->modelo) }}" required>
                @error('modelo')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="numero_serie">Número de serie</label>
                <input type="text" name="numero_serie" class="form-control" id="numero_serie" value="{{ old('numero_serie', $material->numero_serie) }}" required>
                @error('numero_serie')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="caracteristicas">Características</label>
                <textarea name="caracteristicas" class="form-control" id="caracteristicas">{{ old('caracteristicas', $material->caracteristicas) }}</textarea>
                @error('caracteristicas')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">Actualizar Material</button>
            </div>
            <input type="hidden" name="aula_id" value="{{ $material->aula_id }}">
        </form>

        <a href="{{ route('aulas.show', $material->aula_id) }}" class="btn btn-secondary">Volver a los detalles del aula</a>
    </div>

    <!-- Agregar un enlace a la librería de JS de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>