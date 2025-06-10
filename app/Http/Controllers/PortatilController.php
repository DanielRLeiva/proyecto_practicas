<?php

namespace App\Http\Controllers;

use App\Models\Portatil;
use Illuminate\Http\Request;

class PortatilController extends Controller
{
    /**
     * Muestra la lista de todos los portátiles,
     * ordenados por estado: primero 'Asignado', luego 'Libre' y después otros (ej. 'Baja').
     */
    public function index()
    {
        $portatiles = Portatil::with('usufructo') // Carga relación usufructo para evitar consultas N+1
            ->get()
            ->sortBy(function ($portatil) {
                return match ($portatil->estado) {
                    'Asignado' => 0,
                    'Libre' => 1,
                    default => 2, // Baja u otros estados
                };
            });

        return view("portatils.index", compact("portatiles"));
    }

    /**
     * Muestra el formulario para crear un nuevo portátil.
     */
    public function create()
    {
        return view("portatils.create");
    }

    /**
     * Valida y guarda un nuevo portátil.
     * Se asigna estado 'Libre' y activo por defecto.
     */
    public function store(Request $request)
    {
        $request->validate([
            "marca_modelo" => "required|string|max:255",
            "comentarios" => "nullable|string|max:255",
        ]);

        $portatil = new Portatil();
        $portatil->marca_modelo = $request->marca_modelo;
        $portatil->comentarios = $request->comentarios;
        $portatil->estado = 'Libre';  // Estado inicial
        $portatil->activo = true;     // Marcado como activo
        $portatil->save();

        return redirect()->route("portatils.index")
            ->with("success", "Portátil creado con éxito.");
    }

    /**
     * Muestra el formulario para editar un portátil existente.
     */
    public function edit(Portatil $portatil)
    {
        return view("portatils.edit", compact("portatil"));
    }

    /**
     * Valida y actualiza los datos de un portátil.
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
     * Baja lógica de un portátil.
     * Antes de darlo de baja, verifica que no tenga un usufructo activo.
     * Si tiene, muestra error; si no, cambia estado a 'Baja' y marca como inactivo.
     */
    public function destroy(Portatil $portatil)
    {
        $activo = $portatil->usufructo()->whereNull('fecha_fin')->exists();

        if ($activo) {
            return redirect()->route('portatils.index')
                ->with('error', 'El portatil no puede ser dado de baja mientras tenga un usufructo activo.');
        }

        $portatil->activo = false;
        $portatil->estado = 'Baja';
        $portatil->save();

        return redirect()->route('portatils.index')
            ->with('success', 'Portátil dado de baja con éxito.');
    }

    /**
     * Reactivar un portátil dado de baja.
     * También verifica que no tenga usufructo activo para evitar conflictos.
     */
    public function activar($id)
    {
        $portatil = Portatil::findOrFail($id);

        $usufructoActivo = $portatil->usufructo()->whereNull('fecha_fin')->exists();

        if ($usufructoActivo) {
            return redirect()->route('portatils.index')
                ->with('error', 'No se puede dar de alta un portátil que está en usufructo.');
        }

        $portatil->activo = true;
        $portatil->estado = 'Libre';
        $portatil->save();

        return redirect()->route('portatils.index')
            ->with('success', 'Portátil dado de alta con éxito.');
    }
}
