@extends('template.medico')

@section('contenido')
<div class="container mt-4">
    <h2>Mis pacientes</h2>
    <p class="text-muted mb-3">
        Pacientes que has atendido, ordenados desde la última cita hacia atrás.
        Desde aquí puedes crear o actualizar su resumen de atención.
    </p>

    @if($items->isEmpty())
        <div class="alert alert-info">
            Aún no tienes pacientes registrados en tus citas.
        </div>
    @else
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Paciente</th>
                    <th>RUT</th>
                    <th>Última cita</th>
                    <th class="text-end">Resumen</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $rutPaciente => $item)
                    @php
                        $paciente = $item['paciente'];
                        $ultima   = \Carbon\Carbon::parse($item['ultimaCita'])->format('d/m/Y H:i');
                        $resumen  = $resumenes[$rutPaciente] ?? null;
                    @endphp
                    <tr>
                        <td>{{ $paciente->nombre }}</td>
                        <td>{{ $paciente->rutPaciente }}</td>
                        <td>{{ $ultima }}</td>
                        <td class="text-end">
                            @if($resumen)
                                <a href="{{ route('resumenCitas.edit', $resumen->idResumenCita) }}"
                                   class="btn btn-sm btn-warning">
                                    Editar resumen
                                </a>
                                <a href="{{ route('resumenCitas.show', $resumen->idResumenCita) }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    Ver
                                </a>
                            @else
                                <a href="{{ route('resumenCitas.create', [
                                        'rutPaciente' => $paciente->rutPaciente,
                                        'rutMedico'   => $rutMedico
                                    ]) }}"
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
