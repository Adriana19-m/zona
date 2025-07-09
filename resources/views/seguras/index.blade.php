@extends('layout.app')
@section('contenido')
    <div class="container mt-4">
        <h1 class="mb-4">Listado de Zonas Seguras</h1>

        {{-- Mensajes de éxito --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('seguras.create') }}" class="btn btn-primary mb-3">➕ Registrar Nueva Zona</a>
        &nbsp;&nbsp;&nbsp;&nbsp;

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Radio (m)</th>
                        <th>Latitud</th>
                        <th>Longitud</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($seguras as $zona)
                        <tr>
                            <td>{{ $zona->id }}</td>
                            <td>{{ $zona->nombre }}</td>
                            <td class="text-center">
                                @if($zona->tipo == 'PUBLICA')
                                    <span class="badge bg-success">🍀ZONA SEGURA</span>
                                @else
                                    <span class="badge bg-info">🔥ZONA EN RIESGO</span>
                                @endif
                            </td>
                            <td class="text-center">{{ number_format($zona->radio, 2) }}</td>
                            <td>{{ $zona->latitud }}</td>
                            <td>{{ $zona->longitud }}</td>
                            <td class="text-center">
                                <a href="{{ route('seguras.edit', $zona->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('seguras.destroy', $zona->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar esta zona segura?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No hay zonas seguras registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection