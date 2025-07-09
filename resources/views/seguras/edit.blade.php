@extends('layout.app')
@section('contenido')
<h1>Editar alarma segura</h1>
<form action="{{ route('seguras.update', $segura->id) }}" method="POST" id="frm_editar_segura">
   <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0qMP6QpknxzQtVxvF-JT3DVvZ00O0_7k&libraries=places&callback=initMap"></script>

@csrf
    @method('PUT')
   

    <label for="nombre"><p>Nombre</p></label>
    <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ingrese nombre" value="{{ old('nombre', $segura->nombre) }}" required>
    <br>

    <label for="tipo"><p>Tipo</p></label>
    <select name="tipo" id="tipo" class="form-control" required>
        <option value="">-----Seleccione---</option>
        <option value="PUBLICA" {{ old('tipo', $segura->tipo) == 'PUBLICA' ? 'selected' : '' }}>ALARMA PÚBLICA</option>
        <option value="PRIVADA" {{ old('tipo', $segura->tipo) == 'PRIVADA' ? 'selected' : '' }}>ALARMA PRIVADA</option>
    </select>
    <br>

    <label for="radio"><b>Radio Sonoro (metros)</b></label><br>
    <input type="number" name="radio" id="radio" class="form-control" placeholder="Ingrese radio del círculo" value="{{ old('radio', $segura->radio) }}" required>
    <br>

    <label><b>Ubicación</b></label><br>
    <div class="row">
        <div class="col-md-6">
            <b>Latitud</b>
            <input type="number" id="latitud" name="latitud" class="form-control" readonly value="{{ old('latitud', $segura->latitud) }}" required>
        </div>
        <div class="col-md-6">
            <b>Longitud</b>
            <input type="number" id="longitud" name="longitud" class="form-control" readonly value="{{ old('longitud', $segura->longitud) }}" required>
        </div>
    </div>
    <br>

    <div id="mapa1" style="border:2px solid black; height:300px; width:100%;"></div>
    <br>

    <button type="submit" class="btn btn-success">Actualizar</button>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <button type="button" onclick="graficarCirculo()" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalGraficoCirculo">
        Graficar
    </button>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="{{ route('seguras.index') }}" class="btn btn-danger">Cancelar</a>
</form>

<!-- Modal para graficar círculo -->
<div class="modal fade" id="modalGraficoCirculo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
      <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Rango Sonoro de la Alarma</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div id="mapa-circulo" style="border:2px solid blue; height:300px; width:100%;"></div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Aceptar</button>    
      </div>
      </div>
  </div>
</div>

<script type="text/javascript">
    var mapa;
    function initMap() {
        var lat = parseFloat('{{ old("latitud", $segura->latitud) }}');
        var lng = parseFloat('{{ old("longitud", $segura->longitud) }}');
        var latLngInicial = new google.maps.LatLng(lat, lng);

        mapa = new google.maps.Map(document.getElementById('mapa1'), {
            center: latLngInicial,
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var marcador = new google.maps.Marker({
            position: latLngInicial,
            map: mapa,
            title: "Seleccione la dirección",
            draggable: true
        });

        marcador.addListener('dragend', function () {
            var latitud = this.getPosition().lat();
            var longitud = this.getPosition().lng();
            document.getElementById("latitud").value = latitud;
            document.getElementById("longitud").value = longitud;
        });
    }

    function graficarCirculo(){
        var radio = parseFloat(document.getElementById('radio').value);
        var latitud = parseFloat(document.getElementById('latitud').value);
        var longitud = parseFloat(document.getElementById('longitud').value);

        var centro = new google.maps.LatLng(latitud, longitud);

        var mapaCirculo = new google.maps.Map(document.getElementById('mapa-circulo'), {
            center: centro,
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        new google.maps.Marker({
            position: centro,
            map: mapaCirculo,
            title: "Centro del Círculo",
            draggable: false
        });

        new google.maps.Circle({
            strokeColor: "red",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "blue",
            fillOpacity: 0.5,
           
            map: mapaCirculo,
            center: centro,
            radius: radio
        });
    }
</script>
@endsection
