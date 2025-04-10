<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $aula->nombre }} - Detalles</title>
    <!-- Incluir Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between">
            <div>
                <h2>{{ $aula->nombre }}</h2>
                <p><strong>Ubicación:</strong> {{ $aula->ubicacion }}</p>
                <p class="mb-4"><strong>Descripción:</strong> {{ $aula->descripcion }}</p>
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

        <hr>

        <h3>Equipos</h3>

        @role('admin|editor')
        <a href="{{ route('equipos.create', $aula->id) }}" class="btn btn-success mb-3">Crear equipo</a>
        @endrole

        @if($aula->equipos->isEmpty())
        <p>No hay equipos registrados para esta aula.</p>
        @else

        <div class="table-responsive mb-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Etiqueta CPU</th>
                        <th>Marca CPU</th>
                        <th>Modelo CPU</th>
                        <th>Nº de serie CPU</th>
                        <th>Tipo CPU</th>
                        <th>Memoria</th>
                        <th>Disco Duro</th>
                        <th>Conectores de Vídeo</th>
                        <th>Etiqueta Monitor</th>
                        <th>Marca Monitor</th>
                        <th>Modelo Monitor</th>
                        <th>Conectores Monitor</th>
                        <th>Pulgadas</th>
                        <th>Nº de serie Monitor</th>
                        <th>Etiqueta Teclado</th>
                        <th>Etiqueta Ratón</th>
                        <th>Observaciones</th>
                        @role('admin|editor')
                        <th>Acciones</th>
                        @endrole
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
                        @role('admin|editor')
                        <td>
                            <a href="{{ route('equipos.edit', ['equipo' => $equipo->id, 'aula_id' => $aula->id]) }}" class="btn btn-warning">Editar</a>

                            @role('admin')
                            <form action="{{ route('equipos.destroy', $equipo->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este equipo?')">Eliminar</button>
                            </form>
                            @endrole
                        </td>
                        @endrole
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @endif

        <hr>

        <h3>Materiales</h3>

        @role('admin|editor')
        <a href="{{ route('materials.create', $aula->id) }}" class="btn btn-success mb-3">Crear material</a>
        @endrole

        @if($aula->materiales->isEmpty())
        <p>No hay materiales registrados para esta aula.</p>
        @else
        <div class="table-responsive mb-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Etiqueta</th>
                        <th>Descripción</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Nº de serie</th>
                        <th>Características</th>
                        @role('admin|editor')
                        <th>Acciones</th>
                        @endrole
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
                        @role('admin|editor')
                        <td>
                            <a href="{{ route('materials.edit', ['material' => $material->id, 'aula_id' => $aula->id]) }}" class="btn btn-warning">Editar</a>

                            @role('admin')
                            <form action="{{ route('materials.destroy', $material->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este material?')">Eliminar</button>
                            </form>
                            @endrole
                        </td>
                        @endrole
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @endif

        <a href="{{ route('aulas.index') }}" class="btn btn-primary mb-5">Volver a la lista de aulas</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>