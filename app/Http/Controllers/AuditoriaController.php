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

        // Pasar la lista de usuarios y los resultados filtrados a la vista
        return view('auditoria.index', compact('auditorias', 'usuarios'));
    }
}
