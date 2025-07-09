@extends('layout.app')

@section('contenido')
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyXXX1234567890abcdef&callback=initMapaZonas"></script>


<div class="container mt-4">
    <h1 class="mb-4">Listado de Zonas Seguras</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('seguras.create') }}" class="btn btn-primary mb-3">➕ Registrar Nueva Zona</a>

    <!-- Mapa de Zonas -->
    <div id="mapaZonas" style="height: 500px; width: 100%; border: 2px solid black;"></div>

    <br>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Radio (m)</th>
                    <th>Latitud</th>
                    <th>Longitud</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($seguras as $zona)
                    <tr>
                        <td>{{ $zona->id }}</td>
                        <td>{{ $zona->nombre }}</td>
                        <td class="text-center">
                            @if($zona->tipo == 'PUBLICA')
                                <span class="badge bg-success">🍀ZONA SEGURA</span>
                            @else
                                <span class="badge bg-danger">🔥ZONA EN RIESGO</span>
                            @endif
                        </td>
                        <td class="text-center">{{ number_format($zona->radio, 2) }}</td>
                        <td>{{ $zona->latitud }}</td>
                        <td>{{ $zona->longitud }}</td>
                        <td class="text-center">
                            <a href="{{ route('seguras.edit', $zona->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('seguras.destroy', $zona->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar esta zona segura?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay zonas seguras registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Cargar Google Maps JS --}}
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=TU_API_KEY&callback=initMapaZonas">
</script>

<script>
    function initMapaZonas() {
        var centro = { lat: -0.9374805, lng: -78.6161327 };
        var mapa = new google.maps.Map(document.getElementById('mapaZonas'), {
            zoom: 13,
            center: centro,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        const zonas = @json($seguras);

        zonas.forEach(zona => {
            let centro = { lat: parseFloat(zona.latitud), lng: parseFloat(zona.longitud) };

            let color = zona.tipo === 'PUBLICA' ? '#28a745' : '#dc3545'; // verde o rojo

            // Dibuja círculo
            new google.maps.Circle({
                strokeColor: color,
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: color,
                fillOpacity: 0.35,
                map: mapa,
                center: centro,
                radius: parseFloat(zona.radio)
            });

            // Agrega marcador con nombre
            new google.maps.Marker({
                position: centro,
                map: mapa,
                title: zona.nombre
            });
        });
    }
</script>
@endsection
