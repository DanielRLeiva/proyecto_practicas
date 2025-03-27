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
            'etiqueta_cpu' => 'required|string|max:255',
            'marca_cpu' => 'required|string|max:255',
            'modelo_cpu' => 'required|string|max:255',
            'numero_serie_cpu' => 'required|string|max:255',
            'tipo_cpu' => 'required|string|max:255',
            'memoria' => 'required|string|max:255',
            'disco_duro' => 'required|string|max:255',
            'conectores_video' => 'required|string|max:255',
            'etiqueta_monitor' => 'required|string|max:255',
            'marca_monitor' => 'required|string|max:255',
            'modelo_monitor' => 'required|string|max:255',
            'conectores_monitor' => 'required|string|max:255',
            'pulgadas' => 'required|integer',
            'numero_serie_monitor' => 'required|string|max:255',
            'etiqueta_teclado' => 'required|string|max:255',
            'etiqueta_raton' => 'required|string|max:255',
            'observaciones' => 'nullable|string',
            'aula_id' => 'required|exists:aulas,id',
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
            'etiqueta_cpu' => 'required|string|max:255',
            'marca_cpu' => 'required|string|max:255',
            'modelo_cpu' => 'required|string|max:255',
            'numero_serie_cpu' => 'required|string|max:255',
            'tipo_cpu' => 'required|string|max:255',
            'memoria' => 'required|string|max:255',
            'disco_duro' => 'required|string|max:255',
            'conectores_video' => 'required|string|max:255',
            'etiqueta_monitor' => 'required|string|max:255',
            'marca_monitor' => 'required|string|max:255',
            'modelo_monitor' => 'required|string|max:255',
            'conectores_monitor' => 'required|string|max:255',
            'pulgadas' => 'required|integer',
            'numero_serie_monitor' => 'required|string|max:255',
            'etiqueta_teclado' => 'required|string|max:255',
            'etiqueta_raton' => 'required|string|max:255',
            'observaciones' => 'nullable|string',
            'aula_id' => 'required|exists:aulas,id',
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
}
