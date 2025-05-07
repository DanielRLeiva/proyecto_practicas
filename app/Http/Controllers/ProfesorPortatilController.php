<?php

namespace App\Http\Controllers;

use App\Models\Portatil;
use App\Models\Profesor;
use App\Models\ProfesorPortatil;
use Illuminate\Support\Facades\Validator;
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
        $profesores = Profesor::where('activo', true)->get();
        $portatiles = Portatil::where('activo', true)->get();

        return view("usufructos.create", compact("profesores", "portatiles"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profesor_id' => 'required|exists:profesors,id',
            'portatil_id' => 'required|exists:portatils,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date',
        ]);

        if ($request->fecha_fin && $request->fecha_inicio > $request->fecha_fin) {
            $validator->errors()->add('fecha_inicio', 'La fecha de inicio no puede ser posterior a la fecha de fin.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $portatilEnUso = ProfesorPortatil::where('portatil_id', $request->portatil_id)
            ->whereNull('fecha_fin') // Solo verificar los que no tienen fecha de finalización
            ->exists();

        if ($portatilEnUso) {
            $validator->errors()->add('portatil_id', 'El portátil ya está en uso.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        ProfesorPortatil::create($request->all());

        // Marcar el portátil como inactivo
        $portatil = Portatil::find($request->portatil_id);
        $portatil->estado = 'Asignado';
        $portatil->activo = false;
        $portatil->save();

        return redirect()->route('usufructos.index')->with('success', 'Usufructo creado con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProfesorPortatil $usufructo)
    {
        // return view('usufructos.show', compact('usufructo'));
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
        $validator = Validator::make($request->all(), [
            'profesor_id' => 'required|exists:profesors,id',
            'portatil_id' => 'required|exists:portatils,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date',
        ]);

        if ($request->fecha_fin && $request->fecha_inicio > $request->fecha_fin) {
            $validator->errors()->add('fecha_inicio', 'La fecha de inicio no puede ser posterior a la fecha de fin.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $portatilEnUso = ProfesorPortatil::where('portatil_id', $request->portatil_id)
            ->whereNull('fecha_fin')
            ->where('id', '!=', $usufructo->id)
            ->exists();

        if ($portatilEnUso) {
            $validator->errors()->add('portatil_id', 'El portátil ya está en uso.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $usufructo->update([
            'profesor_id' => $request->profesor_id,
            'portatil_id' => $request->portatil_id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);

        // Si se ha modificado una fecha de fin, restarurar el portátil a estado activo
        if ($request->fecha_fin) {
            $portatil = Portatil::find($request->portatil_id);
            $portatil->estado = 'Libre';
            $portatil->activo = true;
            $portatil->save();
        }

        return redirect()->route('usufructos.index')
            ->with('success', 'Usufructo actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProfesorPortatil $usufructo)
    {
        $portatil = $usufructo->portatil;

        // Si el usufructo estaba activo
        if (is_null($usufructo->fecha_fin)) {
            $portatil->estado = 'Libre';
            $portatil->activo = true;
            $portatil->save();
        }
        
        $usufructo->delete();

        return redirect()->route('usufructos.index')
            ->with('success', 'Usufructo eliminado con éxito.');
    }
}
