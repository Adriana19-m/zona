<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Zonas Seguras</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #2c3e50; text-align: center; }
        .map-container { 
            width: 100%; 
            height: 400px; 
            margin: 20px 0;
            background-color: #f5f5f5;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .badge { padding: 5px 10px; border-radius: 3px; color: white; }
        .safe { background-color: #28a745; }
        .risk { background-color: #dc3545; }
    </style>
</head>
<body>
    <h1>📍 Reporte de Zonas Seguras</h1>
    
    <!-- Mapa estático (versión simplificada) -->
    <div class="map-container">
        <div>
            <p><strong>Mapa de Zonas</strong></p>
            <p>Este reporte incluye {{ count($seguras) }} zonas registradas</p>
            @foreach($coordenadas as $coord)
                <p>Zona {{ $loop->iteration }}: {{ $coord['lat'] }}, {{ $coord['lng'] }}</p>
            @endforeach
        </div>
    </div>
    
    <!-- Tabla de datos -->
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
                <tr>
                    <td>{{ $zona->id }}</td>
                    <td>{{ $zona->nombre }}</td>
                    <td>
                        @if($zona->tipo == 'PUBLICA')
                            <span class="badge safe">ZONA SEGURA</span>
                        @else
                            <span class="badge risk">ZONA EN RIESGO</span>
                        @endif
                    </td>
                    <td>{{ number_format($zona->radio, 2) }}</td>
                    <td>{{ $zona->latitud }}</td>
                    <td>{{ $zona->longitud }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>