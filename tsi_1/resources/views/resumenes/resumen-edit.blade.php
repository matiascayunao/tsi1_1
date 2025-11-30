@extends('template.medico')

@section('contenido')
<div class="container mt-4">
    <h2>Editar resumen médico</h2>

    <div class="mb-3">
        <strong>Paciente:</strong> {{ $cita->paciente->nombre }} ({{ $cita->paciente->rutPaciente }})<br>
        <strong>Previsión:</strong> {{ $cita->paciente->prevision->nombrePrevision ?? '-' }}<br>
        <strong>Fecha y hora:</strong> {{ \Carbon\Carbon::parse($cita->fechaHora)->format('d/m/Y H:i') }}<br>
        <strong>Motivo:</strong> {{ $cita->motivoCita }}
    </div>

    <form method="POST" action="{{ route('resumenCitas.update', $cita->idCita) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Diagnóstico</label>
            <textarea name="diagnostico" class="form-control" rows="3" required>{{ old('diagnostico', $resumen->diagnostico) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Prescripción</label>
            <textarea name="prescripcion" class="form-control" rows="3" required>{{ old('prescripcion', $resumen->prescripcion) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">N° de receta (opcional)</label>
            <input type="number" name="numReceta" class="form-control" value="{{ old('numReceta', $resumen->numReceta) }}">
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('resumenCitas.show', $cita->idCita) }}" class="btn btn-outline-secondary">Cancelar</a>
    </form>
</div>
@endsection
