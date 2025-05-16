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
    <div class="container mt-5 mb-5">

        <div class="d-flex justify-content-between mb-4">
            <div>
                <h1>Aulas</h1>
                <span class="navbar-text">
                    Bienvenido, {{ Auth::user()->name }}
                </span>
            </div>

            <div>
                @role('admin')
                <a href="{{ route('users.index') }}" class="btn btn-primary mb-3">
                    Administrar Usuarios
                </a>

                <a href="{{ route('auditoria.index') }}" class="btn btn-secondary mb-3">
                    Ver Auditorías
                </a>
                @endrole

                <!-- Botón Logout -->
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger mb-3">Cerrar sesión</button>
                </form>
            </div>

        </div>

        <!-- Botón es -->
        <div class="mb-4 d-flex justify-content-center gap-3 flex-wrap">
            <!-- Enlace para redirigir a usufructos -->
            <a href="{{ route('usufructos.index') }}" class="btn btn-dark">Ver Lista de Usufrutos</a>

            <!-- Enlace para redirigir a Todos los Equipos -->
            <a href="{{ route('equipos.all') }}" class="btn btn-dark">Ver Todos los Equipos</a>
        </div>

        <!-- Mostrar mensaje de éxito -->
        @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif

        <!-- Botón para crear un nuevo aula -->
        @role('admin')
        <a href="{{ route('aulas.create') }}" class="btn btn-success">Crear Aula</a>

        <hr>
        @endrole


        @if ($aulas->isEmpty())
        <p>No hay aulas registradas aún.</p>
        @else

        <!-- Tabla de aulas -->
        <table class="table table-bordered table-striped align-middle">
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
                        <a href="{{ route('aulas.show', $aula->id) }}" class="btn btn-info">Ver</a>
                        @role('admin')
                        <a href="{{ route('aulas.edit', $aula->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('aulas.destroy', $aula->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Eliminar aula?')">Eliminar</button>
                        </form>
                        @endrole
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @endif

        <hr>

        <!-- Botón para redirigir a usufructos -->
        <a href="{{ route('usufructos.index') }}" class="btn btn-primary mb-3">Ver Usufructos Activos</a>

    </div>

    <!-- Incluir Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>