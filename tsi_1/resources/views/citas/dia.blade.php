@extends('template.secretaria')

@section('contenido')
<div class="container mt-4">
    <h2>Citas del día {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}</h2>

    @if(session('success'))
        <div class="alert alert-success mt-2">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filtro por médico --}}
    <form id="filtroDia" method="GET" class="row g-3 mt-2 mb-3">
        <input type="hidden" name="fecha" value="{{ $fecha }}">

        <div class="col-md-4 ms-auto">
            <label class="form-label">Médico</label>
            <select name="rutMedico" class="form-select">
                <option value="">Todos los médicos</option>
                @foreach($medicos as $m)
                    <option value="{{ $m->rutMedico }}"
                        {{ $rutMedico == $m->rutMedico ? 'selected' : '' }}>
                        {{ $m->nombreMedico }}
                        @if($m->especialidad)
                            ({{ $m->especialidad->nombreEspecialidad }})
                        @endif
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    @if($citas->isEmpty())
        <div class="alert alert-warning">
            No hay citas para este día
            @if($rutMedico)
                con el médico seleccionado.
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
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($citas as $cita)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($cita->fechaHora)->format('H:i') }}</td>
                        <td>{{ $cita->paciente->nombre }} ({{ $cita->paciente->rutPaciente }})</td>
                        <td>{{ $cita->paciente->prevision->nombrePrevision ?? '-' }}</td>
                        <td>{{ $cita->medico->nombreMedico }}</td>
                        <td>{{ $cita->medico->especialidad->nombreEspecialidad ?? '-' }}</td>
                        <td>{{ $cita->motivoCita }}</td>
                        <td class="text-end">
                            {{-- Modificar (usa la vista con template.secretaria) --}}
                            <a href="{{ route('citas.editSecretaria', ['cita' => $cita->idCita, 'fecha' => $fecha]) }}"
                               class="btn btn-sm btn-warning">
                                Modificar
                            </a>

                            {{-- Cancelar --}}
                            <form action="{{ route('citas.destroy', $cita->idCita) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('¿Seguro que deseas cancelar esta cita?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Cancelar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('citas.calendario', [
            'mes' => \Carbon\Carbon::parse($fecha)->month,
            'anio' => \Carbon\Carbon::parse($fecha)->year,
            'rutMedico' => $rutMedico
        ]) }}"
       class="btn btn-secondary mt-3">
        Volver al calendario
    </a>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const select = document.querySelector('#filtroDia select[name="rutMedico"]');
    if (select) {
        select.addEventListener('change', function () {
            document.getElementById('filtroDia').submit();
        });
    }
});
</script>
@endsection
