<?php

namespace App\Http\Controllers;

use App\Models\Seguras;
use Illuminate\Http\Request;

class SegurasController extends Controller
{
    /**
     * Muestra una lista de los recursos.
     */
    public function index()
    {
        $seguras = Seguras::all();
        return view('seguras.index', compact('seguras'));
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        return view('seguras.create');
    }

    /**
     * Almacena un recurso recién creado en almacenamiento.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'nombre'   => 'required|string|max:255',
        'radio'    => 'required|numeric',
        'tipo'     => 'required|string|max:255',
        'latitud'  => 'required|numeric',
        'longitud' => 'required|numeric',
    ]);

    Seguras::create($validated);

    return redirect()->route('seguras.index')->with('success', 'Zona segura creada correctamente.');
}


    /**
     * Muestra el recurso especificado.
     */
    public function show($id)
    {
        $segura = Seguras::findOrFail($id);
        return view('seguras.show', compact('segura'));
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     */
    public function edit($id)
    {
        $segura = Seguras::findOrFail($id);
        return view('seguras.edit', compact('segura'));
    }

    /**
     * Actualiza el recurso especificado en almacenamiento.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre'   => 'required|string|max:255',
            'radio'    => 'required|numeric',
            'tipo'     => 'required|string|max:255',
            'latitud'  => 'required|numeric',
            'longitud' => 'required|numeric',
        ]);

        $segura = Seguras::findOrFail($id);
        $segura->update($validated);

        return redirect()->route('seguras.index')->with('success', 'Zona segura actualizada correctamente.');
    }

    /**
     * Elimina el recurso especificado del almacenamiento.
     */
    public function destroy($id)
    {
        $segura = Seguras::findOrFail($id);
        $segura->delete();

        return redirect()->route('seguras.index')->with('success', 'Zona segura eliminada correctamente.');
    }
}
