@extends('template.master')

@section('contenido')
<div class="container mt-4">
    <h2>Agendar nueva cita</h2>

    {{-- Si venimos del flujo público con médico/paciente fijados, mostramos selector de fecha --}}
    @if(!empty($rutMedico))
        <form method="GET" action="{{ route('citas.create') }}" class="card mb-3 p-3 shadow-sm">
            <input type="hidden" name="rutMedico" value="{{ $rutMedico }}">
            <input type="hidden" name="rutPaciente" value="{{ $rutPaciente }}">

            <div class="row g-2 align-items-end">
                <div class="col-auto">
                    <label for="fecha" class="form-label mb-1">Fecha</label>
                    <input
                        type="date"
                        id="fecha"
                        name="fecha"
                        class="form-control"
                        value="{{ $fecha }}"
                        min="{{ \Carbon\Carbon::today()->toDateString() }}"
                    >
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-outline-primary mt-4">
                        Cambiar fecha
                    </button>
                </div>
            </div>

            <small class="text-muted">
                Selecciona la fecha para ver los horarios disponibles del médico.
            </small>
        </form>
    @endif

    <form action="{{ route('citas.store') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        {{-- PACIENTE --}}
        <div class="mb-3">
            <label for="rutPaciente" class="form-label">Paciente</label>

            @if(!empty($rutPaciente))
                @php
                    $pacSel = $pacientes->firstWhere('rutPaciente', $rutPaciente);
                @endphp

                <input
                    type="text"
                    class="form-control"
                    value="{{ $pacSel ? ($pacSel->nombre.' ('.$pacSel->rutPaciente.')') : 'Paciente seleccionado' }}"
                    disabled
                >
                <input type="hidden" name="rutPaciente" value="{{ $rutPaciente }}">
            @else
                <select name="rutPaciente" id="rutPaciente" class="form-select" required>
                    <option value="">-- Seleccione --</option>
                    @foreach($pacientes as $paciente)
                        <option
                            value="{{ $paciente->rutPaciente }}"
                            {{ old('rutPaciente') == $paciente->rutPaciente ? 'selected' : '' }}
                        >
                            {{ $paciente->nombre }} ({{ $paciente->rutPaciente }})
                        </option>
                    @endforeach
                </select>
            @endif

            @error('rutPaciente')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- MÉDICO --}}
        <div class="mb-3">
            <label for="rutMedico" class="form-label">Médico</label>

            @if(!empty($rutMedico))
                @php
                    $medSel = $medicos->firstWhere('rutMedico', $rutMedico);
                @endphp

                <input
                    type="text"
                    class="form-control"
                    value="{{ $medSel ? ($medSel->nombreMedico.' - '.$medSel->especialidad->nombreEspecialidad) : 'Médico seleccionado' }}"
                    disabled
                >
                <input type="hidden" name="rutMedico" value="{{ $rutMedico }}">
            @else
                <select name="rutMedico" id="rutMedico" class="form-select" required>
                    <option value="">-- Seleccione --</option>
                    @foreach($medicos as $medico)
                        <option
                            value="{{ $medico->rutMedico }}"
                            {{ old('rutMedico', $rutMedico) == $medico->rutMedico ? 'selected' : '' }}
                        >
                            {{ $medico->nombreMedico }} - {{ $medico->especialidad->nombreEspecialidad }}
                        </option>
                    @endforeach
                </select>
            @endif

            @error('rutMedico')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- FECHA Y HORA --}}
        <div class="mb-3">
            <label class="form-label">Fecha y hora</label>

            @if(empty($rutMedico))
                {{-- Fallback: cuando no se viene del flujo público --}}
                <input
                    type="datetime-local"
                    name="fechaHora"
                    id="fechaHora"
                    class="form-control"
                    value="{{ old('fechaHora') }}"
                    required
                >
                <small class="text-muted">
                    Selecciona manualmente fecha y hora porque no hay un médico fijo desde el flujo público.
                </small>
            @else
                <p class="mb-2">
                    <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}
                </p>

                @error('fechaHora')
                    <div class="text-danger small mb-2">{{ $message }}</div>
                @enderror

                @if(empty($slots))
                    <div class="alert alert-info">
                        No hay horarios configurados para este día.
                    </div>
                @else
                    @php $primeroHabilitado = true; @endphp

                    {{-- Rejilla de horas --}}
                    <div class="row row-cols-4 g-2 mt-2">
                        @foreach($slots as $slot)
                            @php
                                $hora          = $slot->format('H:i');
                                $deshabilitado = in_array($hora, $ocupados);
                                $idSlot        = 'slot_' . $slot->format('Hi');

                                // Solo marco "required" en el primer slot disponible
                                $requiredAttr  = (!$deshabilitado && $primeroHabilitado) ? 'required' : '';
                                if (!$deshabilitado && $primeroHabilitado) {
                                    $primeroHabilitado = false;
                                }

                                // Clases según si está ocupado o libre
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

        <button type="submit" class="btn btn-primary w-100">Agendar cita</button>
    </form>
</div>
@endsection
