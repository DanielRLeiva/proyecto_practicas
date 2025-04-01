<?php

namespace App\Http\Controllers;

use App\Models\Portatil;
use App\Models\Profesor;
use App\Models\ProfesorPortatil;
use Illuminate\Http\Request;

class ProfesorPortatilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener usufructos activos (sin fecha de finalización)
        $usufructosActivos = ProfesorPortatil::with(['profesor', 'portatil'])
            ->whereNull('fecha_fin')
            ->get();

        // Obtener historial de usufructos finalizados
        $usufructosFinalizados = ProfesorPortatil::with(['profesor', 'portatil'])
            ->whereNotNull('fecha_fin')
            ->orderBy('fecha_fin', 'desc') // Ordenar por la fecha de finalización, de más reciente a más antiguo
            ->get();

        return view('usufructos.index', compact('usufructosActivos', 'usufructosFinalizados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $profesores = Profesor::all();
        $portatiles = Portatil::all();

        return view("usufructos.create", compact("profesores", "portatiles"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'profesor_id' => 'required|exists:profesors,id',
            'portatil_id' => 'required|exists:portatils,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        ProfesorPortatil::create($request->all());

        return redirect()->route('usufructos.index')->with('success', 'Usufructo creado con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProfesorPortatil $usufructo)
    {
        return view('usufructos.show', compact('usufructo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProfesorPortatil $usufructo)
    {
        $profesores = Profesor::all();
        $portatiles = Portatil::all();

        return view('usufructos.edit', compact('usufructo', 'profesores', 'portatiles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProfesorPortatil $usufructo)
    {
        $request->validate([
            'profesor_id' => 'required|exists:profesors,id',
            'portatil_id' => 'required|exists:portatils,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        $usufructo->update([
            'profesor_id' => $request->profesor_id,
            'portatil_id' => $request->portatil_id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);

        return redirect()->route('usufructos.index')
            ->with('success', 'Usufructo actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProfesorPortatil $usufructo)
    {
        $usufructo->delete();

        return redirect()->route('usufructos.index')
            ->with('success', 'Usufructo eliminado con éxito.');
    }
}
