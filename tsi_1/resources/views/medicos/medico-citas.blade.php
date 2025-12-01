@extends('template.medico')

@section('contenido')
<div class="container mt-4">
    <h2>Mis citas</h2>

    <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
        <div>
            <a href="{{ route('medico.citas', ['mes' => $mesAnterior->month, 'anio' => $mesAnterior->year]) }}"
               class="btn btn-outline-secondary btn-sm">
                &laquo; Mes anterior
            </a>

            <span class="mx-3 fw-bold">
                {{ \Carbon\Carbon::create($anio, $mes, 1)->locale('es')->translatedFormat('F Y') }}
            </span>

            <a href="{{ route('medico.citas', ['mes' => $mesSiguiente->month, 'anio' => $mesSiguiente->year]) }}"
               class="btn btn-outline-secondary btn-sm">
                Mes siguiente &raquo;
            </a>
        </div>
    </div>

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

                            $fechaKey = $dia->format('Y-m-d');
                            $totalDia = $conteoCitas[$fechaKey] ?? 0;
                        @endphp

                        <td class="{{ $clases }}">
                            <a href="{{ route('medico.citas.dia', ['fecha' => $fechaKey]) }}">
                                <div class="fw-bold">{{ $dia->day }}</div>
                                @if($totalDia > 0)
                                    <span class="badge bg-primary mt-1">
                                        {{ $totalDia }} cita{{ $totalDia > 1 ? 's' : '' }}
                                    </span>
                                @endif
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
        height: 120px;
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
        background-color: #f8d7da;
    }
    .calendar-day.today {
        border: 2px solid #0d6efd;
    }
    .calendar-day.other-month {
        background-color: #f8f9fa;
        color: #adb5bd;
    }
</style>
@endsection
