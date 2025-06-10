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
     * Muestra la lista de usufructos activos y el historial de finalizados.
     */
    public function index()
    {
        // Usufructos activos: sin fecha de fin (aún en curso)
        $usufructosActivos = ProfesorPortatil::with(['profesor', 'portatil'])
            ->whereNull('fecha_fin')
            ->get();

        // Usufructos finalizados: con fecha de fin, ordenados de más reciente a más antiguo
        $usufructosFinalizados = ProfesorPortatil::with(['profesor', 'portatil'])
            ->whereNotNull('fecha_fin')
            ->orderBy('fecha_fin', 'desc')
            ->get();

        return view('usufructos.index', compact('usufructosActivos', 'usufructosFinalizados'));
    }

    /**
     * Muestra el formulario para crear un nuevo usufructo.
     * Solo muestra profesores y portátiles activos para seleccionar.
     */
    public function create()
    {
        $profesores = Profesor::where('activo', true)->get();
        $portatiles = Portatil::where('activo', true)->get();

        return view("usufructos.create", compact("profesores", "portatiles"));
    }

    /**
     * Valida y guarda un nuevo usufructo, verificando que:
     * - La fecha de inicio no sea posterior a la fecha de fin.
     * - El portátil seleccionado no esté ya en uso (sin fecha de fin).
     * Luego marca el portátil como asignado (inactivo).
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profesor_id' => 'required|exists:profesors,id',
            'portatil_id' => 'required|exists:portatils,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date',
        ]);

        // Validación adicional: fecha inicio <= fecha fin
        if ($request->fecha_fin && $request->fecha_inicio > $request->fecha_fin) {
            $validator->errors()->add('fecha_inicio', 'La fecha de inicio no puede ser posterior a la fecha de fin.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Comprobar si el portátil ya está asignado (sin fecha fin)
        $portatilEnUso = ProfesorPortatil::where('portatil_id', $request->portatil_id)
            ->whereNull('fecha_fin')
            ->exists();

        if ($portatilEnUso) {
            $validator->errors()->add('portatil_id', 'El portátil ya está en uso.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Crear el usufructo
        ProfesorPortatil::create($request->all());

        // Cambiar estado del portátil a 'Asignado' y marcar como inactivo
        $portatil = Portatil::find($request->portatil_id);
        $portatil->estado = 'Asignado';
        $portatil->activo = false;
        $portatil->save();

        return redirect()->route('usufructos.index')->with('success', 'Usufructo creado con éxito.');
    }

    /**
     * Formulario para editar un usufructo.
     */
    public function edit(ProfesorPortatil $usufructo)
    {
        $profesores = Profesor::all();
        $portatiles = Portatil::all();

        return view('usufructos.edit', compact('usufructo', 'profesores', 'portatiles'));
    }

    /**
     * Actualiza un usufructo validando fechas y disponibilidad del portátil.
     * Si se pone una fecha de fin (finaliza el usufructo), el portátil vuelve a estar activo y libre.
     */
    public function update(Request $request, ProfesorPortatil $usufructo)
    {
        $validator = Validator::make($request->all(), [
            'profesor_id' => 'required|exists:profesors,id',
            'portatil_id' => 'required|exists:portatils,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date',
        ]);

        // Validar que fecha inicio no sea mayor que fecha fin
        if ($request->fecha_fin && $request->fecha_inicio > $request->fecha_fin) {
            $validator->errors()->add('fecha_inicio', 'La fecha de inicio no puede ser posterior a la fecha de fin.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Verificar que el portátil no esté en uso por otro usufructo activo (excluyendo este)
        $portatilEnUso = ProfesorPortatil::where('portatil_id', $request->portatil_id)
            ->whereNull('fecha_fin')
            ->where('id', '!=', $usufructo->id)
            ->exists();

        if ($portatilEnUso) {
            $validator->errors()->add('portatil_id', 'El portátil ya está en uso.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Actualizar usufructo
        $usufructo->update([
            'profesor_id' => $request->profesor_id,
            'portatil_id' => $request->portatil_id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);

        // Si se ha añadido una fecha fin (usufructo finalizado), liberar portátil
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
     * Elimina un usufructo.
     * Si estaba activo (sin fecha fin), libera el portátil asociado.
     */
    public function destroy(ProfesorPortatil $usufructo)
    {
        $portatil = $usufructo->portatil;

        // Si usufructo activo, liberar portátil
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
