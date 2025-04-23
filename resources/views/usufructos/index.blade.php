<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Préstamos Activos de Portátiles</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5 mb-5">
        <div class="d-flex justify-content-between">
            <div class="mb-4">
                <h1>Usufructo de Portátiles</h1>
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

        <!-- Mostrar mensaje de éxito -->
        @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif

        <!-- Botones de navegación -->
        <div class="mb-3">
            <a href="{{ route('profesors.index') }}" class="btn btn-primary">Profesores</a>
            <a href="{{ route('portatils.index') }}" class="btn btn-primary">Portátiles</a>
        </div>

        <hr>

        <!-- Botón para asignar un nuevo usufructo -->
        @role('admin|editor')
        <a href="{{ route('usufructos.create') }}" class="btn btn-success mb-3">Asignar Nuevo Usufructo</a>
        @endrole

        <!-- Tabla de usufructos (préstamos activos) -->
        <h2>Préstamos Activos</h2>
        @if($usufructosActivos->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>Profesor</th>
                        <th>Portátil</th>
                        <th>Comentarios</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        @role('admin|editor')
                        <th>Acciones</th>
                        @endrole
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usufructosActivos as $usufructo)
                    <tr>
                        <td>{{ $usufructo->profesor->nombre }} {{ $usufructo->profesor->apellido_1 }} {{ $usufructo->profesor->apellido_2 }}</td>
                        <td>{{ $usufructo->portatil->marca_modelo }}</td>
                        <td>{{ $usufructo->portatil->comentarios }}</td>
                        <td>{{ \Carbon\Carbon::parse($usufructo->fecha_inicio)->format('d-m-Y') }}</td>
                        <td>{{ $usufructo->fecha_fin ?? 'En uso' }}</td>
                        @role('admin|editor')
                        <td>
                            <a href="{{ route('usufructos.edit', $usufructo->id) }}" class="btn btn-warning">Finalizar</a>
                        </td>
                        @endrole
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p>No hay usufructos activos.</p>
        @endif

        <hr>

        <!-- Tabla de historial de usufructos (préstamos finalizados) -->
        <h2>Historial de Préstamos</h2>

        @if($usufructosFinalizados->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>Profesor</th>
                        <th>Portátil</th>
                        <th>Comentarios</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        @role('admin')
                        <th>Acciones</th>
                        @endrole
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usufructosFinalizados as $usufructo)
                    <tr>
                        <td>{{ $usufructo->profesor->nombre }} {{ $usufructo->profesor->apellido_1 }} {{ $usufructo->profesor->apellido_2 }}</td>
                        <td>{{ $usufructo->portatil->marca_modelo }}</td>
                        <td>{{ $usufructo->portatil->comentarios }}</td>
                        <td>{{ \Carbon\Carbon::parse($usufructo->fecha_inicio)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($usufructo->fecha_fin)->format('d-m-Y') }}</td>
                        
                        @role('admin')
                        <td>
                            <form action="{{ route('usufructos.destroy', $usufructo->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Eliminar usufructo?')">Eliminar</button>
                            </form>
                            @endrole
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p>No hay historial de usufructos.</p>
        @endif

        <a href="{{ route('aulas.index') }}" class="btn btn-primary mt-3">Volver a la lista de Aulas</a>
    </div>

    <!-- Incluir Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>