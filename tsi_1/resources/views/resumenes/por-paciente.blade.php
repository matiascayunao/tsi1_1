@extends('template.secretaria')

@section('contenido')
<div class="container mt-4">
    <h2>Resúmenes de citas de {{ $paciente->nombre }}</h2>

    @if($resumenes->isEmpty())
        <div class="alert alert-warning">Este paciente aún no tiene resúmenes.</div>
    @else
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Médico</th>
                    <th>Especialidad</th>
                    <th>Diagnóstico</th>
                    <th>Prescripción</th>
                    <th>N° Receta</th>
                </tr>
            </thead>
            <tbody>
                @foreach($resumenes as $resumen)
                    <tr>
                        <td>{{ $resumen->cita->medico->nombreMedico }}</td>
                        <td>{{ $resumen->cita->medico->especialidad->nombreEspecialidad }}</td>
                        <td>{{ $resumen->diagnostico }}</td>
                        <td>{{ $resumen->prescripcion }}</td>
                        <td>{{ $resumen->numReceta ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
