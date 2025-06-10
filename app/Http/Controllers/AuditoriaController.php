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
        // Obtener lista completa de usuarios para desplegar en filtro de búsqueda
        $usuarios = User::orderBy('name')->get();

        // Crear la consulta base con relación a usuario y ordenar por fecha descendente
        $query = Audit::with('user')->latest();

        // Aplicar filtro por usuario, incluyendo opción para 'Sistema' (user_id NULL)
        if ($request->filled('usuario')) {
            if ($request->usuario === 'Sistema') {
                $query->whereNull('user_id'); // Acciones del sistema sin usuario asignado
            } else {
                // Filtrar auditorías por nombre de usuario con coincidencia parcial
                $query->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->usuario . '%'));
            }
        }

        // Filtrar auditorías desde una fecha inicial (inclusive)
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('created_at', '>=', $request->fecha_inicio);
        }

        // Filtrar auditorías hasta una fecha final (inclusive)
        if ($request->filled('fecha_fin')) {
            $query->whereDate('created_at', '<=', $request->fecha_fin);
        }

        // Filtrar por tipo de modelo auditado (auditable_type)
        if ($request->filled('modelo')) {
            // Usar like con barra invertida para que coincida con el namespace completo o parcial
            $query->where('auditable_type', 'like', '%\\' . $request->modelo);
        }

        // Filtrar por tipo de acción: creado, actualizado, eliminado
        if ($request->filled('accion')) {
            $query->where('event', $request->accion);
        }

        // Definir cantidad de resultados por página, por defecto 10
        $perPage = $request->input('per_page', 10);
        // Obtener resultados paginados, manteniendo parámetros en links
        $auditorias = $query->paginate($perPage)->appends($request->query());

        // Transformar los datos para mostrar información más amigable en la vista
        $auditorias->setCollection($this->transformarAuditorias($auditorias->getCollection()));

        // Retornar vista con auditorías y lista de usuarios para filtro
        return view('auditoria.index', compact('auditorias', 'usuarios'));
    }

    /**
     * Muestra una vista para confirmar el borrado de auditorías según filtros.
     */
    public function confirmarBorrado(Request $request)
    {
        // Construir consulta según filtros recibidos
        $auditorias = Audit::query()
            ->when($request->usuario, function ($q) use ($request) {
                if ($request->usuario === 'Sistema') {
                    $q->whereNull('user_id'); // Auditorías sin usuario asignado
                } else {
                    $q->whereHas('user', fn($q2) => $q2->where('name', $request->usuario));
                }
            })
            ->when($request->fecha_inicio, fn($q) => $q->whereDate('created_at', '>=', $request->fecha_inicio))
            ->when($request->fecha_fin, fn($q) => $q->whereDate('created_at', '<=', $request->fecha_fin))
            ->when($request->modelo, fn($q) => $q->where('auditable_type', 'like', '%' . $request->modelo . '%'))
            ->when($request->accion, fn($q) => $q->where('event', 'like', '%' . $request->accion))
            ->orderBy('created_at', 'desc')
            ->get();

        // Aplicar transformación para mejorar presentación en la vista
        $auditorias = $this->transformarAuditorias($auditorias);

        // Retornar vista para que usuario confirme borrado masivo
        return view('auditoria.confirmar-borrado', compact('auditorias', 'request'));
    }

    /**
     * Elimina las auditorías que coincidan con los IDs seleccionados.
     */
    public function destroySelected(Request $request)
    {
        // Obtener IDs seleccionados para eliminar
        $selectedIds = $request->input('selected_ids', []);

        // Validar que se haya seleccionado al menos un registro
        if (empty($selectedIds)) {
            // Redirigir con mensaje de advertencia si no hay selección
            return redirect()->back()
                ->withInput()
                ->with('warning', 'No seleccionaste ningún registro para eliminar.');
        }

        // Eliminar registros de auditoría por IDs
        $cantidadBorrada = Audit::whereIn('id', $selectedIds)->delete();

        // Redirigir a índice con mensaje de éxito
        return redirect()->route('auditoria.index')
            ->with('success', "Se han eliminado $cantidadBorrada registros de auditoría.");
    }

    /**
     * Transforma una colección de auditorías para agregar campos legibles:
     * - modelName: nombre simple del modelo auditado
     * - label: descripción amigable del objeto auditado
     * - modificaciones_formateadas: cambios aplicados con formato legible
     */
    private function transformarAuditorias($auditorias)
    {
        return $auditorias->transform(function ($audit) {
            // Extraer nombre corto del modelo (sin namespace)
            $modelName = class_basename($audit->auditable_type);

            // Obtener nuevos y antiguos valores para construir etiquetas
            $attributes = $audit->new_values ?? [];
            $old = $audit->old_values ?? [];
            $label = 'Sin información';

            // Construir etiqueta según el tipo de modelo auditado
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
                    // Obtener nombre del profesor y fecha de inicio para la etiqueta
                    $profesorId = $attributes['profesor_id'] ?? $old['profesor_id'] ?? $audit->auditable->profesor_id ?? null;
                    $profesor = optional(Profesor::find($profesorId));
                    $nombreProfesor = trim(($profesor->nombre ?? '') . ' ' . ($profesor->apellido_1 ?? '') . ' ' . ($profesor->apellido_2 ?? ''));
                    $fechaRaw = $attributes['fecha_inicio'] ?? $old['fecha_inicio'] ?? $audit->auditable->fecha_inicio ?? '';
                    $fechaInicio = $fechaRaw ? Carbon::parse($fechaRaw)->format('d/m/Y') : '';
                    $label = $nombreProfesor ? "Usufructo de $nombreProfesor ($fechaInicio)" : "Usufructo ($fechaInicio)";
                    break;

                case 'User':
                    // Obtener usuario para mostrar nombre o valor antiguo en caso de eliminado
                    $user = optional(User::find($audit->auditable_id));
                    $userName = $user->name ?? ($audit->old_values['name'] ?? 'Usuario desconocido');

                    // Etiqueta según tipo de evento
                    switch ($audit->event) {
                        case 'created':
                            $label = "Usuario creado: $userName";
                            break;
                        case 'deleted':
                            $label = "Usuario eliminado: $userName";
                            break;
                        case 'updated':
                            $label = "Usuario actualizado: $userName";
                            break;
                    }
                    break;
            }

            // Añadir atributos legibles al objeto auditoría
            $audit->modelName = $modelName;
            $audit->label = $label;
            $audit->modificaciones_formateadas = $audit->getFormattedModifications(); // Método propio para mostrar cambios

            return $audit;
        });
    }
}
