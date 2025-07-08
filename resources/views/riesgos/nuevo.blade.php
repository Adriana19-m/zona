@extends('layout.app')
@section('contenido')
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0qMP6QpknxzQtVxvF-JT3DVvZ00O0_7k&libraries=places&callback=initMap"></script>

<div class='row'>
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <form action="{{ route('riesgos.store') }}" method="POST">
            @csrf
            <h3><b>Registrar Nuevo Riesgo</b></h3>
            <hr>
            
            <label for=""><b>Nombre del Riesgo:</b></label> <br>
            <input type="text" name="nombre" id="nombre" 
                   placeholder="Ingrese el nombre del riesgo..."
                   required class="form-control"> <br>
            
            <label for=""><b>Descripción:</b></label> <br>
            <textarea name="descripcion" id="descripcion" 
                      class="form-control" rows="3" 
                      placeholder="Describa el riesgo..."></textarea> <br>
            
            <label for=""><b>Nivel de Riesgo:</b></label>
            <select name="nivel" id="nivel" class="form-control" required>
                <option value="">Seleccione el nivel...</option>
                <option value="Bajo">Bajo</option>
                <option value="Medio">Medio</option>
                <option value="Alto">Alto</option>
                <option value="Crítico">Crítico</option>
            </select> <br>
            
            {{-- Coordenadas del polígono --}}
            @for ($i = 1; $i <= 4; $i++)
            <div class="row">
                <div class="col-md-5">
                    <label for=""><b>COORDENADA N° {{ $i }}</b></label> <br>
                    <label for=""><b>Latitud:</b></label><br>
                    <input type="number" step="any" name="latitud{{ $i }}" id="latitud{{ $i }}"
                    class="form-control" readonly placeholder="Seleccione ..."><br>
                    <label for=""><b>Longitud:</b></label><br>
                    <input type="number" step="any" name="longitud{{ $i }}" id="longitud{{ $i }}"
                    class="form-control" readonly placeholder="Seleccione ...">
                </div>
                <div class="col-md-7">
                    <div id="mapa{{ $i }}" style="height:180px; 
                    width:100%; border:2px solid black;"></div>
                </div>
            </div>
            <br>
            @endfor

            <center>
                <button class="btn btn-success">
                    Guardar Riesgo
                </button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="reset" class="btn btn-danger">
                    Limpiar
                </button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-primary" 
                    onclick="graficarRiesgo();">
                    Graficar Área de Riesgo
                </button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="{{ route('riesgos.index') }}" class="btn btn-secondary">
                    Cancelar
                </a>
            </center>
        </form>
    </div>
</div>

<br>
<div class="row">
    <div class="col-md-12">
        <div id="mapa-poligono" 
         style="height:500px; width:100%;
          border:2px solid blue;">
        </div>
    </div>
</div>

<script type="text/javascript">
    var mapaPoligono; // Variable Global

    function initMap(){
        var latitud_longitud = new google.maps.LatLng(-0.9374805, -78.6161327);

        // Crear mapas para cada coordenada
        for (let i = 1; i <= 4; i++) {
            var mapa = new google.maps.Map(
                document.getElementById(`mapa${i}`),
                {
                    center: latitud_longitud,
                    zoom: 15,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
            );

            var marcador = new google.maps.Marker({
                position: latitud_longitud,
                map: mapa,
                title: `Seleccione la coordenada ${i}`,
                draggable: true,
                icon: {
                    url: getRiskMarkerColor(i)
                }
            });

            // Usar closure para capturar el valor de i
            (function(index) {
                google.maps.event.addListener(marcador, 'dragend', function(event) {
                    var latitud = this.getPosition().lat();
                    var longitud = this.getPosition().lng();
                    document.getElementById(`latitud${index}`).value = latitud;
                    document.getElementById(`longitud${index}`).value = longitud;
                });

                // Evento de clic en el mapa
                google.maps.event.addListener(mapa, 'click', function(event) {
                    marcador.setPosition(event.latLng);
                    document.getElementById(`latitud${index}`).value = event.latLng.lat();
                    document.getElementById(`longitud${index}`).value = event.latLng.lng();
                });
            })(i);
        }

        // Mapa del polígono de riesgo
        mapaPoligono = new google.maps.Map(
            document.getElementById("mapa-poligono"), {
                zoom: 15,
                center: latitud_longitud, 
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
        );
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

    function graficarRiesgo(){
        // Limpiar polígonos anteriores
        mapaPoligono = new google.maps.Map(
            document.getElementById("mapa-poligono"), {
                zoom: 15,
                center: new google.maps.LatLng(-0.9374805, -78.6161327), 
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
        );

        // Capturar coordenadas seleccionadas
        var coordenadas = [];
        var coordenadasValidas = 0;

        for (let i = 1; i <= 4; i++) {
            var lat = parseFloat(document.getElementById(`latitud${i}`).value);
            var lng = parseFloat(document.getElementById(`longitud${i}`).value);
            
            if (!isNaN(lat) && !isNaN(lng)) {
                coordenadas.push(new google.maps.LatLng(lat, lng));
                coordenadasValidas++;
            }
        }

        if (coordenadasValidas < 3) {
            alert("Debe seleccionar al menos 3 coordenadas para formar un área de riesgo.");
            return;
        }

        // Obtener nivel de riesgo para el color
        var nivel = document.getElementById('nivel').value;
        var colores = getPolygonColorByLevel(nivel);

        // Crear el polígono de riesgo
        var poligono = new google.maps.Polygon({
            paths: coordenadas,
            strokeColor: colores.stroke,
            strokeOpacity: 0.8,
            strokeWeight: 3,
            fillColor: colores.fill,
            fillOpacity: 0.4,
        });

        poligono.setMap(mapaPoligono);

        // Agregar marcadores en cada vértice
        coordenadas.forEach(function(coord, index) {
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

        // Calcular el centro del polígono para colocar etiqueta
        if (coordenadas.length > 0) {
            var bounds = new google.maps.LatLngBounds();
            coordenadas.forEach(function(coord) {
                bounds.extend(coord);
            });
            
            var centro = bounds.getCenter();
            mapaPoligono.setCenter(centro);

            // Agregar etiqueta del riesgo
            var nombre = document.getElementById('nombre').value || 'Área de Riesgo';
            var infoWindow = new google.maps.InfoWindow({
                content: `<div style="text-align: center;">
                            <strong>${nombre}</strong><br>
                            <span style="color: ${colores.stroke};">Nivel: ${nivel || 'No definido'}</span>
                          </div>`,
                position: centro
            });
            
            // Mostrar info window al hacer clic en el polígono
            google.maps.event.addListener(poligono, 'click', function() {
                infoWindow.open(mapaPoligono);
            });
        }
    }

    // Actualizar colores cuando cambie el nivel
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('nivel').addEventListener('change', function() {
            // Si ya hay un polígono dibujado, redibujarlo con nuevos colores
            var lat1 = document.getElementById('latitud1').value;
            if (lat1) {
                graficarRiesgo();
            }
        });
    });
</script>

@endsection