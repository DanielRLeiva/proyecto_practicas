<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Aula;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Muestra la lista de todos los materiales.
     */
    public function index()
    {
        $materiales = Material::all();

        return view('materials.index', compact('materiales'));
    }

    /**
     * Muestra el formulario para crear un nuevo material asociado a un aula.
     */
    public function create($aula_id)
    {
        $aula = Aula::findOrFail($aula_id); // Verifica que el aula exista

        return view('materials.create', compact('aula', 'aula_id'));
    }

    /**
     * Guarda un nuevo material en la base de datos.
     * Valida los campos y redirige a la vista del aula correspondiente.
     */
    public function store(Request $request)
    {
        $request->validate([
            'etiqueta' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'marca' => 'nullable|string|max:255',
            'modelo' => 'nullable|string|max:255',
            'numero_serie' => 'nullable|string|max:255',
            'caracteristicas' => 'nullable|string',
            'aula_id' => 'required|exists:aulas,id', // Aula debe existir
        ]);

        Material::create($request->all());

        return redirect()->route('aulas.show',  ['aula' => $request->aula_id])
            ->with('success', 'Material creado con éxito.');
    }

    /**
     * Muestra los detalles de un material específico.
     */
    public function show(Material $material)
    {
        return view('materiales.show', compact('material'));
    }

    /**
     * Muestra el formulario para editar un material.
     * Se pasa también el aula para contexto.
     */
    public function edit(Material $material, $aula_id)
    {
        $aula = Aula::findOrFail($aula_id);

        return view('materials.edit', compact('material', 'aula'));
    }

    /**
     * Actualiza un material existente.
     * Se valida, busca el material por ID y luego actualiza sus campos.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'etiqueta' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'marca' => 'nullable|string|max:255',
            'modelo' => 'nullable|string|max:255',
            'numero_serie' => 'nullable|string|max:255',
            'caracteristicas' => 'nullable|string',
            'aula_id' => 'required|exists:aulas,id',
        ]);

        $material = Material::findOrFail($id);

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
     * Elimina un material de la base de datos.
     * Luego redirige a la vista del aula asociada.
     */
    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        $material->delete();

        return redirect()->route('aulas.show', ['aula' => $material->aula_id])
            ->with('success', 'Material eliminado con éxito.');
    }
}
