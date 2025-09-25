@extends('template.master')

@section('contenido')
<div class="container mt-4">
    <h2>Listado de Citas</h2>

    @if($citas->isEmpty())
        <div class="alert alert-warning">
            No se encontraron citas para el RUT <strong>{{ $rutPaciente }}</strong>.
        </div>
    @else
        <p class="text-muted">
            Mostrando citas asociadas al RUT <strong>{{ $rutPaciente }}</strong>.
        </p>

        <table class="table table-bordered table-hover shadow-sm">
            <thead class="table-light">
                <tr>
                    <th>Paciente</th>
                    <th>Médico</th>
                    <th>Especialidad</th>
                    <th>Fecha y Hora</th>
                    <th>Motivo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($citas as $cita)
                    <tr>
                        <td>{{ $cita->paciente->nombre }} ({{ $cita->paciente->rutPaciente }})</td>
                        <td>{{ $cita->medico->nombreMedico }}</td>
                        <td>{{ $cita->medico->especialidad->nombreEspecialidad }}</td>
                        <td>{{ \Carbon\Carbon::parse($cita->fechaHora)->format('d/m/Y H:i') }}</td>
                        <td>{{ $cita->motivoCita }}</td>
                        <td>
                            <a href="{{ route('citas.edit', $cita->idCita) }}" class="btn btn-sm btn-primary">
                                Editar
                            </a>
                            <a href="{{ route('citas.show', $cita->idCita) }}" class="btn btn-sm btn-info">
                                Ver detalle
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="mt-3">
        <a href="{{ route('citas.buscarPorRut') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>
@endsection
