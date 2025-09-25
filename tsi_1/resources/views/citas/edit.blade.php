@extends('template.master')

@section('contenido')
<div class="container mt-4">
    <h2>Modificar Cita</h2>

    <form action="{{ route('citas.update', $cita->idCita) }}" method="POST" class="card p-4 shadow-sm">
    @csrf
    @method('PUT')

    {{-- Paciente (mostrar pero enviar hidden) --}}
    <div class="mb-3">
        <label class="form-label">Paciente</label>
        <input type="text" class="form-control"
               value="{{ $cita->paciente->nombre }} ({{ $cita->paciente->rutPaciente }})" readonly>
        <input type="hidden" name="rutPaciente" value="{{ $cita->rutPaciente }}">
    </div>

    {{-- Médico (mostrar pero enviar hidden) --}}
    <div class="mb-3">
        <label class="form-label">Médico</label>
        <input type="text" class="form-control"
               value="{{ $cita->medico->nombreMedico }} - {{ $cita->medico->especialidad->nombreEspecialidad }}" readonly>
        <input type="hidden" name="rutMedico" value="{{ $cita->rutMedico }}">
    </div>

    {{-- Fecha editable --}}
    <div class="mb-3">
        <label for="fechaHora" class="form-label">Nueva Fecha y Hora</label>
        <input type="datetime-local" name="fechaHora" id="fechaHora"
               class="form-control"
               value="{{ \Carbon\Carbon::parse($cita->fechaHora)->format('Y-m-d\TH:i') }}" required>
    </div>

    {{-- Motivo (solo lectura o editable según quieras) --}}
    <div class="mb-3">
        <label for="motivoCita" class="form-label">Motivo</label>
        <textarea name="motivoCita" id="motivoCita" rows="3" class="form-control" readonly>{{ $cita->motivoCita }}</textarea>
    </div>

    <button type="submit" class="btn btn-success w-100">Guardar cambios</button>
</form>

</div>
@endsection
