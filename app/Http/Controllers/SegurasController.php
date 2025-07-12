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
    

  public function generarPDF(Request $request)
    {
        $seguras = Seguras::all();

        // Aquí puedes recibir la imagen base64 y el QR (opcionalmente)
        $mapaBase64 = $request->input('mapaBase64', null);
        $qrBase64 = $request->input('qrBase64', null);

        $pdf = PDF::loadView('seguras.pdf', compact('seguras', 'mapaBase64', 'qrBase64'))
                ->setPaper('a4', 'landscape');

        return $pdf->download('zonas_seguras.pdf');
    }
    public function enviarMapa(Request $request)
    {
        $imageBase64 = $request->input('imagen');
        $seguras = Seguras::all();

        // Generar la URL que llevará el QR
        $urlMapa = route('seguras.index');
        // Crear el QR en base64
        $qrPng = QrCode::format('png')->size(150)->generate($urlMapa);
        $qrBase64 = 'data:image/png;base64,' . base64_encode(QrCode::format('png')->size(150)->generate($urlMapa));
        Log::info('QR Base64 generado: ' . substr($qrBase64, 0, 50));
        $pdf = Pdf::loadView('seguras.pdf', [
            'seguras' => $seguras,
            'mapaBase64' => $imageBase64,
            'qrBase64' => $qrBase64
        ])->setPaper('a4', 'landscape');
        

        return Response::make($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="zonas_seguras.pdf"'
        ]);
    }
    

}
