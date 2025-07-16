@extends('layout.app')

@section('contenido')
<script async defer src="https://maps.googleapis.com/maps/api/js?key=TU_API_KEY_AQUI&libraries=places&callback=initMap"></script>

<div class="container">
    <h1 class="my-4">🗺️ Mapa de Encuentros</h1>
    
    <!-- Contenedor del Mapa -->
    <div id="map-container" class="mb-4">
        <div id="map" style="height: 600px; width: 100%; border: 1px solid #ddd; border-radius: 8px;"></div>
        <div id="map-error" class="alert alert-warning text-center py-5" style="display:none;"></div>
    </div>
</div>

<!-- Script para Google Maps -->
<script>
    // Función para inicializar el mapa
    function initMap() {
        try {
            // Verificar si hay encuentros con coordenadas
            const encuentros = @json($encuentros);
            const encuentrosConCoordenadas = encuentros.filter(e => e.latitud && e.longitud);
            
            // Si no hay coordenadas válidas
            if (encuentrosConCoordenadas.length === 0) {
                showMapError("No hay ubicaciones con coordenadas válidas para mostrar");
                return;
            }
            
            // Crear mapa centrado en la primera ubicación
            const firstLocation = encuentrosConCoordenadas[0];
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: { 
                    lat: parseFloat(firstLocation.latitud), 
                    lng: parseFloat(firstLocation.longitud) 
                },
                mapTypeId: 'roadmap',
                gestureHandling: 'cooperative'
            });

            // Crear marcadores
            addMarkers(map, encuentrosConCoordenadas);
            
            // Ajustar zoom si hay múltiples ubicaciones
            if (encuentrosConCoordenadas.length > 1) {
                fitMapToMarkers(map, encuentrosConCoordenadas);
            }

        } catch (error) {
            showMapError("Error al cargar el mapa: " + error.message);
            console.error("Google Maps Error:", error);
        }
    }

    // Función para añadir marcadores
    function addMarkers(map, encuentros) {
        encuentros.forEach(encuentro => {
            const marker = new google.maps.Marker({
                position: { 
                    lat: parseFloat(encuentro.latitud), 
                    lng: parseFloat(encuentro.longitud) 
                },
                map: map,
                title: encuentro.nombre,
                icon: {
                    url: "https://maps.google.com/mapfiles/ms/icons/red-dot.png",
                    scaledSize: new google.maps.Size(32, 32)
                }
            });

            addInfoWindow(map, marker, encuentro);
        });
    }

    // Función para añadir ventanas de información
    function addInfoWindow(map, marker, encuentro) {
        const infoWindow = new google.maps.InfoWindow({
            content: `
                <div style="min-width: 200px">
                    <h5 style="color: #007bff; margin-bottom: 5px">${encuentro.nombre}</h5>
                    <p><strong>Responsable:</strong> ${encuentro.responsable}</p>
                    <p><strong>Capacidad:</strong> ${encuentro.capacidad}</p>
                </div>
            `
        });
        
        marker.addListener('click', () => infoWindow.open(map, marker));
    }

    // Función para ajustar el zoom a todos los marcadores
    function fitMapToMarkers(map, encuentros) {
        const bounds = new google.maps.LatLngBounds();
        encuentros.forEach(encuentro => {
            bounds.extend(new google.maps.LatLng(
                parseFloat(encuentro.latitud), 
                parseFloat(encuentro.longitud)
            ));
        });
        map.fitBounds(bounds);
    }

    // Mostrar mensaje de error
    function showMapError(message) {
        document.getElementById('map').style.display = 'none';
        const errorElement = document.getElementById('map-error');
        errorElement.style.display = 'block';
        errorElement.textContent = message;
    }

    // Cargar la API de Google Maps
    function loadGoogleMaps() {
        const script = document.createElement('script');
        script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyB0qMP6QpknxzQtVxvF-JT3DVvZ00O0_7k&libraries=places&callback=initMap';
        script.async = true;
        script.defer = true;
        script.onerror = () => showMapError("Error al cargar Google Maps. Verifica tu conexión a internet.");
        document.head.appendChild(script);
    }

    // Iniciar carga cuando el DOM esté listo
    document.addEventListener('DOMContentLoaded', loadGoogleMaps);
</script>
@endsection