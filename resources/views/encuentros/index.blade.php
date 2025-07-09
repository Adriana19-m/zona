@extends('layout.app')

@section('contenido')
<div class="container mt-4">
    <h1 class="mb-4">📋 Listado de Encuentros</h1>

    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('encuentros.create') }}" class="btn btn-primary mb-3">➕ Agregar nuevo encuentro</a>
    &nbsp;&nbsp;&nbsp;
    

    {{-- Contenedor del Mapa --}}
    <div id="map" style="height: 500px; width: 100%; margin-bottom: 20px;"></div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Capacidad</th>
                    <th>Responsable</th>
                    <th>Latitud</th>
                    <th>Longitud</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($encuentros as $encuentro)
                    <tr>
                        <td>{{ $encuentro->id }}</td>
                        <td>{{ $encuentro->nombre }}</td>
                        <td>{{ $encuentro->capacidad }}</td>
                        <td>{{ $encuentro->responsable }}</td>
                        <td>{{ $encuentro->latitud }}</td>
                        <td>{{ $encuentro->longitud }}</td>
                        <td>
                            <a href="{{ route('encuentros.edit', $encuentro->id) }}" class="btn btn-sm btn-warning">Editar</a>

                            <form action="{{ route('encuentros.destroy', $encuentro->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro de eliminar este encuentro?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                @if($encuentros->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center">No hay encuentros registrados.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

{{-- Scripts para Google Maps --}}
<script>
    function initMap() {
        // Coordenadas iniciales (centro del mapa)
        const center = { lat: -34.397, lng: 150.644 };
        
        // Crear mapa
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 4,
            center: center,
        });

        // Añadir marcadores para cada encuentro
        @foreach($encuentros as $encuentro)
            @if($encuentro->latitud && $encuentro->longitud)
                new google.maps.Marker({
                    position: { lat: {{ $encuentro->latitud }}, lng: {{ $encuentro->longitud }} },
                    map: map,
                    title: "{{ $encuentro->nombre }}"
                });
            @endif
        @endforeach

        // Ajustar el zoom y centro para mostrar todos los marcadores
        if ({{ count($encuentros) }} > 0) {
            const bounds = new google.maps.LatLngBounds();
            @foreach($encuentros as $encuentro)
                @if($encuentro->latitud && $encuentro->longitud)
                    bounds.extend(new google.maps.LatLng({{ $encuentro->latitud }}, {{ $encuentro->longitud }}));
                @endif
            @endforeach
            map.fitBounds(bounds);
        }
    }
</script>

<script async defer 
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0qMP6QpknxzQtVxvF-JT3DVvZ00O0_7k&libraries=places&callback=initMap">
</script>
@endsection