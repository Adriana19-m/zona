<?php

namespace App\Http\Controllers;

use App\Models\Riesgo;
use Illuminate\Http\Request;

class RiesgoController extends Controller
{
    /**
     * Mostrar una lista de los riesgos.
     */
    public function index()
    {
        $riesgos = Riesgo::all();
        return view('riesgos.index', compact('riesgos'));
    }

    /**
     * Mostrar el formulario para crear un nuevo riesgo.
     */
    public function create()
    {
        return view('riesgos.nuevo');
    }

    /**
     * Almacenar un nuevo riesgo en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación básica
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'nivel' => 'required|in:Bajo,Medio,Alto,Crítico',
            'latitud1' => 'nullable|numeric|between:-90,90',
            'longitud1' => 'nullable|numeric|between:-180,180',
            'latitud2' => 'nullable|numeric|between:-90,90',
            'longitud2' => 'nullable|numeric|between:-180,180',
            'latitud3' => 'nullable|numeric|between:-90,90',
            'longitud3' => 'nullable|numeric|between:-180,180',
            'latitud4' => 'nullable|numeric|between:-90,90',
            'longitud4' => 'nullable|numeric|between:-180,180',
        ]);

        // Obtener todas las coordenadas
        $datos = $request->only([
            'nombre',
            'descripcion',
            'nivel',
            'latitud1',
            'longitud1',
            'latitud2',
            'longitud2',
            'latitud3',
            'longitud3',
            'latitud4',
            'longitud4',
        ]);

        // Validar que al menos una coordenada esté completa
        $coordenadasCompletas = 0;
        for ($i = 1; $i <= 4; $i++) {
            $lat = $request->input("latitud$i");
            $lng = $request->input("longitud$i");
            
            if ($lat !== null && $lng !== null) {
                $coordenadasCompletas++;
            } elseif ($lat !== null || $lng !== null) {
                return back()->withErrors([
                    "coordenada$i" => "La coordenada $i debe tener tanto latitud como longitud, o ambas vacías."
                ])->withInput();
            }
        }

        if ($coordenadasCompletas === 0) {
            return back()->withErrors([
                'coordenadas' => 'Debe proporcionar al menos una coordenada completa.'
            ])->withInput();
        }

        Riesgo::create($datos);
        return redirect()->route('riesgos.index')->with('success', 'Riesgo creado correctamente');
    }

    /**
     * Mostrar el formulario para editar un riesgo existente.
     */
    public function edit(string $id)
    {
        $riesgo = Riesgo::findOrFail($id);
        return view('riesgos.editar', compact('riesgo'));
    }

    /**
     * Actualizar un riesgo específico en la base de datos.
     */
    public function update(Request $request, string $id)
    {
        $riesgo = Riesgo::findOrFail($id);

        // Validación
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'nivel' => 'required|in:Bajo,Medio,Alto,Crítico',
            'latitud1' => 'nullable|numeric|between:-90,90',
            'longitud1' => 'nullable|numeric|between:-180,180',
            'latitud2' => 'nullable|numeric|between:-90,90',
            'longitud2' => 'nullable|numeric|between:-180,180',
            'latitud3' => 'nullable|numeric|between:-90,90',
            'longitud3' => 'nullable|numeric|between:-180,180',
            'latitud4' => 'nullable|numeric|between:-90,90',
            'longitud4' => 'nullable|numeric|between:-180,180',
        ]);

        // Validar coordenadas completas
        $coordenadasCompletas = 0;
        for ($i = 1; $i <= 4; $i++) {
            $lat = $request->input("latitud$i");
            $lng = $request->input("longitud$i");
            
            if ($lat !== null && $lng !== null) {
                $coordenadasCompletas++;
            } elseif ($lat !== null || $lng !== null) {
                return back()->withErrors([
                    "coordenada$i" => "La coordenada $i debe tener tanto latitud como longitud, o ambas vacías."
                ])->withInput();
            }
        }

        if ($coordenadasCompletas === 0) {
            return back()->withErrors([
                'coordenadas' => 'Debe proporcionar al menos una coordenada completa.'
            ])->withInput();
        }

        $riesgo->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'nivel' => $request->nivel,
            'latitud1' => $request->latitud1,
            'longitud1' => $request->longitud1,
            'latitud2' => $request->latitud2,
            'longitud2' => $request->longitud2,
            'latitud3' => $request->latitud3,
            'longitud3' => $request->longitud3,
            'latitud4' => $request->latitud4,
            'longitud4' => $request->longitud4,
        ]);

        return redirect()->route('riesgos.index')->with('success', 'Riesgo actualizado correctamente');
    }

    /**
     * Eliminar un riesgo de la base de datos.
     */
    public function destroy(string $id)
    {
        $riesgo = Riesgo::findOrFail($id);
        $riesgo->delete();

        return redirect()->route('riesgos.index')->with('success', 'Riesgo eliminado correctamente');
    }

    /**
     * Mostrar los riesgos en un mapa.
     */
    public function mapa()
    {
        $riesgos = Riesgo::all();
        return view('riesgos.mapa', compact('riesgos'));
    }
}