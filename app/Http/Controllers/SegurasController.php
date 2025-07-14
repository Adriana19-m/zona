<?php

namespace App\Http\Controllers;

use App\Models\Seguras;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Log;


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
    

  public function generarPDF()
    {
        $seguras = Seguras::all();
        
        // Necesitamos pasar las coordenadas para el mapa estático
        $coordenadas = $seguras->map(function($zona) {
            return [
                'lat' => $zona->latitud,
                'lng' => $zona->longitud,
                'tipo' => $zona->tipo,
                'radio' => $zona->radio
            ];
        });

        $pdf = PDF::loadView('seguras.pdf', [
            'seguras' => $seguras,
            'coordenadas' => $coordenadas
        ])->setPaper('a4', 'landscape');

        return $pdf->download('zonas_seguras.pdf');
    }
   
    public function enviarMapa(Request $request)
        {
            $image = $request->input('imagen');
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageData = base64_decode($image);
            
            $pdf = PDF::loadView('pdf.zonas', ['image' => $imageData]);
            return $pdf->download('zonas_seguras.pdf');
        }
    

}
