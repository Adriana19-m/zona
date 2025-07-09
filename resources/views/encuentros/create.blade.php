@extends('layout.app')

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-4">📌 Registrar Nuevo Encuentro</h2>

    <form action="{{ route('encuentros.store') }}" method="POST">
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0qMP6QpknxzQtVxvF-JT3DVvZ00O0_7k&callback=initMap"></script>

        @csrf

        <div class="form-group">
            <label for="nombre"><strong>Nombre del Encuentro:</strong></label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="capacidad"><strong>Capacidad:</strong></label>
            <input type="number" name="capacidad" id="capacidad" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="responsable"><strong>Responsable:</strong></label>
            <input type="text" name="responsable" id="responsable" class="form-control" required>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="latitud"><strong>Latitud:</strong></label>
                <input type="text" name="latitud" id="latitud" class="form-control" readonly required>
            </div>
            <div class="col-md-6">
                <label for="longitud"><strong>Longitud:</strong></label>
                <input type="text" name="longitud" id="longitud" class="form-control" readonly required>
            </div>
        </div>

        <div class="form-group mt-4">
            <label><strong>Seleccione la ubicación en el mapa:</strong></label>
            <div id="mapa_cliente" style="border: 1px solid #ccc; height: 300px; width: 100%;"></div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle-fill"></i> Guardar
            </button>
            <a href="{{ route('encuentros.index') }}" class="btn btn-secondary ml-2">
                <i class="bi bi-x-circle"></i> Cancelar
            </a>
        </div>
    </form>
</div>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0qMP6QpknxzQtVxvF-JT3DVvZ00O0_7k&libraries=places&callback=initMap"></script>

<script type="text/javascript">
    function initMap() {
        var centro = new google.maps.LatLng(-0.9374805, -78.6161327);
        var mapa = new google.maps.Map(document.getElementById('mapa_cliente'), {
            center: centro,
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var marcador = new google.maps.Marker({
            position: centro,
            map: mapa,
            title: "Arrastra para ubicar",
            draggable: true
        });

        google.maps.event.addListener(marcador, 'dragend', function () {
            document.getElementById("latitud").value = this.getPosition().lat();
            document.getElementById("longitud").value = this.getPosition().lng();
        });
    }
</script>
@endsection
