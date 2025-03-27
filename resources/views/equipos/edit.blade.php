<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Equipo - {{ $equipo->etiqueta_cpu }}</title>
    <!-- Agregar un enlace al CSS de Bootstrap para el diseño -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Editar Equipo: {{ $equipo->etiqueta_cpu }}</h2>

        <form action="{{ route('equipos.update', $equipo) }}" method="POST">
            @csrf
            @method('PUT') <!-- Esto es necesario para hacer un update en Laravel -->

            <div class="form-group mb-2">
                <label for="etiqueta_cpu">Etiqueta CPU</label>
                <input type="text" id="etiqueta_cpu" name="etiqueta_cpu" class="form-control" value="{{ old('etiqueta_cpu', $equipo->etiqueta_cpu) }}" required>
                @error('etiqueta_cpu')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-2">
                <label for="marca_cpu">Marca CPU</label>
                <input type="text" id="marca_cpu" name="marca_cpu" class="form-control" value="{{ old('marca_cpu', $equipo->marca_cpu) }}" required>
                @error('marca_cpu')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-2">
                <label for="modelo_cpu">Modelo CPU</label>
                <input type="text" id="modelo_cpu" name="modelo_cpu" class="form-control" value="{{ old('modelo_cpu', $equipo->modelo_cpu) }}" required>
                @error('modelo_cpu')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-2">
                <label for="numero_serie_cpu">Número de Serie CPU</label>
                <input type="text" id="numero_serie_cpu" name="numero_serie_cpu" class="form-control" value="{{ old('numero_serie_cpu', $equipo->numero_serie_cpu) }}" required>
                @error('numero_serie_cpu')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-2">
                <label for="tipo_cpu">Tipo CPU</label>
                <input type="text" id="tipo_cpu" name="tipo_cpu" class="form-control" value="{{ old('tipo_cpu', $equipo->tipo_cpu) }}" required>
                @error('tipo_cpu')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-2">
                <label for="memoria">Memoria</label>
                <input type="text" id="memoria" name="memoria" class="form-control" value="{{ old('memoria', $equipo->memoria) }}" required>
                @error('memoria')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-2">
                <label for="disco_duro">Disco Duro</label>
                <input type="text" id="disco_duro" name="disco_duro" class="form-control" value="{{ old('disco_duro', $equipo->disco_duro) }}" required>
                @error('disco_duro')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-2">
                <label for="conectores_video">Conectores de Vídeo</label>
                <input type="text" id="conectores_video" name="conectores_video" class="form-control" value="{{ old('conectores_video', $equipo->conectores_video) }}" required>
                @error('conectores_video')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-2">
                <label for="etiqueta_monitor">Etiqueta Monitor</label>
                <input type="text" id="etiqueta_monitor" name="etiqueta_monitor" class="form-control" value="{{ old('etiqueta_monitor', $equipo->etiqueta_monitor) }}" required>
                @error('etiqueta_monitor')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-2">
                <label for="marca_monitor">Marca Monitor</label>
                <input type="text" id="marca_monitor" name="marca_monitor" class="form-control" value="{{ old('marca_monitor', $equipo->marca_monitor) }}" required>
                @error('marca_monitor')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-2">
                <label for="modelo_monitor">Modelo Monitor</label>
                <input type="text" id="modelo_monitor" name="modelo_monitor" class="form-control" value="{{ old('modelo_monitor', $equipo->modelo_monitor) }}" required>
                @error('modelo_monitor')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-2">
                <label for="conectores_monitor">Conectores Monitor</label>
                <input type="text" id="conectores_monitor" name="conectores_monitor" class="form-control" value="{{ old('conectores_monitor', $equipo->conectores_monitor) }}" required>
                @error('conectores_monitor')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-2">
                <label for="pulgadas">Pulgadas</label>
                <input type="number" id="pulgadas" name="pulgadas" class="form-control" value="{{ old('pulgadas', $equipo->pulgadas) }}" required>
                @error('pulgadas')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-2">
                <label for="numero_serie_monitor">Número de Serie Monitor</label>
                <input type="text" id="numero_serie_monitor" name="numero_serie_monitor" class="form-control" value="{{ old('numero_serie_monitor', $equipo->numero_serie_monitor) }}" required>
                @error('numero_serie_monitor')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-2">
                <label for="etiqueta_teclado">Etiqueta Teclado</label>
                <input type="text" id="etiqueta_teclado" name="etiqueta_teclado" class="form-control" value="{{ old('etiqueta_teclado', $equipo->etiqueta_teclado) }}" required>
                @error('etiqueta_teclado')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-2">
                <label for="etiqueta_raton">Etiqueta Ratón</label>
                <input type="text" id="etiqueta_raton" name="etiqueta_raton" class="form-control" value="{{ old('etiqueta_raton', $equipo->etiqueta_raton) }}" required>
                @error('etiqueta_raton')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="observaciones">Observaciones</label>
                <textarea id="observaciones" name="observaciones" class="form-control">{{ old('observaciones', $equipo->observaciones) }}</textarea>
                @error('observaciones')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-5">
                <button type="submit" class="btn btn-primary">Actualizar Equipo</button>

                <a href="{{ route('aulas.show', $equipo->aula_id) }}" class="btn btn-secondary">Cancelar</a>
            </div>

            <input type="hidden" name="aula_id" value="{{ $equipo->aula_id }}">
        </form>
    </div>

    <!-- Agregar un enlace a la librería de JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>