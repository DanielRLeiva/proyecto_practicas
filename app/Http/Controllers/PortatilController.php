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
        $portatiles = Portatil::all();

        return view("portatils.index", compact("portatiles"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("portatils.create")
            ->with("success", "Portátil creado con éxito.");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "marca_modelo"=> "required|string|max:255",
            "comentarios"=> "nullable|string|max:255",
        ]);

        Portatil::create($request->all());

        return redirect()->route("portatils.index")
            ->with("success","Portátil creado con éxito.");
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
            'comentarios'=> $request->comentarios,
        ]);

        return redirect()->route('portatils.index')
            ->with('success','Portátil actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Portatil $portatil)
    {
        $activo = $portatil->usufructo()->whereNull('fecha_fin')->exists();

        if ($activo) {
            return redirect()->route('portatils.index')
                ->with('error', 'El portatil no puede ser eliminado mientras tenga un usufructo activo.');
        }

        $portatil->update(['activo' => false]);

        return redirect()->route('portatils.index')
            ->with('success','Portátil eliminado con éxito.');
    }
}
