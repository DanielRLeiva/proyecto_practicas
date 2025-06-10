<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use Illuminate\Http\Request;

class ProfesorController extends Controller
{
    /**
     * Muestra la lista de profesores, ordenados primero por activos.
     */
    public function index()
    {
        // Ordena por el campo 'activo' descendente (primero activos)
        $profesores = Profesor::orderBy('activo', 'desc')->get();

        return view("profesors.index", compact("profesores"));
    }

    /**
     * Muestra el formulario para crear un nuevo profesor.
     */
    public function create()
    {
        return view("profesors.create");
    }

    /**
     * Valida y almacena un nuevo profesor en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_1' => 'required|string|max:255',
            'apellido_2' => 'nullable|string|max:255',
        ]);

        Profesor::create($request->all());

        return redirect()->route('profesors.index')
            ->with('success', 'Profesor creado con éxito.');
    }

    /**
     * Muestra el formulario para editar un profesor existente.
     */
    public function edit(Profesor $profesor)
    {
        return view('profesors.edit', compact('profesor'));
    }

    /**
     * Valida y actualiza los datos de un profesor.
     */
    public function update(Request $request, Profesor $profesor)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_1' => 'required|string|max:255',
            'apellido_2' => 'nullable|string|max:255',
        ]);

        $profesor->update([
            'nombre' => $request->nombre,
            'apellido_1' => $request->apellido_1,
            'apellido_2' => $request->apellido_2
        ]);

        return redirect()->route('profesors.index')
            ->with('success', 'Profesor actualizado con éxito.');
    }

    /**
     * Baja lógica de un profesor.
     * Antes de desactivarlo, verifica que no tenga usufructos activos.
     * Si tiene usufructo activo, impide la baja mostrando un mensaje de error.
     */
    public function destroy(Profesor $profesor)
    {
        $activo = $profesor->usufructo()->whereNull('fecha_fin')->exists();

        if ($activo) {
            return redirect()->route('profesors.index')
                ->with('error', 'El profesor no puede ser dado de BAJA mientras tenga un usufructo activo.');
        }

        $profesor->activo = false;  // Desactiva el profesor
        $profesor->save();

        return redirect()->route('profesors.index')
            ->with('success', 'Profesor desactivado con éxito.');
    }

    /**
     * Reactiva un profesor previamente desactivado.
     */
    public function activar($id)
    {
        $profesor = Profesor::findOrFail($id);
        $profesor->activo = true;
        $profesor->save();

        return redirect()->route('profesors.index')
            ->with('success', 'Profesor activado correctamente.');
    }
}
