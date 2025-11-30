@extends('template.medico')

@section('contenido')
<div class="container mt-4">
    <h2>Mis pacientes</h2>
    <p>Pacientes que has atendido, ordenados desde la última cita hacia atrás.</p>

    @if($items->isEmpty())
        <div class="alert alert-info">Aún no tienes pacientes registrados en tus citas.</div>
    @else
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Paciente</th>
                    <th>RUT</th>
                    <th>Última cita</th>
                    <th class="text-end">Resumen</th>
                </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                @php
                    $paciente = $item['paciente'];
                    $fecha    = \Carbon\Carbon::parse($item['ultimaCita'])->format('d/m/Y H:i');
                    $idCita   = $item['idCita'];
                    $resumen  = $resumenes[$idCita] ?? null;
                @endphp

                <tr>
                    <td>{{ $paciente->nombre }}</td>
                    <td>{{ $paciente->rutPaciente }}</td>
                    <td>{{ $fecha }}</td>
                    <td class="text-end">
                        @if($resumen)
                            <a href="{{ route('resumenCitas.edit', $idCita) }}"
                               class="btn btn-sm btn-warning">
                                Editar resumen
                            </a>

                            <a href="{{ route('resumenCitas.show', $idCita) }}"
                               class="btn btn-sm btn-outline-secondary">
                                Ver
                            </a>
                        @else
                            <a href="{{ route('resumenCitas.create', $idCita) }}"
                               class="btn btn-sm btn-primary">
                                Crear resumen
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
