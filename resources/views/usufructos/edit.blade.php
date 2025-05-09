<!-- resources/views/usufructos/edit.blade.php -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usufructo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Editar Usufructo</h1>

        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('usufructos.update', $usufructo->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="profesor_id" class="form-label">Profesor</label>
                <select name="profesor_id" id="profesor_id" class="form-select" required>
                    <option value="">Seleccione un profesor</option>
                    @foreach ($profesores as $profesor)
                    <option value="{{ $profesor->id }}" {{ $profesor->id == $usufructo->profesor_id ? 'selected' : '' }}>
                        {{ $profesor->nombre }} {{ $profesor->apellido_1 }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="portatil_id" class="form-label">Portátil</label>
                <select name="portatil_id" id="portatil_id" class="form-select" required>
                    <option value="">Seleccione un portátil</option>
                    @foreach ($portatiles as $portatil)
                    <option value="{{ $portatil->id }}" {{ $portatil->id == $usufructo->portatil_id ? 'selected' : '' }}>
                        {{ $portatil->marca_modelo }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Fecha de inicio del usufructo, Fecha de fin del usufructo (opcional) -->
            <div class="mb-5">
                <div class="d-flex gap-3">
                    <div class="flex-fill d-flex flex-column">
                        <label for="fecha_inicio" class="fw-bold">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ $usufructo->fecha_inicio }}" required>
                    </div>

                    <div class="flex-fill d-flex flex-column">
                        <label for="fecha_fin" class="fw-bold">Fecha Fin</label>
                        <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ $usufructo->fecha_fin }}" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Actualizar Usufructo</button>
        </form>

        <a href="{{ route('usufructos.index') }}" class="btn btn-primary mt-3">Volver a la lista de Usufructos</a>
    </div>

    <!-- Script para restricción de Fechas -->
    <script src="{{ asset('js/fechasForm.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>