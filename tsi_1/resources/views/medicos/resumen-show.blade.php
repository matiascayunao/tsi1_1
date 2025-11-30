@extends('template.medico')

@section('contenido')
<div class="container mt-4">
    <h2>Resumen de la cita</h2>

    @php
        $cita     = $resumen->cita;
        $paciente = $cita->paciente;
        $medico   = $cita->medico;
    @endphp

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Datos de la cita</h5>

            <p><strong>Paciente:</strong>
                {{ $paciente->nombre }} ({{ $paciente->rutPaciente }})
            </p>

            <p><strong>Previsión:</strong>
                {{ $paciente->prevision->nombrePrevision ?? '-' }}
            </p>

            <p><strong>Fecha y hora:</strong>
                {{ \Carbon\Carbon::parse($cita->fechaHora)->format('d/m/Y H:i') }}
            </p>

            <p><strong>Médico:</strong>
                {{ $medico->nombreMedico ?? '' }}
                {{ $medico->especialidad->nombreEspecialidad ?? '' }}
            </p>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <h5>Diagnóstico</h5>
            <p>{{ $resumen->diagnostico }}</p>

            <h5>Prescripción</h5>
            <p>{{ $resumen->prescripcion }}</p>

            @if($resumen->numReceta)
                <h5>Nº de receta</h5>
                <p>{{ $resumen->numReceta }}</p>
            @endif
        </div>
    </div>

    <a href="{{ route('resumenCitas.edit', $cita->idCita) }}"
       class="btn btn-warning">
        Editar
    </a>

    <a href="{{ route('medico.pacientes') }}"
       class="btn btn-secondary ms-2">
        Volver a pacientes
    </a>
</div>
@endsection
