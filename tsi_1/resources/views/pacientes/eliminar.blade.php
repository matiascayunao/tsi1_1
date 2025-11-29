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

    {{-- Buscador por RUT --}}
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text"
                   name="rut"
                   class="form-control"
                   placeholder="Buscar por RUT"
                   value="{{ $rutBuscado }}">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Buscar</button>
        </div>
    </form>

    @if($pacientes->isEmpty())
        <div class="alert alert-warning">No se encontraron pacientes.</div>
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
                           
                                <form action="{{ route('pacientes.listado', $paciente->rutPaciente) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('¿Seguro que deseas eliminar este paciente?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Eliminar
                                    </button>
                                </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
