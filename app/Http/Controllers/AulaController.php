<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\ProfesorPortatil;
use Illuminate\Http\Request;

class AulaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aulas = Aula::with(['equipos', 'materiales'])->get();

        return view("aulas.index", compact("aulas"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("aulas.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required|string|max:255",
            "ubicacion" => "required|string|max:255",
            "descripcion" => "nullable|string",
        ]);

        Aula::create($request->all());

        return redirect()->route("aulas.index")
            ->with("success", "Aula creada con exito.");
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $aula = Aula::with(['equipos', 'materiales'])->findOrFail($id);

        return view("aulas.show", compact("aula"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aula $aula)
    {
        return view("aulas.edit", compact("aula"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aula $aula)
    {
        $request->validate([
            "nombre" => "required|string|max:255",
            "ubicacion" => "required|string|max:255",
            "descripcion" => "nullable|string",
        ]);

        $aula->update($request->all());

        return redirect()->route("aulas.index")
            ->with("success", "Aula actualizada con éxito.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aula $aula)
    {
        $aula->delete();

        return redirect()->route("aulas.index")
            ->with("success", "Aula eliminada con éxito.");
    }
}
