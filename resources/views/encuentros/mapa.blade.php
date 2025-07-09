@extends('layout.app')

@section('contenido')
<br>
<h1>📌 Mapa de Encuentros</h1>
<br>
<div id="mapa-encuentros" style="border:2px solid black; height:500px; width:100%;"></div>

{{-- Cargar la API de Google Maps --}}
<script async defer src="https://maps.googleapis.com/maps/api/js?key=TU_API_KEY_AQUI&callback=initMap"></script>

<script type="text/javascript">
    function initMap() {
        var centro = new google.maps.LatLng(-0.9374805, -78.6161327); // Coordenadas de ejemplo
        var mapa = new google.maps.Map(document.getElementById('mapa-encuentros'), {
            center: centro,
            zoom: 10,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        @foreach($encuentros as $encuentro)
            var coordenada = new google.maps.LatLng({{ $encuentro->latitud }}, {{ $encuentro->longitud }});
            var marcador = new google.maps.Marker({
                position: coordenada,
                map: mapa,
                icon: {
                    url: "https://cdn-icons-png.flaticon.com/512/854/854866.png", // Ícono personalizado
                    scaledSize: new google.maps.Size(40, 40),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(20, 40)
                },
                title: "{{ $encuentro->nombre }} (Capacidad: {{ $encuentro->capacidad }})"
            });

            // Información al hacer clic
            var info = new google.maps.InfoWindow({
                content: `<strong>{{ $encuentro->nombre }}</strong><br>
                          Responsable: {{ $encuentro->responsable }}<br>
                          Capacidad: {{ $encuentro->capacidad }}`
            });

            marcador.addListener('click', function () {
                info.open(mapa, marcador);
            });
        @endforeach
    }
</script>
@endsection
