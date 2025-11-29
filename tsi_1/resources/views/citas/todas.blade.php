@extends('template.secretaria')

@section('contenido')
<div class="container mt-4">
    <h2>Agenda de Citas</h2>

    {{-- Filtros: fecha (calendario) + médico --}}
    <form id="filtroCitas" method="GET" class="row g-3 mt-3 mb-3">
        <div class="col-md-3">
            <label class="form-label">Fecha</label>
            <input type="date"
                   name="fecha"
                   class="form-control"
                   value="{{ $fecha }}">
        </div>

        <div class="col-md-4">
            <label class="form-label">Médico</label>
            <select name="rutMedico" class="form-select">
                <option value="">Todos los médicos</option>
                @foreach($medicos as $med)
                    <option value="{{ $med->rutMedico }}"
                        {{ $rutMedico == $med->rutMedico ? 'selected' : '' }}>
                        {{ $med->nombreMedico }}
                        @if($med->especialidad)
                            ({{ $med->especialidad->nombreEspecialidad }})
                        @endif
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-primary w-100">Buscar</button>
        </div>
    </form>

    @if($citas->isEmpty())
        <div class="alert alert-warning">
            No hay citas agendadas para esa fecha
            @if($rutMedico)
                y ese médico.
            @else
                .
            @endif
        </div>
    @else
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Hora</th>
                    <th>Paciente</th>
                    <th>Previsión</th>
                    <th>Médico</th>
                    <th>Especialidad</th>
                    <th>Motivo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($citas as $cita)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($cita->fechaHora)->format('H:i') }}</td>
                        <td>
                            {{ $cita->paciente->nombre }}
                            ({{ $cita->paciente->rutPaciente }})
                        </td>
                        <td>{{ $cita->paciente->prevision->nombrePrevision ?? '-' }}</td>
                        <td>{{ $cita->medico->nombreMedico }}</td>
                        <td>{{ $cita->medico->especialidad->nombreEspecialidad ?? '-' }}</td>
                        <td>{{ $cita->motivoCita }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

{{-- Opcional: que cambie solo al mover fecha/doctor --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('filtroCitas');
    const inputs = form.querySelectorAll('input, select');

    inputs.forEach(el => {
        el.addEventListener('change', () => form.submit());
    });
});
</script>
@endsection
