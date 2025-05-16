<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Equipo</title>
    <!-- Enlace a Bootstrap 4 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Crear Nuevo Equipo</h2>

        <form action="{{ route('equipos.store', $aula_id) }}" method="POST">
            @csrf

            <!-- Campo oculto para el aula_id -->
            <input type="hidden" name="aula_id" value="{{ $aula_id }}">

            <div class="form-group mb-2">
                <label for="etiqueta_cpu">Etiqueta CPU:</label>
                <input type="text" class="form-control" name="etiqueta_cpu">
            </div>

            <div class="form-group mb-2">
                <label for="marca_cpu">Marca CPU:</label>
                <input type="text" class="form-control" name="marca_cpu">
            </div>

            <div class="form-group mb-2">
                <label for="modelo_cpu">Modelo CPU:</label>
                <input type="text" class="form-control" name="modelo_cpu">
            </div>

            <div class="form-group mb-2">
                <label for="numero_serie_cpu">Número de serie CPU:</label>
                <input type="text" class="form-control" name="numero_serie_cpu">
            </div>

            <div class="form-group mb-2">
                <label for="tipo_cpu">Tipo CPU:</label>
                <input type="text" class="form-control" name="tipo_cpu">
            </div>

            <div class="form-group mb-2">
                <label for="memoria">Memoria:</label>
                <input type="text" class="form-control" name="memoria">
            </div>

            <div class="form-group mb-2">
                <label for="disco_duro">Disco Duro:</label>
                <input type="text" class="form-control" name="disco_duro">
            </div>

            <div class="form-group mb-2">
                <label for="conectores_video">Conectores Video:</label>
                <input type="text" class="form-control" name="conectores_video">
            </div>

            <div class="form-group mb-2">
                <label for="etiqueta_monitor">Etiqueta Monitor:</label>
                <input type="text" class="form-control" name="etiqueta_monitor">
            </div>

            <div class="form-group mb-2">
                <label for="marca_monitor">Marca Monitor:</label>
                <input type="text" class="form-control" name="marca_monitor">
            </div>

            <div class="form-group mb-2">
                <label for="modelo_monitor">Modelo Monitor:</label>
                <input type="text" class="form-control" name="modelo_monitor">
            </div>

            <div class="form-group mb-2">
                <label for="conectores_monitor">Conectores Monitor:</label>
                <input type="text" class="form-control" name="conectores_monitor">
            </div>

            <div class="form-group mb-2">
                <label for="pulgadas">Pulgadas:</label>
                <input type="number" class="form-control" name="pulgadas">
            </div>

            <div class="form-group mb-2">
                <label for="numero_serie_monitor">Número de serie Monitor:</label>
                <input type="text" class="form-control" name="numero_serie_monitor">
            </div>

            <div class="form-group mb-2">
                <label for="etiqueta_teclado">Etiqueta Teclado:</label>
                <input type="text" class="form-control" name="etiqueta_teclado">
            </div>

            <div class="form-group mb-3">
                <label for="etiqueta_raton">Etiqueta Ratón:</label>
                <input type="text" class="form-control" name="etiqueta_raton">
            </div>

            <div class="form-group mb-4">
                <label for="observaciones">Observaciones:</label>
                <textarea class="form-control" name="observaciones"></textarea>
            </div>

            <div class="form-group mb-3">
                <label class="fw-bold" for="numero_inventario">Número de Inventario:</label>
                <input type="text" class="form-control" name="numero_inventario">
            </div>

            <div class="form-group mb-5">
                <button type="submit" class="btn btn-success">Crear Equipo</button>

                <a href="{{ route('aulas.show', $aula_id) }}" class="btn btn-primary">Volver al Aula</a>
            </div>
        </form>
    </div>

    <!-- Incluir Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>