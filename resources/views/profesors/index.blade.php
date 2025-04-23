<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Profesores</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between">
            <div class="mb-4">
                <h1>Profesores</h1>
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
        <a href="{{ route('profesors.create') }}" class="btn btn-success mb-3">Nuevo Profesor</a>
        @endrole

        <table class="table table-bordered table-striped mb-5">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido 1</th>
                    <th>Apellido 2</th>
                    <th>Estado</th>
                    @role('admin|editor')
                    <th>Acciones</th>
                    @endrole
                </tr>
            </thead>
            <tbody>
                @foreach ($profesores as $profesor)
                <tr class="{{ $profesor->activo }}">
                    <td>{{ $profesor->nombre }}</td>
                    <td>{{ $profesor->apellido_1 }}</td>
                    <td>{{ $profesor->apellido_2 }}</td>
                    <td>
                        @if($profesor->activo)
                        <span class="badge bg-success">Activo</span>
                        @else
                        <span class="badge bg-secondary">Inactivo</span>
                        @endif
                    </td>

                    @role('admin|editor')
                    <td>
                        @if($profesor->activo)
                        <a href="{{ route('profesors.edit', $profesor->id) }}" class="btn btn-warning btn-sm">Editar</a>

                        <form action="{{ route('profesors.destroy', $profesor->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Desactivar profesor?')">Dar de Baja</button>
                        </form>
                        @else
                        <form action="{{ route('profesors.activar', $profesor->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')

                            <button type="submit" class="btn btn-success btn-sm"
                                onclick="return confirm('¿Activar profesor?')">Dar de Alta</button>
                        </form>
                        @endif
                    </td>
                    @endrole
                </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('usufructos.index') }}" class="btn btn-primary mb-5">Volver a la lista de Usufructos</a>
    </div>
    <!-- Incluir Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>