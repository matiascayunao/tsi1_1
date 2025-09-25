@extends('template.master')

@section('contenido')
<div class="container mt-4">
    <h2>Agendar nueva cita</h2>

    <form action="{{ route('citas.store') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="rutPaciente" class="form-label">Paciente</label>
            <select name="rutPaciente" id="rutPaciente" class="form-select" required>
                <option value="">-- Seleccione --</option>
                @foreach($pacientes as $paciente)
                    <option value="{{ $paciente->rutPaciente }}">{{ $paciente->nombre }} ({{ $paciente->rutPaciente }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="rutMedico" class="form-label">Médico</label>
            <select name="rutMedico" id="rutMedico" class="form-select" required>
                <option value="">-- Seleccione --</option>
                @foreach($medicos as $medico)
                    <option value="{{ $medico->rutMedico }}">{{ $medico->nombre }} - {{ $medico->especialidad->nombreEspecialidad }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="fechaHora" class="form-label">Fecha y hora</label>
            <input type="datetime-local" name="fechaHora" id="fechaHora" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="motivoCita" class="form-label">Motivo de la cita</label>
            <textarea name="motivoCita" id="motivoCita" rows="3" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100">Agendar cita</button>
    </form>
</div>
@endsection
