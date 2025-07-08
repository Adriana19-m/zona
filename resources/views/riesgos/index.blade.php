@extends('layout.app')

@section('contenido')
    <div class="container mt-4">
        <h1 class="mb-4">Listado de Riesgos</h1>

        {{-- Mensajes de éxito --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('riesgos.create') }}" class="btn btn-primary mb-3">➕ Agregar Nuevo Riesgo</a>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="{{ route('riesgos.mapa') }}" class="btn btn-success mb-3">Ver Mapa Global</a>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Nivel</th>
                        <th>Coordenadas</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riesgos as $riesgo)
                        <tr>
                            <td>{{ $riesgo->id }}</td>
                            <td>{{ $riesgo->nombre }}</td>
                            <td>{{ Str::limit($riesgo->descripcion, 50) }}</td>
                            <td>
                                <span class="badge 
                                    @if($riesgo->nivel == 'Bajo') bg-success
                                    @elseif($riesgo->nivel == 'Medio') bg-warning
                                    @elseif($riesgo->nivel == 'Alto') bg-danger
                                    @elseif($riesgo->nivel == 'Crítico') bg-dark
                                    @else bg-secondary
                                    @endif">
                                    {{ $riesgo->nivel }}
                                </span>
                            </td>
                            <td>
                                <small>
                                    @php
                                        $coordenadas = collect([
                                            $riesgo->latitud1, $riesgo->latitud2, 
                                            $riesgo->latitud3, $riesgo->latitud4
                                        ])->filter()->count();
                                    @endphp
                                    {{ $coordenadas }} coordenada{{ $coordenadas != 1 ? 's' : '' }}
                                </small>
                            </td>
                            <td>
                                @if($coordenadas >= 3)
                                    <span class="badge bg-info">Polígono</span>
                                @elseif($coordenadas >= 1)
                                    <span class="badge bg-secondary">Punto</span>
                                @else
                                    <span class="badge bg-light text-dark">Sin coordenadas</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('riesgos.edit', $riesgo->id) }}" class="btn btn-sm btn-warning me-1">Editar</a>
                                <form action="{{ route('riesgos.destroy', $riesgo->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este riesgo?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No hay riesgos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection