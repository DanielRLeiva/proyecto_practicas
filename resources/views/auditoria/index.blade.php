<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditoría</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5 mb-5">

        <div class="d-flex justify-content-between mb-4">
            <div>
                <h1>Registro de Auditoría</h1>
                <span class="navbar-text">
                    Bienvenido, {{ Auth::user()->name }}
                </span>
            </div>

            <div>
                @role('admin')
                <a href="{{ route('users.index') }}" class="btn btn-primary mb-3">
                    Administrar Usuarios
                </a>
                @endrole

                <!-- Botón Logout -->
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger mb-3">Cerrar sesión</button>
                </form>
            </div>
        </div>

        <hr>
        </hr>

        <h3 class="mb-3">Filtrar Auditoría</h3>

        <!-- Botón para mostrar/ocultar el formulario -->
        <button type="button" class="btn btn-info mb-4" id="toggleFilterForm">Desplegar Filtrado</button>

        <!-- Formulario de filtrado (inicialmente oculto) -->
        <form method="GET" action="{{ route('auditoria.index') }}" class="mb-5" id="filterForm" style="display:none;">

            <!-- Registros por página -->
            <div class="mb-3">
                <label class="fw-bold" for="per_page" class="form-label">Registros por página</label>
                <select name="per_page" id="per_page" class="form-select">
                    @foreach([5, 10, 15, 20] as $cantidad)
                    <option value="{{ $cantidad }}" {{ request('per_page', 5) == $cantidad ? 'selected' : '' }}>
                        {{ $cantidad }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="row g-3 align-items-end">
                <!-- Usuario -->
                <div class="form-group mb-2">
                    <label class="fw-bold" for="usuario" class="form-label">Usuario</label>
                    <select name="usuario" id="usuario" class="form-control">
                        <option value="">Todos</option>
                        <option value="Sistema" {{ request('usuario') == 'Sistema' ? 'selected' : '' }}>Sistema</option>
                        @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->name }}" {{ request('usuario') == $usuario->name ? 'selected' : '' }}>
                            {{ $usuario->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Fecha inicio -->
                <div class="form-group mb-2">
                    <label class="fw-bold" for="fecha_inicio" class="form-label">Desde</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ request('fecha_inicio') }}">
                </div>

                <!-- Fecha fin -->
                <div class="form-group mb-2">
                    <label class="fw-bold" for="fecha_fin" class="form-label">Hasta</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}">
                </div>

                <!-- Modelo -->
                <div class="form-group mb-3">
                    <label class="fw-bold" for="modelo" class="form-label">Modelo</label>
                    <select name="modelo" id="modelo" class="form-control">
                        <option value="">Todos</option>
                        <option value="Aula" {{ request('modelo') == 'Aula' ? 'selected' : '' }}>Aula</option>
                        <option value="Equipo" {{ request('modelo') == 'Equipo' ? 'selected' : '' }}>Equipo</option>
                        <option value="Material" {{ request('modelo') == 'Material' ? 'selected' : '' }}>Material</option>
                        <option value="Portatil" {{ request('modelo') == 'Portatil' ? 'selected' : '' }}>Portátil</option>
                        <option value="Profesor" {{ request('modelo') == 'Profesor' ? 'selected' : '' }}>Profesor</option>
                        <option value="ProfesorPortatil" {{ request('modelo') == 'ProfesorPortatil' ? 'selected' : '' }}>ProfesorPortatil</option>
                        <option value="User" {{ request('modelo') == 'User' ? 'selected' : '' }}>Usuario</option>
                    </select>
                </div>

                <!-- Botones -->
                <div class="mb-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary mt-3">Filtrar</button>
                    <a href="{{ route('auditoria.index') }}" class="btn btn-secondary mt-3">Limpiar</a>
                </div>
            </div>
        </form>

        <hr>
        </hr>

        <h3 class="mt-3">Modificaciónes</h3>

        <table class="table table-bordered table-striped align-middle mb-5">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Acción</th>
                    <th>Elemento</th>
                    <th>Modelo</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @forelse($auditorias as $audit)
                <tr>
                    <td>{{ optional($audit->user)->name ?? 'Sistema' }}</td>
                    <td>
                        @switch($audit->event)
                        @case('created') <span class="badge bg-success">Creado</span> @break
                        @case('updated') <span class="badge bg-warning text-dark">Actualizado</span> @break
                        @case('deleted') <span class="badge bg-danger">Eliminado</span> @break
                        @default <span class="badge bg-secondary">{{ $audit->event }}</span>
                        @endswitch
                    </td>
                    <td>
                        @php
                        $modelName = class_basename($audit->auditable_type);
                        $attributes = $audit->new_values ?? [];
                        $old = $audit->old_values ?? [];

                        switch($modelName) {
                        case 'Aula':
                        $label = $attributes['nombre'] ?? $old['nombre'] ?? optional(\App\Models\Aula::find($audit->auditable_id))->nombre ?? 'Aula';
                        break;
                        case 'Equipo':
                        $label = $attributes['etiqueta_cpu'] ?? $old['etiqueta_cpu'] ?? optional(\App\Models\Equipo::find($audit->auditable_id))->etiqueta_cpu ?? 'Equipo';
                        break;
                        case 'Material':
                        $label = $attributes['etiqueta'] ?? $old['etiqueta'] ?? optional(\App\Models\Material::find($audit->auditable_id))->etiqueta ?? 'Material';
                        break;
                        case 'Portatil':
                        $label = $attributes['marca_modelo'] ?? $old['marca_modelo'] ?? optional(\App\Models\Portatil::find($audit->auditable_id))->marca_modelo ?? 'Portátil';
                        break;
                        case 'Profesor':
                        $profesor = optional(\App\Models\Profesor::find($audit->auditable_id));
                        $label = trim(
                        ($attributes['nombre'] ?? $old['nombre'] ?? $profesor->nombre ?? '') . ' ' .
                        ($attributes['apellido_1'] ?? $old['apellido_1'] ?? $profesor->apellido_1 ?? '') . ' ' .
                        ($attributes['apellido_2'] ?? $old['apellido_2'] ?? $profesor->apellido_2 ?? '')
                        );
                        break;
                        case 'ProfesorPortatil':
                        // Intentar obtener el profesor_id desde attributes, old o directamente desde el modelo
                        $profesorId = $attributes['profesor_id'] ?? $old['profesor_id'] ?? $audit->auditable->profesor_id ?? null;

                        $profesor = optional(\App\Models\Profesor::find($profesorId));
                        $nombreProfesor = trim(
                        ($profesor->nombre ?? '') . ' ' .
                        ($profesor->apellido_1 ?? '') . ' ' .
                        ($profesor->apellido_2 ?? '')
                        );

                        $fechaRaw = $attributes['fecha_inicio'] ?? $old['fecha_inicio'] ?? $audit->auditable->fecha_inicio ?? '';
                        $fechaInicio = $fechaRaw ? \Carbon\Carbon::parse($fechaRaw)->format('d/m/Y') : '';

                        $label = $nombreProfesor ? "Usufructo de $nombreProfesor (Inicio: $fechaInicio)" : "Usufructo ($fechaInicio)";
                        break;
                        case 'User':
                        // Para un nuevo usuario (evento 'created'), mostramos su nombre.
                        if (isset($old['roles'])) {
                        // Si hay un valor 'old' (actualización de un rol), comparamos el rol anterior y el nuevo
                        $oldRole = is_array($old['roles'] ?? null) ? implode(', ', $old['roles']) : $old['roles'] ?? '';
                        $newRole = is_array($attributes['roles'] ?? null) ? implode(', ', $attributes['roles']) : $attributes['roles'] ?? '';
                        $userName = optional(\App\Models\User::find($audit->auditable_id))->name; // Obtener el nombre del usuario
                        $label = $oldRole === $newRole
                        ? "Rol asignado a $userName: $newRole"
                        : "Rol cambiado para $userName: $oldRole → $newRole";
                        } else {
                        // Si es un nuevo usuario, mostramos solo su nombre
                        $userName = optional(\App\Models\User::find($audit->auditable_id))->name; // Obtener el nombre del usuario
                        $label = "Nuevo usuario creado: $userName";
                        }
                        break;
                        }
                        @endphp
                        {{ $label }}
                    </td>
                    <td>{{ $modelName }}</td>
                    <td>{{ $audit->created_at->format('d/m/Y H:i') }}</td>
                </tr>

                {{-- Mostrar diferencias si fue update --}}
                @if($audit->event === 'updated')
                <tr>
                    <td colspan="5">
                        <button class="btn btn-link p-0" type="button" data-bs-toggle="collapse" data-bs-target="#detalles-{{ $audit->id }}">
                            Ver cambios
                        </button>
                        <div class="collapse mt-2" id="detalles-{{ $audit->id }}">
                            <ul class="mb-0">
                                @foreach($audit->getModified() as $field => $new)
                                @php
                                $oldValue = $audit->old_values[$field] ?? '—';
                                $oldValue = is_array($oldValue) ? json_encode($oldValue, JSON_UNESCAPED_UNICODE) : $oldValue;
                                $newValue = is_array($new) ? json_encode($new, JSON_UNESCAPED_UNICODE) : $new;
                                @endphp
                                <li>
                                    <strong>{{ ucfirst(str_replace('_', ' ', $field)) }}:</strong> <span class="text-danger">{{ $oldValue }}</span> → <span class="text-success">{{ $newValue }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </td>
                </tr>
                @endif

                @empty
                <tr>
                    <td colspan="5" class="text-center">No hay registros de auditoría aún.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center mb-5">
            {{ $auditorias->links('pagination::bootstrap-4') }}
        </div>

        <a href="{{ route('aulas.index') }}" class="btn btn-primary mb-5">Volver a la lista de aulas</a>

    </div>

    <!-- Script para mostrar filtro de Búsquesa -->
    <script src="{{ asset('js/filtroForm.js') }}"></script>
</body>


<!-- Incluir Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>