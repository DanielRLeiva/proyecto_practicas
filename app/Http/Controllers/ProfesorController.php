<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use Illuminate\Http\Request;

class ProfesorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profesores = Profesor::all();

        return view("profesores.index", compact("profesores"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("profesores.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           'nombre' => 'required|string|max:255',
            'apellido_1' => 'required|string|max:255',
            'apellido_2' => 'nullable|string|max:255',
        ]);

        Profesor::create($request->all());

        return redirect()->route('profesores.index')
            ->with('success','Profesor creado con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Profesor $profesor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profesor $profesor)
    {
        return view('profesores.edit', compact('profesor'));
    }

    /**
     * Update the specified resource in storage.
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
            'apellido_1'=> $request->apellido_1,
            'apellido_2'=> $request->apellido_2
        ]);

        return redirect()->route('profesores.index')
            ->with('success','Profesor actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profesor $profesor)
    {
        $activo = $profesor->usufructo()->whereNull('fecha_fin')->exists();

        if ($activo) {
            return redirect()->route('profesores.index')
                ->with('error', 'El profesor no puede ser eliminado mientras tenga un usufructo activo.');
        }

        $profesor->delete();

        return redirect()->route('profesores.index')
            ->with('success','Profesor eliminado con éxito.');
    }
}
