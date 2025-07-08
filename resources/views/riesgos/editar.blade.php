@extends('layout.app')
@section('contenido')
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0qMP6QpknxzQtVxvF-JT3DVvZ00O0_7k&libraries=places&callback=initMap"></script>

<div class='row'>
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <form action="{{ route('riesgos.update', $riesgo->id) }}" method="POST">
            @csrf
            @method('PUT')
            <h3><b>Editar Riesgo</b></h3>
            <hr>
            
            <label for=""><b>Nombre del Riesgo:</b></label><br>
            <input type="text" name="nombre" id="nombre"
                   class="form-control" value="{{ $riesgo->nombre }}" required><br>

            <label for=""><b>Descripción:</b></label><br>
            <textarea name="descripcion" id="descripcion" 
                      class="form-control" rows="3">{{ $riesgo->descripcion }}</textarea><br>

            <label for=""><b>Nivel de Riesgo:</b></label>
            <select name="nivel" id="nivel" class="form-control" required>
                <option value="">Seleccione el nivel...</option>
                <option value="Bajo" {{ $riesgo->nivel == 'Bajo' ? 'selected' : '' }}>Bajo</option>
                <option value="Medio" {{ $riesgo->nivel == 'Medio' ? 'selected' : '' }}>Medio</option>
                <option value="Alto" {{ $riesgo->nivel == 'Alto' ? 'selected' : '' }}>Alto</option>
                <option value="Crítico" {{ $riesgo->nivel == 'Crítico' ? 'selected' : '' }}>Crítico</option>
            </select><br>

            {{-- Coordenadas del polígono --}}
            @for ($i = 1; $i <= 4; $i++)
            <div class="row">
                <div class="col-md-5">
                    <label for=""><b>COORDENADA N° {{ $i }}</b></label><br>
                    <label for=""><b>Latitud:</b></label><br>
                    <input type="number" step="any" name="latitud{{ $i }}" id="latitud{{ $i }}"
                           class="form-control" value="{{ $riesgo->{'latitud'.$i} ?? '' }}" readonly><br>
                    <label for=""><b>Longitud:</b></label><br>
                    <input type="number" step="any" name="longitud{{ $i }}" id="longitud{{ $i }}"
                           class="form-control" value="{{ $riesgo->{'longitud'.$i} ?? '' }}" readonly>
                </div>
                <div class="col-md-7">
                    <div id="mapa{{ $i }}" style="height:180px; width:100%; border:2px solid black;"></div>
                </div>
            </div>
            <br>
            @endfor

            <center>
                <button class="btn btn-success">Actualizar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="{{ route('riesgos.index') }}" class="btn btn-secondary">Cancelar</a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-primary" onclick="graficarRiesgo();">
                    Graficar Área de Riesgo
                </button>
            </center>
        </form>
    </div>
</div>

<br>
<div class="row">
    <div class="col-md-12">
        <div id="mapa-poligono" style="height:500px; width:100%; border:2px solid blue;"></div>
    </div>
</div>

<script>
    var mapaPoligono;

    function initMap() {
        const defaultCenter = { lat: -0.9374805, lng: -78.6161327 };

        // Crear mapas para cada coordenada
        for (let i = 1; i <= 4; i++) {
            // Obtener coordenadas existentes o usar por defecto
            let lat = parseFloat(document.getElementById(`latitud${i}`).value) || defaultCenter.lat;
            let lng = parseFloat(document.getElementById(`longitud${i}`).value) || defaultCenter.lng;
            let coord = new google.maps.LatLng(lat, lng);

            let mapa = new google.maps.Map(document.getElementById(`mapa${i}`), {
                center: coord,
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            let marcador = new google.maps.Marker({
                position: coord,
                map: mapa,
                title: `Seleccione la coordenada ${i}`,
                draggable: true,
                icon: {
                    url: getRiskMarkerColor(i)
                }
            });

            // Usar closure para capturar el valor de i
            (function(index) {
                google.maps.event.addListener(marcador, 'dragend', function () {
                    document.getElementById(`latitud${index}`).value = this.getPosition().lat();
                    document.getElementById(`longitud${index}`).value = this.getPosition().lng();
                });

                // Evento de clic en el mapa
                google.maps.event.addListener(mapa, 'click', function(event) {
                    marcador.setPosition(event.latLng);
                    document.getElementById(`latitud${index}`).value = event.latLng.lat();
                    document.getElementById(`longitud${index}`).value = event.latLng.lng();
                });
            })(i);
        }

        // Mapa del polígono
        mapaPoligono = new google.maps.Map(document.getElementById("mapa-poligono"), {
            zoom: 15,
            center: defaultCenter,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        // Dibujar polígono inicial si hay coordenadas
        setTimeout(graficarRiesgo, 500);
    }

    function getRiskMarkerColor(coordNum) {
        const colors = [
            "https://maps.google.com/mapfiles/ms/icons/red-dot.png",
            "https://maps.google.com/mapfiles/ms/icons/blue-dot.png", 
            "https://maps.google.com/mapfiles/ms/icons/green-dot.png",
            "https://maps.google.com/mapfiles/ms/icons/yellow-dot.png"
        ];
        return colors[(coordNum - 1) % colors.length];
    }

    function getPolygonColorByLevel(nivel) {
        switch(nivel) {
            case 'Bajo':
                return { stroke: "#4CAF50", fill: "#81C784" }; // Verde
            case 'Medio':
                return { stroke: "#FF9800", fill: "#FFB74D" }; // Naranja
            case 'Alto':
                return { stroke: "#F44336", fill: "#E57373" }; // Rojo
            case 'Crítico':
                return { stroke: "#9C27B0", fill: "#BA68C8" }; // Púrpura
            default:
                return { stroke: "#2196F3", fill: "#64B5F6" }; // Azul
        }
    }

    function graficarRiesgo() {
        // Limpiar polígonos anteriores
        mapaPoligono = new google.maps.Map(document.getElementById("mapa-poligono"), {
            zoom: 15,
            center: new google.maps.LatLng(-0.9374805, -78.6161327),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        // Capturar coordenadas
        const coords = [];
        let coordenadasValidas = 0;

        for (let i = 1; i <= 4; i++) {
            let lat = parseFloat(document.getElementById(`latitud${i}`).value);
            let lng = parseFloat(document.getElementById(`longitud${i}`).value);
            
            if (!isNaN(lat) && !isNaN(lng)) {
                coords.push(new google.maps.LatLng(lat, lng));
                coordenadasValidas++;
            }
        }

        if (coordenadasValidas < 3) {
            console.log("Se necesitan al menos 3 coordenadas para formar un polígono.");
            return;
        }

        // Obtener nivel y colores
        var nivel = document.getElementById('nivel').value;
        var colores = getPolygonColorByLevel(nivel);

        // Crear polígono
        let poligono = new google.maps.Polygon({
            paths: coords,
            strokeColor: colores.stroke,
            strokeOpacity: 0.8,
            strokeWeight: 3,
            fillColor: colores.fill,
            fillOpacity: 0.4
        });

        poligono.setMap(mapaPoligono);

        // Agregar marcadores en cada vértice
        coords.forEach(function(coord, index) {
            new google.maps.Marker({
                position: coord,
                map: mapaPoligono,
                title: `Coordenada ${index + 1}`,
                icon: {
                    url: getRiskMarkerColor(index + 1),
                    scaledSize: new google.maps.Size(25, 25)
                }
            });
        });

        // Centrar mapa en el polígono
        if (coords.length > 0) {
            var bounds = new google.maps.LatLngBounds();
            coords.forEach(function(coord) {
                bounds.extend(coord);
            });
            
            var centro = bounds.getCenter();
            mapaPoligono.setCenter(centro);
            mapaPoligono.fitBounds(bounds);

            // Agregar etiqueta informativa
            var nombre = document.getElementById('nombre').value || 'Área de Riesgo';
            var infoWindow = new google.maps.InfoWindow({
                content: `<div style="text-align: center;">
                            <strong>${nombre}</strong><br>
                            <span style="color: ${colores.stroke};">Nivel: ${nivel || 'No definido'}</span><br>
                            <small>Coordenadas: ${coordenadasValidas}</small>
                          </div>`,
                position: centro
            });
            
            // Mostrar info al hacer clic en el polígono
            google.maps.event.addListener(poligono, 'click', function() {
                infoWindow.open(mapaPoligono);
            });
        }
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('nivel').addEventListener('change', graficarRiesgo);
        document.getElementById('nombre').addEventListener('input', graficarRiesgo);
    });
</script>

@endsection