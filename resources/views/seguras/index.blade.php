@extends('layout.app')

@section('contenido')
<div class="container mt-4">
    <h1 class="mb-4">Listado de Zonas Seguras</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('seguras.create') }}" class="btn btn-primary mb-3">➕ Registrar Nueva Zona</a>

    <!-- Mapa de Zonas - Versión corregida -->
    <div id="mapaZonas" style="height: 500px; width: 100%; border: 2px solid black; margin-bottom: 20px;"></div>
    <div id="map-error" style="display: none;" class="alert alert-danger"></div>

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

<script>
    // Función para cargar Google Maps de forma segura
    function loadGoogleMaps() {
        // Verificar si ya está cargado
        if (window.google && window.google.maps) {
            initMapaZonas();
            return;
        }

        const script = document.createElement('script');
        script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyB0qMP6QpknxzQtVxvF-JT3DVvZ00O0_7k&libraries=places&callback=initMapaZonas';
        script.async = true;
        script.defer = true;
        script.onerror = function() {
            document.getElementById('map-error').style.display = 'block';
            document.getElementById('map-error').textContent = 'Error al cargar Google Maps. Por favor recarga la página.';
        };
        document.head.appendChild(script);
    }

    // Función principal del mapa
    function initMapaZonas() {
        try {
            const zonas = @json($seguras);
            
            // Si no hay zonas, mostrar mensaje
            if (zonas.length === 0) {
                document.getElementById('mapaZonas').style.display = 'none';
                document.getElementById('map-error').style.display = 'block';
                document.getElementById('map-error').textContent = 'No hay zonas para mostrar en el mapa';
                return;
            }

            // Coordenadas iniciales (primera zona o centro por defecto)
            const primeraZona = zonas[0];
            const centro = primeraZona ? 
                { lat: parseFloat(primeraZona.latitud), lng: parseFloat(primeraZona.longitud) } : 
                { lat: -0.9374805, lng: -78.6161327 };

            // Crear mapa
            const mapa = new google.maps.Map(document.getElementById('mapaZonas'), {
                zoom: 13,
                center: centro,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            // Añadir cada zona al mapa
            zonas.forEach(zona => {
                const centroZona = { 
                    lat: parseFloat(zona.latitud), 
                    lng: parseFloat(zona.longitud) 
                };

                // Configuración según tipo de zona
                const color = zona.tipo === 'PUBLICA' ? '#28a745' : '#dc3545';
                const icono = zona.tipo === 'PUBLICA' ? 
                    'https://maps.google.com/mapfiles/ms/icons/green-dot.png' : 
                    'https://maps.google.com/mapfiles/ms/icons/red-dot.png';

                // Círculo de la zona
                new google.maps.Circle({
                    strokeColor: color,
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: color,
                    fillOpacity: 0.35,
                    map: mapa,
                    center: centroZona,
                    radius: parseFloat(zona.radio)
                });

                // Marcador
                const marcador = new google.maps.Marker({
                    position: centroZona,
                    map: mapa,
                    title: zona.nombre,
                    icon: icono
                });

                // Ventana de información
                const infoWindow = new google.maps.InfoWindow({
                    content: `
                        <div style="min-width: 200px">
                            <h5 style="color: ${color}">${zona.nombre}</h5>
                            <p><strong>Tipo:</strong> ${zona.tipo}</p>
                            <p><strong>Radio:</strong> ${zona.radio} m</p>
                        </div>
                    `
                });

                marcador.addListener('click', () => infoWindow.open(mapa, marcador));
            });

        } catch (error) {
            console.error('Error en el mapa:', error);
            document.getElementById('map-error').style.display = 'block';
            document.getElementById('map-error').textContent = 'Error al mostrar el mapa: ' + error.message;
        }
    }

    // Cargar el mapa cuando la página esté lista
    document.addEventListener('DOMContentLoaded', loadGoogleMaps);
</script>
@endsection