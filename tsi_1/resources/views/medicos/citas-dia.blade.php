@extends('template.medico')

@section('contenido')
<div class="container mt-4">
    <h2>Citas del día {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}</h2>

    @if($citas->isEmpty())
        <div class="alert alert-warning mt-3">
            No tienes citas agendadas para este día.
        </div>
    @else
        <table class="table table-hover mt-3">
            <thead class="table-light">
                <tr>
                    <th>Hora</th>
                    <th>Paciente</th>
                    <th>Previsión</th>
                    <th>Motivo</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($citas as $cita)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($cita->fechaHora)->format('H:i') }}</td>
                        <td>{{ $cita->paciente->nombre }} ({{ $cita->paciente->rutPaciente }})</td>
                        <td>{{ $cita->paciente->prevision->nombrePrevision ?? '-' }}</td>
                        <td>{{ $cita->motivoCita }}</td>
                        <td class="text-end">
                            <a href="{{ route('citas.show', $cita->idCita) }}"
                               class="btn btn-sm btn-outline-primary">
                                Ver detalle
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('medico.citas', [
            'mes'  => \Carbon\Carbon::parse($fecha)->month,
            'anio' => \Carbon\Carbon::parse($fecha)->year
        ]) }}"
       class="btn btn-secondary mt-3">
        Volver al calendario
    </a>
</div>
@endsection
