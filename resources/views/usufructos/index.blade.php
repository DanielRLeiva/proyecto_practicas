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
        <h1>Préstamos Activos de Portátiles</h1>

        <!-- Mostrar mensaje de éxito -->
        @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif

        <!-- Botones de navegación -->
        <div class="mb-3">
            <a href="{{ route('profesores.index') }}" class="btn btn-primary">Profesores</a>
            <a href="{{ route('portatiles.index') }}" class="btn btn-primary">Portátiles</a>
        </div>

        <hr>

        <!-- Botón para asignar un nuevo usufructo -->
        <a href="{{ route('usufructos.create') }}" class="btn btn-success mb-3">Asignar Nuevo Usufructo</a>

        <!-- Tabla de usufructos (préstamos activos) -->
        <h2>Préstamos Activos</h2>
        @if($usufructosActivos->count() > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Profesor</th>
                    <th>Portátil</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usufructosActivos as $usufructo)
                <tr>
                    <td>{{ $usufructo->profesor->nombre }} {{ $usufructo->profesor->apellido_1 }} {{ $usufructo->profesor->apellido_2 }}</td>
                    <td>{{ $usufructo->portatil->marca_modelo }}</td>
                    <td>{{ \Carbon\Carbon::parse($usufructo->fecha_inicio)->format('d-m-Y') }}</td>
                    <td>{{ $usufructo->fecha_fin ?? 'En uso' }}</td>
                    <td>
                        <a href="{{ route('usufructos.edit', $usufructo->id) }}" class="btn btn-warning">Finalizar</a>
                        <form action="{{ route('usufructos.destroy', $usufructo->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Eliminar usufructo?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>No hay usufructos activos.</p>
        @endif

        <hr>

        <!-- Tabla de historial de usufructos (préstamos finalizados) -->
        <h2>Historial de Préstamos</h2>

        @if($usufructosFinalizados->count() > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Profesor</th>
                    <th>Portátil</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usufructosFinalizados as $usufructo)
                <tr>
                    <td>{{ $usufructo->profesor->nombre }} {{ $usufructo->profesor->apellido_1 }} {{ $usufructo->profesor->apellido_2 }}</td>
                    <td>{{ $usufructo->portatil->marca_modelo }}</td>
                    <td>{{ \Carbon\Carbon::parse($usufructo->fecha_inicio)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($usufructo->fecha_fin)->format('d-m-Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
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
