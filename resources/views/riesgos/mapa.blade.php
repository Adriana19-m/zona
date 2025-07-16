@extends('layout.app')

@section('contenido')
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0qMP6QpknxzQtVxvF-JT3DVvZ00O0_7k&libraries=places&callback=initMap"></script>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="text-center"><i class="fas fa-map-marked-alt"></i> Mapa de Áreas de Riesgo</h2>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div id="map" style="height: 700px; width: 100%; border: 1px solid #ddd;"></div>
            <div id="map-error" class="alert alert-warning text-center py-5" style="display:none;"></div>
            
            <!-- Leyenda de colores -->
            <div class="card mt-3">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-key"></i> Leyenda de Riesgos</h5>
                </div>
                <div class="card-body p-2">
                    <div class="row text-center">
                        <div class="col-md-3 mb-2">
                            <div class="d-flex align-items-center justify-content-center">
                                <div style="width: 20px; height: 20px; background-color: #4CAF50; border: 1px solid #388E3C; margin-right: 8px;"></div>
                                <span>Bajo</span>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="d-flex align-items-center justify-content-center">
                                <div style="width: 20px; height: 20px; background-color: #FF9800; border: 1px solid #F57C00; margin-right: 8px;"></div>
                                <span>Medio</span>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="d-flex align-items-center justify-content-center">
                                <div style="width: 20px; height: 20px; background-color: #F44336; border: 1px solid #D32F2F; margin-right: 8px;"></div>
                                <span>Alto</span>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="d-flex align-items-center justify-content-center">
                                <div style="width: 20px; height: 20px; background-color: #9C27B0; border: 1px solid #7B1FA2; margin-right: 8px;"></div>
                                <span>Crítico</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var map;
    var infoWindow;
    var polygons = [];

    // Colores para los diferentes niveles de riesgo
    const nivelColors = {
        'Bajo': { stroke: '#4CAF50', fill: '#81C784' },
        'Medio': { stroke: '#FF9800', fill: '#FFB74D' },
        'Alto': { stroke: '#F44336', fill: '#E57373' },
        'Crítico': { stroke: '#9C27B0', fill: '#BA68C8' }
    };

    function initMap() {
        try {
            // Datos de riesgos pasados desde el controlador
            const riesgos = @json($riesgos);
            
            // Filtrar riesgos con al menos 3 coordenadas válidas
            const riesgosValidos = riesgos.filter(riesgo => {
                return riesgo.coordenadas && riesgo.coordenadas.length >= 3;
            });

            if (riesgosValidos.length === 0) {
                showMapError("No hay áreas de riesgo con coordenadas suficientes para mostrar");
                return;
            }

            // Crear mapa centrado en la primera coordenada del primer riesgo
            const primeraCoordenada = riesgosValidos[0].coordenadas[0];
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 14,
                center: { 
                    lat: parseFloat(primeraCoordenada.latitud), 
                    lng: parseFloat(primeraCoordenada.longitud) 
                },
                mapTypeId: 'roadmap',
                gestureHandling: 'cooperative'
            });

            infoWindow = new google.maps.InfoWindow();

            // Dibujar todos los riesgos válidos
            riesgosValidos.forEach(riesgo => {
                dibujarRiesgo(riesgo);
            });

            // Ajustar el zoom para mostrar todos los polígonos
            ajustarZoom();

        } catch (error) {
            showMapError("Error al cargar el mapa: " + error.message);
            console.error("Error en Google Maps:", error);
        }
    }

    function dibujarRiesgo(riesgo) {
        // Convertir coordenadas a formato Google Maps
        const coordenadas = riesgo.coordenadas.map(coord => {
            return {
                lat: parseFloat(coord.latitud),
                lng: parseFloat(coord.longitud)
            };
        });

        // Obtener colores según el nivel de riesgo
        const colors = nivelColors[riesgo.nivel] || nivelColors['Bajo'];
        
        // Crear el polígono
        const polygon = new google.maps.Polygon({
            paths: coordenadas,
            strokeColor: colors.stroke,
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: colors.fill,
            fillOpacity: 0.35,
            map: map
        });

        // Guardar referencia al polígono
        polygons.push(polygon);
        
        // Calcular el centro para la ventana de información
        const bounds = new google.maps.LatLngBounds();
        coordenadas.forEach(coord => bounds.extend(coord));
        const center = bounds.getCenter();
        
        // Configurar evento click para mostrar información
        polygon.addListener('click', function() {
            mostrarInfoRiesgo(riesgo, center);
        });
    }

    function mostrarInfoRiesgo(riesgo, position) {
        const colors = nivelColors[riesgo.nivel] || nivelColors['Bajo'];
        
        const content = `
            <div style="min-width: 250px">
                <h5 style="color: ${colors.stroke}">
                    <i class="fas fa-exclamation-triangle"></i> ${riesgo.nombre}
                </h5>
                <p><strong>Nivel:</strong> <span style="color: ${colors.stroke}">${riesgo.nivel}</span></p>
                <p><strong>Descripción:</strong> ${riesgo.descripcion || 'No disponible'}</p>
            </div>
        `;
        
        infoWindow.setContent(content);
        infoWindow.setPosition(position);
        infoWindow.open(map);
    }

    function ajustarZoom() {
        const bounds = new google.maps.LatLngBounds();
        
        polygons.forEach(polygon => {
            polygon.getPath().forEach(coord => {
                bounds.extend(coord);
            });
        });
        
        map.fitBounds(bounds);
        
        // Limitar el zoom máximo
        if (map.getZoom() > 15) {
            map.setZoom(15);
        }
    }

    function showMapError(message) {
        document.getElementById('map').style.display = 'none';
        const errorElement = document.getElementById('map-error');
        errorElement.style.display = 'block';
        errorElement.innerHTML = `
            <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
            <h4>${message}</h4>
        `;
    }
</script>

<style>
    #map {
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .container-fluid {
        padding: 20px;
    }
    h2 {
        color: #343a40;
        margin-bottom: 20px;
    }
    .leyenda-item {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
    }
    .leyenda-color {
        width: 20px;
        height: 20px;
        margin-right: 10px;
        border: 1px solid #ddd;
    }
</style>
@endsection