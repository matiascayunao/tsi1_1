@extends('template.medico') {{-- si luego haces template.medico, solo cambias esto --}}

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-1">Panel del Médico</h2>
    <p class="text-muted mb-4">
        Desde aquí puedes revisar tu agenda de citas y el listado de pacientes que atiendes.
    </p>

    <div class="row row-cols-1 row-cols-md-2 g-4">
        {{-- Ver citas --}}
        <div class="col">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <strong>Citas</strong>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title mb-2">Agenda de atenciones</h5>
                    <p class="card-text flex-grow-1">
                        Revisa tus citas del mes en un calendario y accede al detalle de cada paciente.
                    </p>
                    <a href="{{ route('medico.citas') }}" class="btn btn-primary w-100 mt-auto">
                        Ver citas
                    </a>
                </div>
            </div>
        </div>

        {{-- Ver pacientes --}}
        <div class="col">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-info text-white">
                    <strong>Pacientes</strong>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title mb-2">Pacientes atendidos</h5>
                    <p class="card-text flex-grow-1">
                        Visualiza el listado de tus pacientes y gestiona sus resúmenes de atención.
                    </p>
                    <a href="{{ route('medico.pacientes') }}" class="btn btn-info text-white w-100 mt-auto">
                        Ver pacientes
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
