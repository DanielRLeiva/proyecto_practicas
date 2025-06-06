<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Aula;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipos = Equipo::all();

        return view("equipos.index", compact("equipos"));
    }

    /**
     * Show the form for creating a new resource.
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

        Equipo::create($request->all());


        $redirectUrl = $request->input('redirect_to');
        $aulaId = $request->input('aula_id');

        // Verificamos si venimos de 'equipos.all'
        if (str_contains($redirectUrl, route('equipos.all'))) {
            return redirect()->route('equipos.all')
                ->with('success', 'Equipo creado con éxito.');
        }

        // Si no, redirigimos a la ubicación específica
        return redirect()->route('aulas.show', ['aula' => $aulaId])
            ->with('success', 'Equipo creado con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipo $equipo)
    {
        return view('equipos.show', compact('equipo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipo $equipo, $aula_id)
    {
        $aula = Aula::findOrFail($aula_id);

        return view('equipos.edit', compact('equipo', 'aula'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
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

        Equipo::create($request->all());

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
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $equipo = Equipo::findOrFail($id);
        $equipo->delete();

        return redirect()->back()->with('success', 'Equipo eliminado con éxito.');
    }

    /**
     * Muestra todos los equipos de todas las aulas.
     */
    public function all(Request $request)
    {
        $query = Equipo::join('aulas', 'equipos.aula_id', '=', 'aulas.id')
            ->select('equipos.*') // Seleccionamos solo los campos de equipos
            ->with('aula');  // Cargamos la relación para la vista

        if ($request->filled('marca_cpu')) {
            $query->where('marca_cpu', 'like', '%' . $request->marca_cpu . '%');
        }

        if ($request->filled('aula_id')) {
            $query->where('aula_id', $request->aula_id);
        }

        if ($request->filled('numero_inventario')) {
            $query->where('numero_inventario', 'like', '%' . $request->numero_inventario . '%');
        }

        // Ordenar por nombre de ubicación y luego etiqueta_cpu
        $query->orderBy('aulas.nombre')
            ->orderBy('equipos.etiqueta_cpu');


        $perPage = $request->input('per_page', 10); // valor por defecto: 10
        $equipos = $query->paginate($perPage)->appends($request->query());

        $aulas = Aula::orderBy('nombre')->get(); // Para mostrar en el select de aulas

        return view('equipos.all', compact('equipos', 'aulas'));
    }
}
