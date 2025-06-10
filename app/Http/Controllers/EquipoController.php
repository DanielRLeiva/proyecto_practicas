<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Aula;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    /**
     * Muestra la lista de todos los equipos.
     */
    public function index()
    {
        $equipos = Equipo::all();

        return view("equipos.index", compact("equipos"));
    }

    /**
     * Muestra el formulario para crear un nuevo equipo.
     * Permite duplicar un equipo existente si se recibe el parámetro 'duplicar'.
     */
    public function create(Request $request, $aula_id)
    {
        $aula = Aula::findOrFail($aula_id);
        $equipoDuplicado = null;

        if ($request->has('duplicar')) {
            $equipoDuplicado = Equipo::find($request->input('duplicar'));
        }

        return view("equipos.create", compact('aula', 'aula_id', 'equipoDuplicado'));
    }

    /**
     * Guarda un nuevo equipo en la base de datos.
     * Valida campos, crea el equipo y redirige según de dónde venga la petición.
     */
    public function store(Request $request)
    {
        // Validación de campos (muchos son opcionales)
        $request->validate([
            'etiqueta_cpu' => 'nullable|string|max:60',
            'marca_cpu' => 'nullable|string|max:60',
            'modelo_cpu' => 'nullable|string|max:60',
            'numero_serie_cpu' => 'nullable|string|max:60',
            'tipo_cpu' => 'nullable|string|max:60',
            'memoria' => 'nullable|string|max:60',
            'disco_duro' => 'nullable|string|max:60',
            'conectores_video' => 'nullable|string|max:60',
            'etiqueta_monitor' => 'nullable|string|max:60',
            'marca_monitor' => 'nullable|string|max:60',
            'modelo_monitor' => 'nullable|string|max:60',
            'conectores_monitor' => 'nullable|string|max:60',
            'pulgadas' => 'nullable|numeric',
            'numero_serie_monitor' => 'nullable|string|max:60',
            'etiqueta_teclado' => 'nullable|string|max:60',
            'etiqueta_raton' => 'nullable|string|max:60',
            'observaciones' => 'nullable|string',
            'aula_id' => 'required|exists:aulas,id',
            'numero_inventario' => 'nullable|string|max:60',
        ]);

        Equipo::create($request->all());

        $redirectUrl = $request->input('redirect_to');
        $aulaId = $request->input('aula_id');

        // Si la petición viene de la lista general de equipos
        if (str_contains($redirectUrl, route('equipos.all'))) {
            return redirect()->route('equipos.all')
                ->with('success', 'Equipo creado con éxito.');
        }

        // Si no, redirige a la vista del aula específica
        return redirect()->route('aulas.show', ['aula' => $aulaId])
            ->with('success', 'Equipo creado con éxito.');
    }

    /**
     * Muestra los detalles de un equipo específico.
     */
    public function show(Equipo $equipo)
    {
        return view('equipos.show', compact('equipo'));
    }

    /**
     * Muestra el formulario para editar un equipo.
     * Recibe el aula para mostrar contexto en la vista.
     */
    public function edit(Equipo $equipo, $aula_id)
    {
        $aula = Aula::findOrFail($aula_id);

        return view('equipos.edit', compact('equipo', 'aula'));
    }

    /**
     * Actualiza los datos de un equipo existente.
     * Aquí hay un error: se está creando un nuevo equipo en vez de actualizar el existente.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'etiqueta_cpu' => 'nullable|string|max:60',
            'marca_cpu' => 'nullable|string|max:60',
            'modelo_cpu' => 'nullable|string|max:60',
            'numero_serie_cpu' => 'nullable|string|max:60',
            'tipo_cpu' => 'nullable|string|max:60',
            'memoria' => 'nullable|string|max:60',
            'disco_duro' => 'nullable|string|max:60',
            'conectores_video' => 'nullable|string|max:60',
            'etiqueta_monitor' => 'nullable|string|max:60',
            'marca_monitor' => 'nullable|string|max:60',
            'modelo_monitor' => 'nullable|string|max:60',
            'conectores_monitor' => 'nullable|string|max:60',
            'pulgadas' => 'nullable|numeric',
            'numero_serie_monitor' => 'nullable|string|max:60',
            'etiqueta_teclado' => 'nullable|string|max:60',
            'etiqueta_raton' => 'nullable|string|max:60',
            'observaciones' => 'nullable|string',
            'aula_id' => 'required|exists:aulas,id',
            'numero_inventario' => 'nullable|string|max:60',
        ]);

        // ERROR: Aquí debería actualizar el equipo, no crear uno nuevo
        $equipo = Equipo::findOrFail($id);

        $equipo->update([
            'etiqueta_cpu' => $request->etiqueta_cpu,
            'marca_cpu' => $request->marca_cpu,
            'modelo_cpu' => $request->modelo_cpu,
            'numero_serie_cpu' => $request->numero_serie_cpu,
            'tipo_cpu' => $request->tipo_cpu,
            'memoria' => $request->memoria,
            'disco_duro' => $request->disco_duro,
            'conectores_video' => $request->conectores_video,
            'etiqueta_monitor' => $request->etiqueta_monitor,
            'marca_monitor' => $request->marca_monitor,
            'modelo_monitor' => $request->modelo_monitor,
            'conectores_monitor' => $request->conectores_monitor,
            'pulgadas' => $request->pulgadas,
            'numero_serie_monitor' => $request->numero_serie_monitor,
            'etiqueta_teclado' => $request->etiqueta_teclado,
            'etiqueta_raton' => $request->etiqueta_raton,
            'observaciones' => $request->observaciones,
            'aula_id' => $request->aula_id,
            'numero_inventario' => $request->numero_inventario,
        ]);

        $redirectUrl = $request->input('redirect_to');
        $aulaId = $request->input('aula_id');

        // Verificamos si venimos de 'equipos.all'
        if (str_contains($redirectUrl, route('equipos.all'))) {
            return redirect()->route('equipos.all')
                ->with('success', 'Equipo actualizado con éxito.');
        }

        // Si no, redirigimos a la ubicación específica
        return redirect()->route('aulas.show', ['aula' => $aulaId])
            ->with('success', 'Equipo actualizado con éxito.');
    }

    /**
     * Elimina un equipo.
     */
    public function destroy($id)
    {
        $equipo = Equipo::findOrFail($id);
        $equipo->delete();

        return redirect()->back()->with('success', 'Equipo eliminado con éxito.');
    }

    /**
     * Muestra todos los equipos de todas las aulas, con filtros y paginación.
     */
    public function all(Request $request)
    {
        $query = Equipo::join('aulas', 'equipos.aula_id', '=', 'aulas.id')
            ->select('equipos.*') // Solo campos de equipos
            ->with('aula'); // Carga la relación aula para la vista

        // Filtros opcionales para marca, aula y número de inventario
        if ($request->filled('marca_cpu')) {
            $query->where('marca_cpu', 'like', '%' . $request->marca_cpu . '%');
        }

        if ($request->filled('aula_id')) {
            $query->where('aula_id', $request->aula_id);
        }

        if ($request->filled('numero_inventario')) {
            $query->where('numero_inventario', 'like', '%' . $request->numero_inventario . '%');
        }

        // Ordenar primero por el nombre del aula, luego por etiqueta_cpu
        $query->orderBy('aulas.nombre')
            ->orderBy('equipos.etiqueta_cpu');

        $perPage = $request->input('per_page', 10); // Paginación, 10 por defecto
        $equipos = $query->paginate($perPage)->appends($request->query());

        $aulas = Aula::orderBy('nombre')->get(); // Para filtro de aulas en la vista

        return view('equipos.all', compact('equipos', 'aulas'));
    }
}
