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
    public function create($aula_id)
    {
        $aula = Aula::findOrFail($aula_id);

        return view("equipos.create", compact('aula','aula_id'));
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
            'pulgadas' => 'nullable|integer',
            'numero_serie_monitor' => 'nullable|string|max:60',
            'etiqueta_teclado' => 'nullable|string|max:60',
            'etiqueta_raton' => 'nullable|string|max:60',
            'observaciones' => 'nullable|string',
            'aula_id' => 'required|exists:aulas,id',
            'numero_inventario' => 'nullable|string|max:60',
            
        ]);

        Equipo::create($request->all());

        return redirect()->route('aulas.show',  ['aula' => $request->aula_id])
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
            'pulgadas' => 'nullable|integer',
            'numero_serie_monitor' => 'nullable|string|max:60',
            'etiqueta_teclado' => 'nullable|string|max:60',
            'etiqueta_raton' => 'nullable|string|max:60',
            'observaciones' => 'nullable|string',
            'aula_id' => 'required|exists:aulas,id',
            'numero_inventario' => 'nullable|string|max:60',
        ]);

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
        
        return redirect()->route('aulas.show', ['aula' => $equipo->aula_id])
            ->with('success', 'Equipo actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $equipo = Equipo::findOrFail($id);
        $equipo->delete();

        return redirect()->route('aulas.show', ['aula' => $equipo->aula_id])
            ->with('success', 'Equipo eliminado con éxito.');
    }

    /**
     * Muestra todos los equipos de todas las aulas.
     */
    public function all(Request $request)
    {
        $query = Equipo::with('aula');

        if ($request->filled('marca_cpu')) {
            $query->where('marca_cpu', 'like', '%' . $request->marca_cpu . '%');
        }

        if ($request->filled('tipo_cpu')) {
            $query->where('tipo_cpu', 'like', '%' . $request->tipo_cpu . '%');
        }

        if ($request->filled('memoria')) {
            $query->where('memoria', 'like', '%' . $request->memoria . '%');
        }

        if ($request->filled('aula_id')) {
            $query->where('aula_id', $request->aula_id);
        }

        if ($request->filled('numero_inventario')) {
            $query->where('numero_inventario', 'like', '%' . $request->numero_inventario . '%');
        }

        $perPage = $request->input('per_page', 10); // valor por defecto: 10
        $equipos = $query->paginate($perPage)->appends($request->query());

        $aulas = Aula::all(); // Para mostrar en el select de aulas

        return view('equipos.all', compact('equipos', 'aulas'));
    }
}
