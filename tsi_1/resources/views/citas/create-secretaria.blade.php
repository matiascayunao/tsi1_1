@extends('template.secretaria')

@section('contenido')
<div class="container mt-4">
    <h2>Agendar nueva cita</h2>

    {{-- FORM GET: elegir paciente, médico y fecha --}}
    <form method="GET" action="{{ route('secretaria.citas.create') }}" class="card mb-3 p-3 shadow-sm">
        <div class="row g-2 align-items-end">

            {{-- Paciente --}}
            <div class="col-md-4">
                <label class="form-label">Paciente</label>
                <select name="rutPaciente" class="form-select" required>
                    <option value="">-- Seleccione --</option>
                    @foreach($pacientes as $paciente)
                        <option value="{{ $paciente->rutPaciente }}"
                            {{ $rutPaciente == $paciente->rutPaciente ? 'selected' : '' }}>
                            {{ $paciente->nombre }} ({{ $paciente->rutPaciente }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Médico --}}
            <div class="col-md-4">
                <label class="form-label">Médico</label>
                <select name="rutMedico" class="form-select" required>
                    <option value="">-- Seleccione --</option>
                    @foreach($medicos as $medico)
                        <option value="{{ $medico->rutMedico }}"
                            {{ $rutMedico == $medico->rutMedico ? 'selected' : '' }}>
                            {{ $medico->nombreMedico }} - {{ $medico->especialidad->nombreEspecialidad }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Fecha --}}
            <div class="col-md-3 col-sm-6">
                <label for="fecha" class="form-label mb-1">Fecha</label>
                <input
                    type="date"
                    id="fecha"
                    name="fecha"
                    class="form-control"
                    value="{{ $fecha }}"
                    min="{{ \Carbon\Carbon::today()->toDateString() }}"
                    required
                >
            </div>

            <div class="col-md-1 col-sm-6">
                <button type="submit" class="btn btn-outline-primary w-100 mt-4">
                    Ver horas
                </button>
            </div>
        </div>

        <small class="text-muted">
            Selecciona paciente, médico y fecha y pulsa <strong>“Ver horas”</strong> para mostrar los horarios disponibles.
        </small>
    </form>

    {{-- FORM POST: solo si ya hay paciente + médico seleccionados --}}
    @if(!empty($rutPaciente) && !empty($rutMedico))
        <form action="{{ route('secretaria.citas.store') }}" method="POST" class="card p-4 shadow-sm">
            @csrf

            <input type="hidden" name="rutPaciente" value="{{ $rutPaciente }}">
            <input type="hidden" name="rutMedico"   value="{{ $rutMedico }}">

            {{-- Info seleccionada --}}
            <div class="mb-3">
                @php
                    $pacSel = $pacientes->firstWhere('rutPaciente', $rutPaciente);
                    $medSel = $medicos->firstWhere('rutMedico',   $rutMedico);
                @endphp

                <p class="mb-1">
                    <strong>Paciente:</strong>
                    {{ $pacSel ? ($pacSel->nombre.' ('.$pacSel->rutPaciente.')') : $rutPaciente }}
                </p>
                <p class="mb-1">
                    <strong>Médico:</strong>
                    {{ $medSel ? ($medSel->nombreMedico.' - '.$medSel->especialidad->nombreEspecialidad) : $rutMedico }}
                </p>
                <p class="mb-0">
                    <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}
                </p>
            </div>

            {{-- FECHA Y HORA --}}
            <div class="mb-3">
                <label class="form-label">Horario disponible</label>

                @error('fechaHora')
                    <div class="text-danger small mb-2">{{ $message }}</div>
                @enderror

                @if(empty($slots))
                    <div class="alert alert-info">
                        No hay horarios configurados para este día.
                    </div>
                @else
                    @php $primeroHabilitado = true; @endphp

                    <div class="row row-cols-4 g-2 mt-2">
                        @foreach($slots as $slot)
                            @php
                                $hora          = $slot->format('H:i');
                                $deshabilitado = in_array($hora, $ocupados);
                                $idSlot        = 'slot_' . $slot->format('Hi');

                                $requiredAttr  = (!$deshabilitado && $primeroHabilitado) ? 'required' : '';
                                if (!$deshabilitado && $primeroHabilitado) {
                                    $primeroHabilitado = false;
                                }

                                $clasesBtn = $deshabilitado
                                    ? 'btn-outline-danger text-danger'
                                    : 'btn-outline-success';
                            @endphp

                            <div class="col">
                                <input
                                    type="radio"
                                    name="fechaHora"
                                    id="{{ $idSlot }}"
                                    class="btn-check"
                                    value="{{ $slot->format('Y-m-d H:i:s') }}"
                                    autocomplete="off"
                                    {{ $deshabilitado ? 'disabled' : '' }}
                                    {!! $requiredAttr !!}
                                >
                                <label
                                    class="btn w-100 {{ $clasesBtn }} {{ $deshabilitado ? 'disabled' : '' }}"
                                    for="{{ $idSlot }}"
                                    @if($deshabilitado)
                                        style="cursor: not-allowed;"
                                    @endif
                                >
                                    {{ $hora }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <small class="text-muted d-block mt-2">
                        Horario de 08:00 a 13:00 y de 14:30 a 21:00, en bloques de 20 minutos.
                        Los horarios en <span class="text-danger">rojo</span> ya están reservados.
                    </small>
                @endif
            </div>

            {{-- MOTIVO --}}
            <div class="mb-3">
                <label for="motivoCita" class="form-label">Motivo de la cita</label>
                <textarea
                    name="motivoCita"
                    id="motivoCita"
                    rows="3"
                    class="form-control"
                    required
                >{{ old('motivoCita') }}</textarea>
                @error('motivoCita')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Agendar cita
            </button>
        </form>
    @endif
</div>

{{-- JS para bloquear fines de semana y fechas anteriores a hoy --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputFecha = document.getElementById('fecha');
    if (!inputFecha) return;

    // "Hoy" a las 00:00:00 para comparar sólo la fecha
    const hoy = new Date();
    hoy.setHours(0, 0, 0, 0);

    function parseFechaYMD(value) {
        const partes = value.split('-'); // yyyy-mm-dd
        if (partes.length !== 3) return null;
        const anio  = parseInt(partes[0], 10);
        const mes   = parseInt(partes[1], 10) - 1; // 0–11
        const dia   = parseInt(partes[2], 10);
        return new Date(anio, mes, dia);
    }

    function esFinDeSemana(date) {
        const d = date.getDay(); // 0 = domingo, 6 = sábado
        return d === 0 || d === 6;
    }

    function validarFechaSeleccionada() {
        if (!inputFecha.value) return;

        const fechaSel = parseFechaYMD(inputFecha.value);
        if (!fechaSel) return;

        fechaSel.setHours(0, 0, 0, 0);

        if (fechaSel < hoy || esFinDeSemana(fechaSel)) {
            alert('Sólo puedes seleccionar días hábiles desde hoy en adelante (lunes a viernes).');
            inputFecha.value = '';
        }
    }

    // Validar cuando el usuario cambia la fecha
    inputFecha.addEventListener('change', validarFechaSeleccionada);

    // También validamos el valor inicial por si viene precargado
    validarFechaSeleccionada();
});
</script>
@endsection
