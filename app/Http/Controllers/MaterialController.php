<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Aula;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materiales = Material::all();

        return view('materials.index', compact('materiales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($aula_id)
    {
        $aula = Aula::findOrFail($aula_id);

        return view('materials.create', compact('aula', 'aula_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'etiqueta' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'numero_serie' => 'required|string|max:255',
            'caracteristicas' => 'nullable|string',
            'aula_id' => 'required|exists:aulas,id',
        ]);

        Material::create($request->all());

        return redirect()->route('aulas.show',  ['aula' => $request->aula_id])
            ->with('success', 'Material creado con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        return view('materiales.show', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material, $aula_id)
    {
        $aula = Aula::findOrFail($aula_id);
    
        return view('materials.edit', compact('material', 'aula'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'etiqueta' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'numero_serie' => 'required|string|max:255',
            'caracteristicas' => 'nullable|string',
            'aula_id' => 'required|exists:aulas,id',
        ]);

        $material = Material::findOrFail($id) ;

        $material->update([
            'etiqueta' => $request->etiqueta,
            'descripcion' => $request->descripcion,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'numero_serie' => $request->numero_serie,
            'caracteristicas' => $request->caracteristicas,
            'aula_id' => $request->aula_id,
        ]);

        return redirect()->route('aulas.show', ['aula' => $material->aula_id])
            ->with('success', 'Material actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        $material->delete();

        return redirect()->route('aulas.show', ['aula' => $material->aula_id])
            ->with('success', 'Material eliminado con éxito.');
    }
}
