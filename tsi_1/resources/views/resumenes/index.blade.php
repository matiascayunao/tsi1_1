@extends('template.secretaria')

@section('contenido')
<div class="container mt-4">
    <h2>Resúmenes de atención</h2>

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if($resumenes->isEmpty())
        <div class="alert alert-info mt-3">
            No hay resúmenes registrados.
        </div>
    @else
        <table class="table table-hover mt-3">
            <thead class="table-light">
                <tr>
                    <th>Cita</th>
                    <th>Paciente</th>
                    <th>Médico</th>
                    <th>Motivo</th>
                    <th>Fecha registro</th>
                </tr>
            </thead>
            <tbody>
                @foreach($resumenes as $res)
                    <tr>
                        <td>{{ optional($res->cita)->idCita ?? '-' }}</td>
                        <td>{{ optional($res->paciente)->nombre ?? 'Paciente no disponible' }}</td>
                        <td>{{ optional($res->medico)->nombreMedico ?? 'Médico no disponible' }}</td>
                        <td>{{ $res->motivo ?? '-' }}</td>
                        <td>{{ optional($res->created_at)->format('d-m-Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
