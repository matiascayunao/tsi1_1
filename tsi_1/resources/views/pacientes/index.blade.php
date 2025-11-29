@extends('template.secretaria')

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-1">Gestión de Pacientes</h2>
    <p class="text-muted mb-4">
        Desde este panel puedes registrar, consultar, actualizar y eliminar pacientes del sistema.
    </p>

    <div class="row row-cols-1 row-cols-md-2 g-4">

        {{-- Agregar paciente --}}
        <div class="col">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <strong>Agregar paciente</strong>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title mb-2">Nuevo registro</h5>
                    <p class="card-text flex-grow-1">
                        Crear la ficha de un paciente nuevo, ingresando sus datos personales y previsión.
                    </p>
                    <a href="{{ route('pacientes.create') }}" class="btn btn-primary w-100 mt-auto">
                        + Registrar paciente
                    </a>
                </div>
            </div>
        </div>

        {{-- Detalle paciente --}}
        <div class="col">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-info text-white">
                    <strong>Detalle de paciente</strong>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title mb-2">Consulta de información</h5>
                    <p class="card-text flex-grow-1">
                        Buscar un paciente por RUT y revisar todos sus datos registrados en el sistema.
                    </p>
                    <a href="{{ route('pacientes.detalle') }}" class="btn btn-info text-white w-100 mt-auto">
                        Ver detalle por RUT
                    </a>
                </div>
            </div>
        </div>

        {{-- Actualizar paciente --}}
        <div class="col">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-warning text-dark">
                    <strong>Actualizar paciente</strong>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title mb-2">Modificación de datos</h5>
                    <p class="card-text flex-grow-1">
                        Buscar por RUT y actualizar nombre, contacto, previsión u otros datos del paciente.
                    </p>
                    <a href="{{ route('pacientes.actualizar') }}" class="btn btn-warning w-100 mt-auto">
                        Ir a actualizar
                    </a>
                </div>
            </div>
        </div>

        {{-- Eliminar paciente --}}
        <div class="col">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-danger text-white">
                    <strong>Eliminar paciente</strong>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title mb-2">Baja de registro</h5>
                    <p class="card-text flex-grow-1">
                        Buscar por RUT y eliminar del sistema los registros de pacientes que ya no corresponda mantener.
                    </p>
                    <a href="{{ route('pacientes.eliminar') }}" class="btn btn-danger w-100 mt-auto">
                        Ir a eliminar
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
