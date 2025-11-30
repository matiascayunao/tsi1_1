@extends('template.medico')

@section('contenido')
<div class="container mt-4">
    <h2>Crear resumen de la cita</h2>

    <div class="mb-3">
        <strong>Paciente:</strong>
        {{ $cita->paciente->nombre }} ({{ $cita->paciente->rutPaciente }})<br>
        <strong>Previsión:</strong>
        {{ $cita->paciente->prevision->nombrePrevision ?? '' }}<br>
        <strong>Fecha y hora:</strong>
        {{ \Carbon\Carbon::parse($cita->fechaHora)->format('d/m/Y H:i') }}<br>
        <strong>Médico:</strong>
        {{ $cita->medico->nombreMedico ?? '' }}
    </div>

    <form action="{{ route('resumenCitas.store', $cita) }}" method="POST">
        @csrf

        <input type="hidden" name="idCita" value="{{ $cita->idCita }}">

        <div class="mb-3">
            <label class="form-label">Diagnóstico</label>
            <textarea name="diagnostico"
                      class="form-control @error('diagnostico') is-invalid @enderror"
                      rows="3"
                      required>{{ old('diagnostico') }}</textarea>
            @error('diagnostico')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Prescripción</label>
            <textarea name="prescripcion"
                      class="form-control @error('prescripcion') is-invalid @enderror"
                      rows="3"
                      required>{{ old('prescripcion') }}</textarea>
            @error('prescripcion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Nº de receta (opcional)</label>
            <input type="number"
                   name="numReceta"
                   class="form-control @error('numReceta') is-invalid @enderror"
                   value="{{ old('numReceta') }}">
            @error('numReceta')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Guardar resumen</button>
        <a href="{{ route('medico.pacientes') }}" class="btn btn-secondary ms-2">Volver a pacientes</a>
    </form>
</div>
@endsection
