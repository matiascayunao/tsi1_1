@extends('template.master')

@section('contenido')
<div class="container mt-4">
    <h2>Médicos disponibles</h2>
    <p class="text-muted">
        Mostrando médicos de <strong>{{ $especialidad->nombreEspecialidad }}</strong> 
        para la previsión <strong>{{ $prevision->nombrePrevision }}</strong>.
    </p>

    @if($medicos->isEmpty())
        <div class="alert alert-warning">
            No hay médicos disponibles para esta especialidad.
        </div>
    @else
        <div class="list-group">
            @foreach($medicos as $medico)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <h5>{{ $medico->nombreMedico }}</h5>
                        <p class="mb-0">Correo: {{ $medico->correoMedico }}</p>
                        <p class="mb-0">Teléfono: {{ $medico->telefonoMedico }}</p>
                    </div>
                    <a href="{{ route('citas.registrarPaciente', ['rutMedico' => $medico->rutMedico, 'idPrevision' => $prevision->codPrevision]) }}" class="btn btn-primary">
                        Seleccionar
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
