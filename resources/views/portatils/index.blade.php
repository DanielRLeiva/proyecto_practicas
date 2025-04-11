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
    <div class="container mt-5">
        <div class="d-flex justify-content-between">
            <div class="mb-4">
                <h1>Portátiles</h1>
                <span class="navbar-text">
                    Bienvenido, {{ Auth::user()->name }}
                </span>
            </div>

            <!-- Botón Logout -->
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger mb-3">Cerrar sesión</button>
            </form>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        @role('admin|editor')
        <a href="{{ route('portatils.create') }}" class="btn btn-success mb-3">Nuevo Portatil</a>
        @endrole

        <div class="table-responsive mb-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Marca y Modelo</th>
                        <th>Comentarios</th>
                        @role('admin|editor')
                        <th>Acciones</th>
                        @endrole
                    </tr>
                </thead>
                <tbody>
                    @foreach ($portatiles as $portatil)
                    <tr>
                        <td>{{ $portatil->marca_modelo }}</td>
                        <td>{{ $portatil->comentarios }}</td>
                        @role('admin|editor')
                        <td>
                            <a href="{{ route('portatils.edit', $portatil->id) }}" class="btn btn-warning">Editar</a>
                            @endrole
                            @role('admin')
                            <form action="{{ route('portatils.destroy', $portatil->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Eliminar portatil?')">Eliminar</button>
                            </form>
                        </td>
                        @endrole
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <a href="{{ route('usufructos.index') }}" class="btn btn-primary mb-5">Volver a la lista de Usufructos</a>
    </div>

    <!-- Incluir Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>