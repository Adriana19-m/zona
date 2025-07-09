<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Encuentro;

class EncuentroController extends Controller
{
    /**
     * Mostrar listado de encuentros.
     */
    public function index()
    {
        $encuentros = Encuentro::all();
        return view('encuentros.index', compact('encuentros'));
    }

    /**
     * Mostrar el formulario de creación.
     */
    public function create()
    {
        return view('encuentros.create');
    }

    /**
     * Guardar un nuevo encuentro.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'capacidad' => 'required|integer|min:1',
            'responsable' => 'required|string|max:255',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
        ]);

        Encuentro::create($datos);
        return redirect()->route('encuentros.index')->with('success', 'Encuentro registrado correctamente');
    }

    /**
     * Mostrar el formulario de edición.
     */
    public function edit(string $id)
    {
        $encuentro = Encuentro::findOrFail($id);
        return view('encuentros.edit', compact('encuentro'));
    }

    /**
     * Actualizar un encuentro existente.
     */
    public function update(Request $request, string $id)
    {
        $encuentro = Encuentro::findOrFail($id);

        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'capacidad' => 'required|integer|min:1',
            'responsable' => 'required|string|max:255',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
        ]);

        $encuentro->update($datos);

        return redirect()->route('encuentros.index')->with('success', 'Encuentro actualizado correctamente');
    }

    /**
     * Eliminar un encuentro.
     */
    public function destroy(string $id)
    {
        $encuentro = Encuentro::findOrFail($id);
        $encuentro->delete();

        return redirect()->route('encuentros.index')->with('success', 'Encuentro eliminado correctamente');
    }

    /**
     * Mostrar un mapa con todos los encuentros.
     */
    public function mapa()
    {
        $encuentros = Encuentro::all();
        return view('encuentros.mapa', compact('encuentros'));
    }
}
