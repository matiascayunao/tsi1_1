@extends('template.secretaria')

@section('contenido')
<div class="container mt-4">
    <h2>
        @if($modo === 'detalle')
            Detalle de Pacientes
        @elseif($modo === 'actualizar')
            Actualizar Pacientes
        @else
            Eliminar Pacientes
        @endif
    </h2>

    {{-- Buscador + orden --}}
    <form method="GET" class="row g-2 mb-3">
        {{-- filtro por RUT --}}
        <div class="col-md-4">
            <input
                type="text"
                name="rut"
                class="form-control"
                placeholder="Buscar por RUT"
                value="{{ $rutBuscado }}"
            >
        </div>

        {{-- orden --}}
        <div class="col-md-4">
            <select name="orden" class="form-select">
                <option value="nombre" {{ $orden === 'nombre' ? 'selected' : '' }}>
                    Ordenar alfabéticamente (A-Z)
                </option>
                <option value="fecha" {{ $orden === 'fecha' ? 'selected' : '' }}>
                    Ordenar por fecha de creación (más nuevos primero)
                </option>
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary w-100">
                Aplicar
            </button>
        </div>
    </form>

    @if($pacientes->isEmpty())
        <div class="alert alert-warning">
            No se encontraron pacientes.
        </div>
    @else
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Nombre</th>
                    <th>RUT</th>
                    <th>Previsión</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pacientes as $paciente)
                    <tr>
                        <td>{{ $paciente->nombre }}</td>
                        <td>{{ $paciente->rutPaciente }}</td>
                        <td>{{ $paciente->prevision->nombrePrevision ?? '-' }}</td>
                        <td class="text-end">
                            @if($modo === 'detalle')
                                <a href="{{ route('pacientes.show', $paciente->rutPaciente) }}"
                                   class="btn btn-sm btn-info">
                                    Ver detalle
                                </a>
                            @elseif($modo === 'actualizar')
                                <a href="{{ route('pacientes.edit', $paciente->rutPaciente) }}"
                                   class="btn btn-sm btn-warning">
                                    Actualizar
                                </a>
                            @else {{-- eliminar --}}
                                <form action="{{ route('pacientes.destroy', $paciente->rutPaciente) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('¿Seguro que deseas eliminar este paciente?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Eliminar
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
