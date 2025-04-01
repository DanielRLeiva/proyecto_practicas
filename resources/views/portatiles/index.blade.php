<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Portátiles</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Portátiles</h1>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('portatiles.create') }}" class="btn btn-primary mb-3">Nuevo Portatil</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Marca y Modelo</th>
                    <th>Comentarios</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($portatiles as $portatil)
                <tr>
                    <td>{{ $portatil->marca_modelo }}</td>
                    <td>{{ $portatil->comentarios }}</td>
                    <td>
                        <a href="{{ route('portatiles.edit', $portatil->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('portatiles.destroy', $portatil->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Eliminar portatil?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('usufructos.index') }}" class="btn btn-secondary mb-5">Volver a la lista de Usufructos</a>
    </div>
    <!-- Incluir Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>