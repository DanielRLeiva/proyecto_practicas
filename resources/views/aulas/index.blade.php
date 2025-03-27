<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aulas</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Aulas</h1>

        <!-- Mostrar mensaje de éxito -->
        @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif

        <!-- Botón para crear un nuevo aula -->
        <a href="{{ route('aulas.create') }}" class="btn btn-primary mb-3">Crear Aula</a>

        <!-- Tabla de aulas -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Ubicación</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($aulas as $aula)
                <tr>
                    <td>{{ $aula->nombre }}</td>
                    <td>{{ $aula->ubicacion }}</td>
                    <td>{{ $aula->descripcion }}</td>
                    <td>
                        <a href="{{ route('aulas.show', $aula->id) }}" class="btn btn-info">Ver Detalles</a>
                        <a href="{{ route('aulas.edit', $aula->id) }}" class="btn btn-warning">Editar</a>

                        <!-- Formulario para eliminar aula -->
                        <form action="{{ route('aulas.destroy', $aula->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta aula?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Incluir Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>