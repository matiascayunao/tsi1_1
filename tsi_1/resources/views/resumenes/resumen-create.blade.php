@extends('template.medico')

@section('contenido')
<div class="container mt-4">
    <h2>Crear resumen médico</h2>

    <div class="mb-3">
        <strong>Paciente:</strong> {{ $cita->paciente->nombre }} ({{ $cita->paciente->rutPaciente }})<br>
        <strong>Previsión:</strong> {{ $cita->paciente->prevision->nombrePrevision ?? '-' }}<br>
        <strong>Fecha y hora:</strong> {{ \Carbon\Carbon::parse($cita->fechaHora)->format('d/m/Y H:i') }}<br>
        <strong>Motivo:</strong> {{ $cita->motivoCita }}
    </div>

    <form method="POST" action="{{ route('resumenCitas.store', $cita->idCita) }}">
        @csrf
        {{-- Necesario para que pase la validación de ResumenRequest --}}
        <input type="hidden" name="idCita" value="{{ $cita->idCita }}">

        <div class="mb-3">
            <label class="form-label">Diagnóstico</label>
            <textarea name="diagnostico" class="form-control" rows="3" required>{{ old('diagnostico') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Prescripción</label>
            <textarea name="prescripcion" class="form-control" rows="3" required>{{ old('prescripcion') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">N° de receta (opcional)</label>
            <input type="number" name="numReceta" class="form-control" value="{{ old('numReceta') }}">
        </div>

        <button type="submit" class="btn btn-primary">Guardar resumen</button>
        <a href="{{ route('medico.pacientes') }}" class="btn btn-secondary">Volver a pacientes</a>
    </form>
</div>
@endsection
