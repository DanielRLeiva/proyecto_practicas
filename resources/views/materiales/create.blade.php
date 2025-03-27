<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Material - Aula {{ $aula->nombre }}</title>
    <!-- Incluir Bootstrap desde CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h2>Crear Material - Aula: {{ $aula->nombre }}</h2>
        <p><strong>Ubicación:</strong> {{ $aula->ubicacion }}</p>
        <p><strong>Descripción:</strong> {{ $aula->descripcion }}</p>

        <!-- Mostrar mensaje de error en caso de que haya validación -->
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('materiales.store') }}" method="POST">
            @csrf
            <input type="hidden" name="aula_id" value="{{ $aula->id }}">

            <div class="form-group mb-2">
                <label for="etiqueta">Etiqueta</label>
                <input type="text" name="etiqueta" class="form-control" id="etiqueta" value="{{ old('etiqueta') }}" required>
            </div>

            <div class="form-group mb-2">
                <label for="descripcion">Descripción</label>
                <input type="text" name="descripcion" class="form-control" id="descripcion" value="{{ old('descripcion') }}" required>
            </div>

            <div class="form-group mb-2">
                <label for="marca">Marca</label>
                <input type="text" name="marca" class="form-control" id="marca" value="{{ old('marca') }}" required>
            </div>

            <div class="form-group mb-2">
                <label for="modelo">Modelo</label>
                <input type="text" name="modelo" class="form-control" id="modelo" value="{{ old('modelo') }}" required>
            </div>

            <div class="form-group mb-2">
                <label for="numero_serie">Número de serie</label>
                <input type="text" name="numero_serie" class="form-control" id="numero_serie" value="{{ old('numero_serie') }}" required>
            </div>

            <div class="form-group mb-4">
                <label for="caracteristicas">Características</label>
                <textarea name="caracteristicas" class="form-control" id="caracteristicas">{{ old('caracteristicas') }}</textarea>
            </div>

            <div class="form-group mb-4">
                <button type="submit" class="btn btn-success">Guardar Material</button>
                <a href="{{ route('aulas.show', $aula->id) }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <!-- Incluir jQuery completo y Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>