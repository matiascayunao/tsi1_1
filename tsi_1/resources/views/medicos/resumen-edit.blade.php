@extends('template.medico')

@section('contenido')
<div class="container mt-4">
    <h2>Editar resumen de la cita</h2>

    <div class="mb-3">
        <strong>Paciente:</strong>
        {{ $cita->paciente->nombre }} ({{ $cita->paciente->rutPaciente }})<br>
        <strong>Fecha y hora:</strong>
        {{ \Carbon\Carbon::parse($cita->fechaHora)->format('d/m/Y H:i') }}<br>
        <strong>Médico:</strong>
        {{ $cita->medico->nombreMedico ?? '' }}
    </div>

    <form action="{{ route('resumenCitas.update', $cita) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Diagnóstico</label>
            <textarea name="diagnostico"
                      class="form-control @error('diagnostico') is-invalid @enderror"
                      rows="3"
                      required>{{ old('diagnostico', $resumen->diagnostico) }}</textarea>
            @error('diagnostico')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Prescripción</label>
            <textarea name="prescripcion"
                      class="form-control @error('prescripcion') is-invalid @enderror"
                      rows="3"
                      required>{{ old('prescripcion', $resumen->prescripcion) }}</textarea>
            @error('prescripcion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Nº de receta (opcional)</label>
            <input type="number"
                   name="numReceta"
                   class="form-control @error('numReceta') is-invalid @enderror"
                   value="{{ old('numReceta', $resumen->numReceta) }}">
            @error('numReceta')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('resumenCitas.show', $cita->idCita) }}" class="btn btn-secondary ms-2">Volver</a>
    </form>
</div>
@endsection
