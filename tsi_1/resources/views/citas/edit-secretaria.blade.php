@extends('template.secretaria')

@section('contenido')
<div class="container mt-4">
    <h2>Modificar Cita</h2>

    {{-- Datos de la cita --}}
    <div class="card p-4 shadow-sm mb-4">
        <p><strong>Paciente:</strong> {{ $cita->paciente->nombre }} ({{ $cita->paciente->rutPaciente }})</p>
        <p><strong>Médico:</strong> {{ $cita->medico->nombreMedico }} - {{ $cita->medico->especialidad->nombreEspecialidad }}</p>
    </div>

    {{-- Calendario de horas del médico --}}
    <div class="card p-4 shadow-sm mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('citas.editSecretaria', ['cita' => $cita->idCita, 'fecha' => $diaAnterior]) }}"
               class="btn btn-sm btn-outline-secondary">&laquo; Día anterior</a>

            <strong>{{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}</strong>

            <a href="{{ route('citas.editSecretaria', ['cita' => $cita->idCita, 'fecha' => $diaSiguiente]) }}"
               class="btn btn-sm btn-outline-secondary">Día siguiente &raquo;</a>
        </div>

        <p class="mb-1">
            <span class="badge bg-success">&nbsp;&nbsp;</span> Hora actual de esta cita
        </p>
        <p class="mb-3">
            <span class="badge bg-danger">&nbsp;&nbsp;</span> Hora ocupada por otro paciente
        </p>

        <div class="d-flex flex-wrap gap-2">
            @foreach($slots as $slot)
                @php
                    $clase = 'btn-outline-primary';
                    $disabled = '';
                    if ($slot['estado'] === 'ocupado') {
                        $clase = 'btn-danger';
                        $disabled = 'disabled';
                    }
                    if ($slot['estado'] === 'actual') {
                        $clase = 'btn-success active';
                    }
                @endphp
                <button type="button"
                        class="btn btn-sm slot-btn {{ $clase }}"
                        data-hora="{{ $slot['hora'] }}"
                        data-estado="{{ $slot['estado'] }}"
                        {{ $disabled }}>
                    {{ $slot['hora'] }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Formulario de guardado --}}
    <form action="{{ route('citas.updateSecretaria', $cita->idCita) }}" method="POST" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')

        {{-- fechaHora seleccionada (YYYY-mm-dd HH:ii:00) --}}
        <input type="hidden" name="fechaHora" id="fechaHoraHidden" value="{{ $fechaHoraInicial }}">

        @error('fechaHora')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="mb-3">
            <label for="motivoCita" class="form-label">Motivo</label>
            <textarea name="motivoCita" id="motivoCita" rows="3" class="form-control" readonly>{{ $cita->motivoCita }}</textarea>
        </div>

        <button type="submit" class="btn btn-success w-100">Guardar cambios</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const FECHA  = '{{ $fecha }}';
    const hidden = document.getElementById('fechaHoraHidden');
    const botones = document.querySelectorAll('.slot-btn');

    function seleccionar(btn) {
        botones.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        hidden.value = FECHA + ' ' + btn.dataset.hora + ':00';
    }

    botones.forEach(btn => {
        if (btn.dataset.estado === 'ocupado') {
            return; // no clickable
        }

        btn.addEventListener('click', function () {
            seleccionar(this);
        });

        // Dejamos marcada por defecto la hora actual de la cita
        if (btn.dataset.estado === 'actual') {
            seleccionar(btn);
        }
    });
});
</script>
@endsection
