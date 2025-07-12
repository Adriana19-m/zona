<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Zonas Seguras</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { color: #2c3e50; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .segura { background-color: #d4edda; color: #155724; }
        .riesgo { background-color: #f8d7da; color: #721c24; }
        .mapa-img { display: block; margin: 0 auto; margin-top: 20px; max-width: 100%; }
        .fecha { text-align: center; font-size: 14px; margin-top: 10px; }
    </style>
</head>
<body>
    <h1>Reporte de Zonas Seguras</h1>
    <p class="fecha">Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}</p>

    {{-- Mostrar imagen del mapa si existe --}}
    @if(isset($mapaBase64))
        <img src="{{ $mapaBase64 }}" class="mapa-img" alt="Mapa de zonas seguras">
    @endif
    @if(isset($qrBase64))
    <img src="{{ $qrBase64 }}" style="display:block; margin:20px auto 0 auto; width:150px;" alt="QR del mapa">
    <p style="text-align:center; font-size:12px;">Escanea para ver el mapa en línea</p>
@endif


    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Radio (m)</th>
                <th>Latitud</th>
                <th>Longitud</th>
            </tr>
        </thead>
        <tbody>
            @foreach($seguras as $zona)
                <tr class="{{ $zona->tipo == 'PUBLICA' ? 'segura' : 'riesgo' }}">
                    <td>{{ $zona->id }}</td>
                    <td>{{ $zona->nombre }}</td>
                    <td>{{ $zona->tipo == 'PUBLICA' ? 'ZONA SEGURA' : 'ZONA EN RIESGO' }}</td>
                    <td>{{ number_format($zona->radio, 2) }}</td>
                    <td>{{ $zona->latitud }}</td>
                    <td>{{ $zona->longitud }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
