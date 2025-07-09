@extends('layout.app')

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-4">✏️ Editar Encuentro</h2>

    <form action="{{ route('encuentros.update', $encuentro->id) }}" method="POST">
        @csrf
        @method('PUT')

        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0qMP6QpknxzQtVxvF-JT3DVvZ00O0_7k&callback=initMap"></script>

        <div class="form-group">
            <label for="nombre"><strong>Nombre del Encuentro:</strong></label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $encuentro->nombre }}" required>
        </div>

        <div class="form-group">
            <label for="capacidad"><strong>Capacidad:</strong></label>
            <input type="number" name="capacidad" id="capacidad" class="form-control" value="{{ $encuentro->capacidad }}" required>
        </div>

        <div class="form-group">
            <label for="responsable"><strong>Responsable:</strong></label>
            <input type="text" name="responsable" id="responsable" class="form-control" value="{{ $encuentro->responsable }}" required>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="latitud"><strong>Latitud:</strong></label>
                <input type="text" name="latitud" id="latitud" class="form-control" value="{{ $encuentro->latitud }}" readonly required>
            </div>
            <div class="col-md-6">
                <label for="longitud"><strong>Longitud:</strong></label>
                <input type="text" name="longitud" id="longitud" class="form-control" value="{{ $encuentro->longitud }}" readonly required>
            </div>
        </div>

        <div class="form-group mt-4">
            <label><strong>Modificar ubicación en el mapa:</strong></label>
            <div id="mapa_cliente" style="border: 1px solid #ccc; height: 300px; width: 100%;"></div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save-fill"></i> Actualizar
            </button>
            <a href="{{ route('encuentros.index') }}" class="btn btn-secondary ml-2">
                <i class="bi bi-arrow-left-circle"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<script type="text/javascript">
    function initMap() {
        var lat = parseFloat("{{ $encuentro->latitud }}");
        var lng = parseFloat("{{ $encuentro->longitud }}");
        var centro = new google.maps.LatLng(lat, lng);

        var mapa = new google.maps.Map(document.getElementById('mapa_cliente'), {
            center: centro,
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var marcador = new google.maps.Marker({
            position: centro,
            map: mapa,
            title: "Arrastra para ajustar ubicación",
            draggable: true
        });

        google.maps.event.addListener(marcador, 'dragend', function () {
            document.getElementById("latitud").value = this.getPosition().lat();
            document.getElementById("longitud").value = this.getPosition().lng();
        });
    }
</script>
@endsection
