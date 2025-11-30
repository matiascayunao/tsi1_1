@extends('template.medico')

@section('contenido')
<div class="container mt-4">
    <h2>Resumen médico</h2>

    @php
        $cita = $resumen->cita;
    @endphp

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">
                {{ $cita->paciente->nombre }} ({{ $cita->paciente->rutPaciente }})
            </h5>
            <p class="card-text mb-1"><strong>Previsión:</strong> {{ $cita->paciente->prevision->nombrePrevision ?? '-' }}</p>
            <p class="card-text mb-1"><strong>Fecha y hora:</strong> {{ \Carbon\Carbon::parse($cita->fechaHora)->format('d/m/Y H:i') }}</p>
            <p class="card-text mb-1"><strong>Motivo:</strong> {{ $cita->motivoCita }}</p>
            <hr>
            <p class="card-text"><strong>Diagnóstico:</strong><br>{{ $resumen->diagnostico }}</p>
            <p class="card-text"><strong>Prescripción:</strong><br>{{ $resumen->prescripcion }}</p>
            @if($resumen->numReceta)
                <p class="card-text"><strong>N° de receta:</strong> {{ $resumen->numReceta }}</p>
            @endif
        </div>
    </div>

    <a href="{{ route('resumenCitas.edit', $cita->idCita) }}" class="btn btn-warning">Editar resumen</a>
    <a href="{{ route('medico.pacientes') }}" class="btn btn-secondary">Volver a pacientes</a>
</div>
@endsection
