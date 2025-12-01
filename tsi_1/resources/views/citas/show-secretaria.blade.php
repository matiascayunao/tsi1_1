@extends('template.secretaria')

@section('contenido')
<div class="container mt-4">
    <h2>Detalle de la Cita</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card p-4 shadow-sm mb-3">
        <p><strong>Paciente:</strong> {{ $cita->paciente->nombre ?? '' }} ({{ $cita->rutPaciente }})</p>
        <p><strong>Previsión:</strong> {{ $cita->paciente->prevision->nombrePrevision ?? '-' }}</p>
        <p><strong>Médico:</strong> {{ $cita->medico->nombreMedico ?? '' }}
            @if($cita->medico && $cita->medico->especialidad)
                ({{ $cita->medico->especialidad->nombreEspecialidad }})
            @endif
        </p>
        <p><strong>Fecha y Hora:</strong> {{ \Carbon\Carbon::parse($cita->fechaHora)->format('d/m/Y H:i') }}</p>
        <p><strong>Motivo de la cita:</strong> {{ $cita->motivoCita }}</p>
    </div>

    <a href="{{ route('secretaria.index') }}" class="btn btn-secondary">
        Volver al inicio
    </a>
</div>
@endsection
