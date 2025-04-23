<?php

namespace App\Http\Controllers;

use App\Models\Portatil;
use Illuminate\Http\Request;

class PortatilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $portatiles = Portatil::with('usufructo')
            ->get()
            ->sortBy(function($portatil) {
                if ($portatil->estado === 'en_uso') {
                    return 0; // En Usufuructo primero
                } elseif ($portatil->estado === 'libre') {
                    return 1; // Libre después
                } else {
                    return 2; // Inactivo al final
                }  
            });

        return view("portatils.index", compact("portatiles"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("portatils.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "marca_modelo" => "required|string|max:255",
            "comentarios" => "nullable|string|max:255",
        ]);

        Portatil::create($request->all());

        return redirect()->route("portatils.index")
            ->with("success", "Portátil creado con éxito.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Portatil $portatil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Portatil $portatil)
    {
        return view("portatils.edit", compact("portatil"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Portatil $portatil)
    {
        $request->validate([
            'marca_modelo' => 'required|string|max:255',
            'comentarios' => 'nullable|string|max:255',
        ]);

        $portatil->update([
            'marca_modelo' => $request->marca_modelo,
            'comentarios' => $request->comentarios,
        ]);

        return redirect()->route('portatils.index')
            ->with('success', 'Portátil actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Portatil $portatil)
    {
        $activo = $portatil->usufructo()->whereNull('fecha_fin')->exists();

        if ($activo) {
            return redirect()->route('portatils.index')
                ->with('error', 'El portatil no puede ser dado de baja mientras tenga un usufructo activo.');
        }

        $portatil->activo = false;
        $portatil->save();

        return redirect()->route('portatils.index')
            ->with('success', 'Portátil dado de baja con éxito.');
    }

    /**
     * Activar un portátil dado de baja
     */
    public function activar($id)
    {
        $portatil = Portatil::findOrFail($id);

        // Verificar que no tenga un usufructo activo
        $usufructoActivo = $portatil->usufructo()->whereNull('fecha_fin')->exists();

        if ($usufructoActivo) {
            return redirect()->route('portatils.index')
                ->with('error', 'No se puede dar de alta un portátil que está en usufructo.');
        }

        $portatil->activo = true;
        $portatil->save();

        return redirect()->route('portatils.index')
            ->with('success', 'Portátil dado de alta con éxito.');
    }
}
