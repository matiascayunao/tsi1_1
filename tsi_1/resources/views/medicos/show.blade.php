@extends('template.secretaria')

@section('contenido')
<div class="container mt-4">
    <h2>Detalle del Médico</h2>

    <div class="card p-4 shadow-sm mb-3">
        <p><strong>Nombre:</strong> {{ $medico->nombreMedico }}</p>
        <p><strong>RUN:</strong> {{ $medico->rutMedico }}</p>
        <p><strong>Correo:</strong> {{ $medico->correoMedico }}</p>
        <p><strong>Teléfono:</strong> {{ $medico->telefonoMedico }}</p>
        <p><strong>Especialidad:</strong> {{ $medico->especialidad->nombreEspecialidad ?? '-' }}</p>
    </div>

    <a href="{{ route('medicos.detalle') }}" class="btn btn-secondary">
        Volver al listado
    </a>
</div>
@endsection
