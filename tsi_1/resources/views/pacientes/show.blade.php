@extends('template.secretaria')

@section('contenido')
<div class="container mt-4">
    <h2>Detalle del paciente</h2>

    <div class="card p-4 shadow-sm mb-3">
        <p><strong>Nombre:</strong> {{ $paciente->nombre }}</p>
        <p><strong>RUN:</strong> {{ $paciente->rutPaciente }}</p>
        <p><strong>Fecha nacimiento:</strong> {{ $paciente->fechaNacimiento }}</p>
        <p><strong>Correo:</strong> {{ $paciente->correo }}</p>
        <p><strong>Teléfono:</strong> {{ $paciente->telefono }}</p>
        <p><strong>Previsión:</strong> {{ $paciente->prevision->nombrePrevision ?? '-' }}</p>
    </div>

    <a href="{{ route('pacientes.resumenes', $paciente->rutPaciente) }}" class="btn btn-primary">
        Ver resúmenes de atención
    </a>
</div>
@endsection
