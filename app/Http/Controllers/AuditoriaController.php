<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class AuditoriaController extends Controller
{
    public function index(Request $request)
    {
        // Obtener los usuarios para el filtro de usuario
        $usuarios = User::orderBy('name')->get();

        // Iniciar la consulta de auditorías
        $query = Audit::with('user')->latest();

        // Filtrar por nombre de usuario
        if ($request->filled('usuario')) {
            // Si se selecciona "Sistema", filtramos por auditorías sin un usuario asignado
            if ($request->usuario === 'Sistema') {
                $query->whereNull('user_id');
            } else {
                // Si se selecciona un usuario específico, filtramos por su nombre
                $query->whereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->usuario . '%');
                });
            }
        }

        // Filtrar por fecha de inicio
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('created_at', '>=', $request->fecha_inicio);
        }

        // Filtrar por fecha de fin
        if ($request->filled('fecha_fin')) {
            $query->whereDate('created_at', '<=', $request->fecha_fin);
        }

        // Filtrar por modelo (auditable_type)
        if ($request->filled('modelo')) {
            $query->where('auditable_type', 'like', '%\\' . $request->modelo);
        }

        // Filtrar por acción (created, updated, deleted)
        if ($request->filled('accion')) {
            $query->where('event', $request->accion);
        }

        // Realizar la paginación y mantener los filtros en la URL
        $perPage = $request->input('per_page', 5); // Por defecto 5
        $auditorias = $query->paginate($perPage)->appends($request->query());

        // Transformar cada auditoría para agregarle modelName y label legibles
        $auditorias->getCollection()->transform(function ($audit) {
            // Obtener el nombre del modelo sin el namespace
            $modelName = class_basename($audit->auditable_type);

            // Valores nuevos y anteriores del modelo auditado
            $attributes = $audit->new_values ?? [];
            $old = $audit->old_values ?? [];
            $label = 'Sin información';

            // Determinar etiqueta descriptiva según el tipo de modelo
            switch ($modelName) {
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
                    // Construir nombre completo del profesor
                    $profesor = optional(\App\Models\Profesor::find($audit->auditable_id));
                    $label = trim(
                        ($attributes['nombre'] ?? $old['nombre'] ?? $profesor->nombre ?? '') . ' ' .
                            ($attributes['apellido_1'] ?? $old['apellido_1'] ?? $profesor->apellido_1 ?? '') . ' ' .
                            ($attributes['apellido_2'] ?? $old['apellido_2'] ?? $profesor->apellido_2 ?? '')
                    );
                    break;
                case 'ProfesorPortatil':
                    // Mostrar usufructo con nombre del profesor y fecha
                    $profesorId = $attributes['profesor_id'] ?? $old['profesor_id'] ?? $audit->auditable->profesor_id ?? null;
                    $profesor = optional(\App\Models\Profesor::find($profesorId));
                    $nombreProfesor = trim(($profesor->nombre ?? '') . ' ' . ($profesor->apellido_1 ?? '') . ' ' . ($profesor->apellido_2 ?? ''));
                    $fechaRaw = $attributes['fecha_inicio'] ?? $old['fecha_inicio'] ?? $audit->auditable->fecha_inicio ?? '';
                    $fechaInicio = $fechaRaw ? \Carbon\Carbon::parse($fechaRaw)->format('d/m/Y') : '';
                    $label = $nombreProfesor ? "Usufructo de $nombreProfesor ($fechaInicio)" : "Usufructo ($fechaInicio)";
                    break;
                case 'User':
                    // Mostrar cambios de rol o creación de usuario
                    if (isset($old['roles'])) {
                        $oldRole = is_array($old['roles'] ?? null) ? implode(', ', $old['roles']) : $old['roles'] ?? '';
                        $newRole = is_array($attributes['roles'] ?? null) ? implode(', ', $attributes['roles']) : $attributes['roles'] ?? '';
                        $userName = optional(\App\Models\User::find($audit->auditable_id))->name;
                        $label = $oldRole === $newRole
                            ? "Rol asignado a $userName: $newRole"
                            : "Rol cambiado para $userName: $oldRole → $newRole";
                    } else {
                        $userName = optional(\App\Models\User::find($audit->auditable_id))->name;
                        $label = "Nuevo usuario creado: $userName";
                    }
                    break;
            }

            // Añadir campos personalizados al objeto auditado
            $audit->modelName = $modelName;
            $audit->label = $label;

            return $audit;
        });

        // Pasar la lista de usuarios y los resultados filtrados a la vista
        return view('auditoria.index', compact('auditorias', 'usuarios'));
    }
}
