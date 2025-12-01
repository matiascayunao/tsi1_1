@extends('template.secretaria')

@section('contenido')
<div class="container mt-4">
    <h2>Calendario de Citas</h2>

    {{-- Barra superior: cambiar mes + seleccionar médico --}}
    <div class="d-flex justify-content-between align-items-center mt-3 mb-3">

        <div>
            <a href="{{ route('citas.calendario', [
                    'mes'       => $mesAnterior->month,
                    'anio'      => $mesAnterior->year,
                    'rutMedico' => $rutMedico
                ]) }}"
               class="btn btn-outline-secondary btn-sm">
                &laquo; Mes anterior
            </a>

            <span class="mx-3 fw-bold">
                {{ \Carbon\Carbon::create($anio, $mes, 1)->locale('es')->translatedFormat('F Y') }}
            </span>

            <a href="{{ route('citas.calendario', [
                    'mes'       => $mesSiguiente->month,
                    'anio'      => $mesSiguiente->year,
                    'rutMedico' => $rutMedico
                ]) }}"
               class="btn btn-outline-secondary btn-sm">
                Mes siguiente &raquo;
            </a>
        </div>

        <form id="filtroMedico" method="GET" class="d-flex align-items-center gap-2">
            <input type="hidden" name="mes" value="{{ $mes }}">
            <input type="hidden" name="anio" value="{{ $anio }}">

            <label class="form-label mb-0">Médico:</label>
            <select name="rutMedico" class="form-select" style="min-width: 240px;">
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
        </form>
    </div>

    {{-- Calendario (solo lunes a viernes) --}}
    <table class="table table-bordered text-center align-middle">
        <thead class="table-light">
            <tr>
                <th>Lun</th>
                <th>Mar</th>
                <th>Mié</th>
                <th>Jue</th>
                <th>Vie</th>
            </tr>
        </thead>
        <tbody>
            @foreach($semanas as $semana)
                <tr>
                    @foreach($semana as $dia)
                        @if($dia->isWeekend())
                            @continue {{-- salta sábado y domingo --}}
                        @endif

                        @php
                            $esOtroMes = $dia->month != $mes;
                            $esPasado  = $dia->lt($hoy);
                            $esHoy     = $dia->isSameDay($hoy);

                            $clases = 'calendar-day';
                            if ($esOtroMes) {
                                $clases .= ' other-month';
                            } elseif ($esPasado) {
                                $clases .= ' past';
                            }
                            if ($esHoy) {
                                $clases .= ' today';
                            }
                        @endphp

                        <td class="{{ $clases }}">
                            <a href="{{ route('citas.porDia', [
                                    'fecha'     => $dia->format('Y-m-d'),
                                    'rutMedico' => $rutMedico
                                ]) }}">
                                <div class="fw-bold">{{ $dia->day }}</div>
                            </a>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<style>
    .calendar-day {
        height: 130px;          /* hace el calendario gigante */
        vertical-align: top;
        cursor: pointer;
    }
    .calendar-day a {
        display: block;
        width: 100%;
        height: 100%;
        text-decoration: none;
        color: inherit;
        padding: 4px;
    }
    .calendar-day.past {
        background-color: #f8d7da;  /* rojo clarito para días pasados */
    }
    .calendar-day.today {
        border: 8px solid #0d6efd;  /* borde azul para hoy */
    }
    .calendar-day.other-month {
        background-color: #f8f9fa;
        color: #adb5bd;             /* gris para días fuera del mes */
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const select = document.querySelector('#filtroMedico select[name="rutMedico"]');
    if (select) {
        select.addEventListener('change', function () {
            document.getElementById('filtroMedico').submit();
        });
    }
});
</script>
@endsection
