@extends('template.medico')

@section('contenido')
<div class="container mt-4">
    <h2>Detalle de la Cita</h2>

    <div class="card mt-3">
        <div class="card-body">
            <p>
                <strong>Paciente:</strong>
                {{ $cita->paciente->nombre }}
                ({{ $cita->paciente->rutPaciente }})
            </p>

            <p>
                <strong>Previsión:</strong>
                {{ $cita->paciente->prevision->nombrePrevision ?? '-' }}
            </p>

            <p>
                <strong>Médico:</strong>
                {{ $cita->medico->nombreMedico }}
                @if(optional($cita->medico->especialidad)->nombreEspecialidad)
                    ({{ $cita->medico->especialidad->nombreEspecialidad }})
                @endif
            </p>

            <p>
                <strong>Fecha y hora:</strong>
                {{ \Carbon\Carbon::parse($cita->fechaHora)->format('d/m/Y H:i') }}
            </p>

            <p>
                <strong>Motivo de la cita:</strong>
                {{ $cita->motivoCita }}
            </p>
        </div>
    </div>

    {{-- Volver a las citas del día del médico --}}
    <a href="{{ route('medico.citas.dia', [
            'fecha' => \Carbon\Carbon::parse($cita->fechaHora)->format('Y-m-d')
        ]) }}"
       class="btn btn-secondary mt-3">
        Volver a citas del día
    </a>
</div>
@endsection
