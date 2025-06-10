<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use Illuminate\Http\Request;

class AulaController extends Controller
{
    /**
     * Muestra la lista de aulas con sus relaciones (equipos y materiales).
     */
    public function index()
    {
        // Cargar aulas con equipos y materiales relacionados, ordenados por nombre ascendente
        $aulas = Aula::with(['equipos', 'materiales'])
            ->orderBy('nombre', 'asc')
            ->get();

        // Retornar la vista con las aulas
        return view("aulas.index", compact("aulas"));
    }

    /**
     * Muestra el formulario para crear una nueva aula.
     */
    public function create()
    {
        // Simplemente retorna la vista del formulario de creación
        return view("aulas.create");
    }

    /**
     * Guarda una nueva aula en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos recibidos antes de crear el registro
        $request->validate([
            "nombre" => "required|string|max:255",
            "ubicacion" => "required|string|max:255",
            "descripcion" => "nullable|string",
        ]);

        // Crear el aula con los datos validados
        Aula::create($request->all());

        // Redirigir a la lista de aulas con mensaje de éxito
        return redirect()->route("aulas.index")
            ->with("success", "Aula creada con exito.");
    }

    /**
     * Muestra los detalles de un aula específica con sus relaciones.
     */
    public function show($id)
    {
        // Buscar aula por ID junto con sus equipos y materiales, si no existe lanza error 404
        $aula = Aula::with(['equipos', 'materiales'])->findOrFail($id);

        // Retornar la vista mostrando los detalles del aula
        return view("aulas.show", compact("aula"));
    }

    /**
     * Muestra el formulario para editar un aula existente.
     */
    public function edit(Aula $aula)
    {
        // Retornar la vista con el aula a editar para mostrar el formulario
        return view("aulas.edit", compact("aula"));
    }

    /**
     * Actualiza un aula existente con los datos recibidos.
     */
    public function update(Request $request, Aula $aula)
    {
        // Validar los datos antes de actualizar el aula
        $request->validate([
            "nombre" => "required|string|max:255",
            "ubicacion" => "required|string|max:255",
            "descripcion" => "nullable|string",
        ]);

        // Actualizar el aula con los datos validados
        $aula->update($request->all());

        // Redirigir a la lista con mensaje de éxito
        return redirect()->route("aulas.index")
            ->with("success", "Aula actualizada con éxito.");
    }

    /**
     * Elimina un aula de la base de datos.
     */
    public function destroy(Aula $aula)
    {
        // Eliminar el aula seleccionada
        $aula->delete();

        // Redirigir con mensaje de éxito
        return redirect()->route("aulas.index")
            ->with("success", "Aula eliminada con éxito.");
    }
}
