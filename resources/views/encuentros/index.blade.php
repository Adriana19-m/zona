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
    <a href="{{ route('encuentros.mapa') }}" class="btn btn-success mb-3">🗺️ Ver Mapa Global</a>

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
@endsection
