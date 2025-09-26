@extends('template.master')

@section('contenido')
<div class="container mt-4">
    <h2>Citas agendadas para el RUT: {{ $rutPaciente }}</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($citas->isEmpty())
        <div class="alert alert-warning">No se encontraron citas para este RUT.</div>
    @else
        <div class="list-group">
            @foreach($citas as $cita)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <p><strong>Paciente:</strong> {{ $cita->paciente->nombre }}</p>
                        <p><strong>Médico:</strong> {{ $cita->medico->nombreMedico }} ({{ $cita->medico->especialidad->nombreEspecialidad }})</p>
                        <p><strong>Fecha y Hora:</strong> {{ \Carbon\Carbon::parse($cita->fechaHora)->format('d/m/Y H:i') }}</p>
                        <p><strong>Motivo:</strong> {{ $cita->motivoCita }}</p>
                    </div>
                    <form action="{{ route('citas.destroy', $cita->idCita) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                                onclick="return confirm('¿Seguro que desea cancelar esta cita?')">
                            Cancelar
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
