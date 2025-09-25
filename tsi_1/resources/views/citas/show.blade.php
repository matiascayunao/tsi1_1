@extends('template.master')

@section('contenido')
<div class="container mt-4">
    <h2>Detalle de la Cita</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm p-4">
        <p><strong>Paciente:</strong> {{ $cita->paciente->nombre }} ({{ $cita->paciente->rutPaciente }})</p>
        <p><strong>Previsión:</strong> {{ $cita->paciente->prevision->nombre }}</p>
        <p><strong>Médico:</strong> {{ $cita->medico->nombre }} ({{ $cita->medico->especialidad->nombreEspecialidad }})</p>
        <p><strong>Fecha y Hora:</strong> {{ \Carbon\Carbon::parse($cita->fechaHora)->format('d/m/Y H:i') }}</p>
        <p><strong>Motivo de la cita:</strong> {{ $cita->motivoCita }}</p>
    </div>

    <div class="mt-3">
        <a href="{{ route('citas.index') }}" class="btn btn-secondary">Volver al listado</a>
    </div>
</div>
@endsection
