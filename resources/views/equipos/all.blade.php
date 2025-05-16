<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Todos los Equipos</title>
    <!-- Agregar un enlace al CSS de Bootstrap para el diseño -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-3">
            <div class="mb-3">
                <h1>Todos los Equipos</h1>
                <span class="navbar-text">
                    Bienvenido, {{ Auth::user()->name }}
                </span>
            </div>

            <div>
                <!-- Botón Logout -->
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger mb-3">Cerrar sesión</button>
                </form>
            </div>
        </div>

        <hr>
        </hr>

        <h3 class="mb-3">Filtrar Equipos</h3>

        <!-- Botón para mostrar/ocultar el formulario -->
        <button type="button" class="btn btn-info mb-4" id="toggleFilterForm">Desplegar Filtrado</button>

        <!-- Formulario de filtrado -->
        <form method="GET" action="{{ route('equipos.all') }}" class="mb-5" id="filterForm" style="display: none;">

            <!-- Registros por página -->
            <div class="mb-3">
                <label class="fw-bold" for="per_page" class="form-label">Registros por página</label>
                <select name="per_page" id="per_page" class="form-select">
                    @foreach([10, 20, 30, 50] as $cantidad)
                    <option value="{{ $cantidad }}" {{ request('per_page', 5) == $cantidad ? 'selected' : '' }}>
                        {{ $cantidad }}
                    </option>
                    @endforeach
                </select>
            </div>


            <div class="row g-3 align-items-end">
                <div class="form-group mb-3">
                    <label class="fw-bold form-label" for="aula_id">Aula</label>
                    <select name="aula_id" id="aula_id" class="form-control">
                        <option value="">-- Aula --</option>
                        @foreach ($aulas as $aula)
                        <option value="{{ $aula->id }}" {{ request('aula_id') == $aula->id ? 'selected' : '' }}>
                            {{ $aula->nombre }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">

                    <label class="fw-bold form-label" for="marca_cpu">Marca de CPU</label>
                    <input type="text" name="marca_cpu" class="form-control" placeholder="Marca CPU" value="{{ request('marca_cpu') }}">
                </div>

                <div class="form-group mb-3">

                    <label class="fw-bold form-label" for="tipo_cpu">Tipo de CPU</label>
                    <input type="text" name="tipo_cpu" class="form-control" placeholder="Tipo CPU" value="{{ request('tipo_cpu') }}">
                </div>

                <div class="form-group mb-3">

                    <label class="fw-bold form-label" for="memoria">Memoria</label>
                    <input type="text" name="memoria" class="form-control" placeholder="Memoria" value="{{ request('memoria') }}">
                </div>

                <div class="form-group mb-3">

                    <label class="fw-bold form-label" for="numero_inventario">Número de Inventario</label>
                    <input type="text" name="numero_inventario" class="form-control" placeholder="N° Inventario" value="{{ request('numero_inventario') }}">
                </div>

                <div class="mb-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary mt-3">Filtrar</button>
                    <a href="{{ route('equipos.all') }}" class="btn btn-secondary mt-3">Limpiar</a>
                </div>
            </div>
        </form>

        <div class="table-responsive mb-4">

            @if($equipos->isEmpty())
            <tr>
                <td colspan="100%" class="text-center text-muted py-4">
                    No se encontraron equipos con los criterios proporcionados.
                </td>
            </tr>
            @else

            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>Aula</th>
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
                        <th>Nº de Inventario</th>
                        <th>Observaciones</th>
                        @role('admin|editor')
                        <th>Acciones</th>
                        @endrole
                    </tr>
                </thead>
                <tbody>
                    @foreach($equipos as $equipo)
                    <tr>
                        <td>{{ $equipo->aula->nombre ?? 'Sin aula' }}</td>
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
                        <td>{{ $equipo->numero_inventario }}</td>
                        <td>{{ $equipo->observaciones }}</td>
                        @role('admin|editor')
                        <td>
                            <a href="{{ route('equipos.edit', ['equipo' => $equipo->id, 'aula_id' => $equipo->aula->id ?? 0]) }}" class="btn btn-warning btn-sm">Editar</a>

                            @role('admin')
                            <form action="{{ route('equipos.destroy', $equipo->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('¿Estás seguro de eliminar este equipo?')" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                            @endrole
                        </td>
                        @endrole
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

            <div class="d-flex justify-content-center mb-5">
                {{ $equipos->links('pagination::bootstrap-4') }}
            </div>
        </div>

        <!-- Enlace para volver a la lista de aulaes -->
        <a href="{{ route('aulas.index') }}" class="btn btn-primary mb-5">Volver a la Lista de Aulas</a>
    </div>

    <!-- Script para mostrar filtro de Búsquesa -->
    <script src="{{ asset('js/filtroForm.js') }}"></script>

    <!-- Incluir Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>