<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Audit;
use App\Models\Aula;
use App\Models\Equipo;
use App\Models\Material;
use App\Models\Portatil;
use App\Models\Profesor;
use Carbon\Carbon;

class AuditoriaController extends Controller
{
    /**
     * Muestra la lista de auditorías con filtros y paginación.
     */
    public function index(Request $request)
    {
        // Obtener lista de usuarios para el filtro por nombre
        $usuarios = User::orderBy('name')->get();

        // Inicializar la consulta principal de auditorías
        $query = Audit::with('user')->latest();

        // Filtro por nombre de usuario o 'Sistema'
        if ($request->filled('usuario')) {
            if ($request->usuario === 'Sistema') {
                $query->whereNull('user_id'); // Auditorías sin usuario (acciones del sistema)
            } else {
                // Auditorías hechas por un usuario específico (coincidencia parcial del nombre)
                $query->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->usuario . '%'));
            }
        }

        // Filtro por fecha de inicio
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('created_at', '>=', $request->fecha_inicio);
        }

        // Filtro por fecha de fin
        if ($request->filled('fecha_fin')) {
            $query->whereDate('created_at', '<=', $request->fecha_fin);
        }

        // Filtro por tipo de modelo (auditable_type)
        if ($request->filled('modelo')) {
            $query->where('auditable_type', 'like', '%\\' . $request->modelo);
        }

        // Filtro por tipo de acción (created, updated, deleted)
        if ($request->filled('accion')) {
            $query->where('event', $request->accion);
        }

        // Paginación de los resultados con filtro de cantidad por página
        $perPage = $request->input('per_page', 10); // Por defecto muestra 5
        $auditorias = $query->paginate($perPage)->appends($request->query());

        // Transformar las auditorías para mostrar información adicional
        $auditorias->setCollection($this->transformarAuditorias($auditorias->getCollection()));

        // Retorna la vista con los datos
        return view('auditoria.index', compact('auditorias', 'usuarios'));
    }

    /**
     * Muestra una vista para confirmar el borrado de auditorías filtradas.
     */
    public function confirmarBorrado(Request $request)
    {
        // Consulta de auditorías filtradas
        $auditorias = Audit::query()
            ->when($request->usuario, fn($q) => $q->whereHas('user', fn($q) => $q->where('name', $request->usuario)))
            ->when($request->fecha_inicio, fn($q) => $q->whereDate('created_at', '>=', $request->fecha_inicio))
            ->when($request->fecha_fin, fn($q) => $q->whereDate('created_at', '<=', $request->fecha_fin))
            ->when($request->modelo, fn($q) => $q->where('auditable_type', 'like', '%' . $request->modelo . '%'))
            ->when($request->accion, fn($q) => $q->where('event', 'like', '%' . $request->accion))
            ->orderBy('created_at', 'desc')
            ->get();

        // Transformar auditorías antes de mostrar
        $auditorias = $this->transformarAuditorias($auditorias);

        // Mostrar vista de confirmación de borrado
        return view('auditoria.confirmar-borrado', compact('auditorias', 'request'));
    }

    /**
     * Elimina las auditorías que coincidan con los filtros aplicados.
     */
    public function destroySelected(Request $request)
    {
        $selectedIds = $request->input('selected_ids', []);

        if (empty($selectedIds)) {
            // Volver a la vista de confirmación con mensaje de error
            return redirect()->back()
                ->withInput()
                ->with('warning', 'No seleccionaste ningún registro para eliminar.');
        }

        $cantidadBorrada = Audit::whereIn('id', $selectedIds)->delete();

        return redirect()->route('auditoria.index')
            ->with('success', "Se han eliminado $cantidadBorrada registros de auditoría.");
    }

    /**
     * Transforma una colección de auditorías para agregar campos legibles:
     * - modelName: nombre corto del modelo
     * - label: una etiqueta descriptiva del objeto auditado
     * - modificaciones_formateadas: cambios aplicados con formato
     */
    private function transformarAuditorias($auditorias)
    {
        return $auditorias->transform(function ($audit) {
            $modelName = class_basename($audit->auditable_type); // Eliminar namespace
            $attributes = $audit->new_values ?? [];
            $old = $audit->old_values ?? [];
            $label = 'Sin información';

            // Asignar una etiqueta legible según el tipo de modelo
            switch ($modelName) {
                case 'Aula':
                    $label = $attributes['nombre'] ?? $old['nombre'] ?? optional(Aula::find($audit->auditable_id))->nombre ?? 'Aula';
                    break;
                case 'Equipo':
                    $label = $attributes['etiqueta_cpu'] ?? $old['etiqueta_cpu'] ?? optional(Equipo::find($audit->auditable_id))->etiqueta_cpu ?? 'Equipo';
                    break;
                case 'Material':
                    $label = $attributes['etiqueta'] ?? $old['etiqueta'] ?? optional(Material::find($audit->auditable_id))->etiqueta ?? 'Material';
                    break;
                case 'Portatil':
                    $label = $attributes['marca_modelo'] ?? $old['marca_modelo'] ?? optional(Portatil::find($audit->auditable_id))->marca_modelo ?? 'Portátil';
                    break;
                case 'Profesor':
                    $profesor = optional(Profesor::find($audit->auditable_id));
                    $label = trim(
                        ($attributes['nombre'] ?? $old['nombre'] ?? $profesor->nombre ?? '') . ' ' .
                            ($attributes['apellido_1'] ?? $old['apellido_1'] ?? $profesor->apellido_1 ?? '') . ' ' .
                            ($attributes['apellido_2'] ?? $old['apellido_2'] ?? $profesor->apellido_2 ?? '')
                    );
                    break;
                case 'ProfesorPortatil':
                    $profesorId = $attributes['profesor_id'] ?? $old['profesor_id'] ?? $audit->auditable->profesor_id ?? null;
                    $profesor = optional(Profesor::find($profesorId));
                    $nombreProfesor = trim(($profesor->nombre ?? '') . ' ' . ($profesor->apellido_1 ?? '') . ' ' . ($profesor->apellido_2 ?? ''));
                    $fechaRaw = $attributes['fecha_inicio'] ?? $old['fecha_inicio'] ?? $audit->auditable->fecha_inicio ?? '';
                    $fechaInicio = $fechaRaw ? Carbon::parse($fechaRaw)->format('d/m/Y') : '';
                    $label = $nombreProfesor ? "Usufructo de $nombreProfesor ($fechaInicio)" : "Usufructo ($fechaInicio)";
                    break;
                case 'User':
                    // Intentar obtener desde BD
                    $user = optional(User::find($audit->auditable_id));

                    // Si no existe, usar el nombre desde old_values
                    $userName = $user->name ?? ($audit->old_values['name'] ?? 'Usuario desconocido');

                    switch ($audit->event) {
                        case 'created':
                            $label = "Usuario creado: $userName";
                            break;

                        case 'deleted':
                            $label = "Usuario eliminado: $userName";
                            break;

                        case 'updated':
                            $label = "Usuario actualizado: $userName";
                    }
                    break;
            }

            // Asignar atributos extra al objeto Audit
            $audit->modelName = $modelName;
            $audit->label = $label;
            $audit->modificaciones_formateadas = $audit->getFormattedModifications(); // Método personalizado

            return $audit;
        });
    }
}
