<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $aula->nombre }} - Detalles</title>
    <!-- Incluir Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>{{ $aula->nombre }}</h2>
        <p><strong>Ubicación:</strong> {{ $aula->ubicacion }}</p>
        <p><strong>Descripción:</strong> {{ $aula->descripcion }}</p>

        <!-- Mostrar mensaje de éxito -->
        @if(session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <h3>Equipos</h3>
        <a href="{{ route('equipos.create', $aula->id) }}" class="btn btn-primary">Crear equipo</a>
        @if($aula->equipos->isEmpty())
        <p>No hay equipos registrados para esta aula.</p>
        @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Etiqueta CPU</th>
                    <th>Marca CPU</th>
                    <th>Modelo CPU</th>
                    <th>Número de serie CPU</th>
                    <th>Tipo CPU</th>
                    <th>Memoria</th>
                    <th>Disco Duro</th>
                    <th>Conectores de Vídeo</th>
                    <th>Etiqueta Monitor</th>
                    <th>Marca Monitor</th>
                    <th>Modelo Monitor</th>
                    <th>Conectores Monitor</th>
                    <th>Pulgadas</th>
                    <th>Número de serie Monitor</th>
                    <th>Etiqueta Teclado</th>
                    <th>Etiqueta Ratón</th>
                    <th>Observaciones</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($aula->equipos as $equipo)
                <tr>
                    <td>{{ $equipo->etiqueta_cpu }}</td>
                    <td>{{ $equipo->marca_cpu }}</td>
                    <td>{{ $equipo->modelo_cpu }}</td>
                    <td>{{ $equipo->numero_serie_cpu }}</td>
                    <td>{{ $equipo->tipo_cpu }}</td>
                    <td>{{ $equipo->memoria }}</td>
                    <td>{{ $equipo->disco_duro }}</td>
                    <td>{{ $equipo->conectores_video }}</td>
                    <td>{{ $equipo->etiqueta_monitor }}</td>
                    <td>{{ $equipo->marca_monitor }}</td>
                    <td>{{ $equipo->modelo_monitor }}</td>
                    <td>{{ $equipo->conectores_monitor }}</td>
                    <td>{{ $equipo->pulgadas }}</td>
                    <td>{{ $equipo->numero_serie_monitor }}</td>
                    <td>{{ $equipo->etiqueta_teclado }}</td>
                    <td>{{ $equipo->etiqueta_raton }}</td>
                    <td>{{ $equipo->observaciones }}</td>
                    <td>
                        <a href="{{ route('equipos.edit', ['equipo' => $equipo->id, 'aula_id' => $aula->id]) }}" class="btn btn-warning">Editar</a>

                        <form action="{{ route('equipos.destroy', $equipo->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este equipo?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <h3>Materiales</h3>
        <a href="{{ route('materiales.create', $aula->id) }}" class="btn btn-primary mb-3">Crear material</a>

        @if($aula->materiales->isEmpty())
        <p>No hay materiales registrados para esta aula.</p>
        @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Etiqueta</th>
                    <th>Descripción</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Número de serie</th>
                    <th>Características</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($aula->materiales as $material)
                <tr>
                    <td>{{ $material->etiqueta }}</td>
                    <td>{{ $material->descripcion }}</td>
                    <td>{{ $material->marca }}</td>
                    <td>{{ $material->modelo }}</td>
                    <td>{{ $material->numero_serie }}</td>
                    <td>{{ $material->caracteristicas }}</td>
                    <td>
                        <a href="{{ route('materiales.edit', ['material' => $material->id, 'aula_id' => $aula->id]) }}" class="btn btn-warning">Editar</a>

                        <form action="{{ route('materiales.destroy', $material->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este material?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <br>
        <a href="{{ route('aulas.index') }}" class="btn btn-secondary">Volver a la lista de aulas</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
