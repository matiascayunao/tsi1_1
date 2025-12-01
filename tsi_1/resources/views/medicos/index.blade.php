@extends('template.secretaria')

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-1">Gestión de Médicos</h2>
    <p class="text-muted mb-4">
        Desde este panel puedes registrar nuevos médicos, revisar su información,
        actualizar datos de contacto y dar de baja registros cuando sea necesario.
    </p>

    <div class="row row-cols-1 row-cols-md-2 g-4">

        {{-- Agregar médico --}}
        <div class="col">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <strong>Agregar médico</strong>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title mb-2">Nuevo profesional</h5>
                    <p class="card-text flex-grow-1">
                        Registrar un médico incorporando su RUN, nombre, correo, teléfono
                        y especialidad correspondiente.
                    </p>
                    <a href="{{ route('medicos.create') }}" class="btn btn-primary w-100 mt-auto">
                        + Registrar médico
                    </a>
                </div>
            </div>
        </div>

        {{-- Detalle / listado de médicos --}}
        <div class="col">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-info text-white">
                    <strong>Detalle de médicos</strong>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title mb-2">Listado completo</h5>
                    <p class="card-text flex-grow-1">
                        Ver el listado de todos los médicos registrados, con su especialidad,
                        datos de contacto y RUN.
                    </p>
                    <a href="{{ route('medicos.detalle') }}" class="btn btn-info text-white w-100 mt-auto">
                        Ver listado de médicos
                    </a>
                </div>
            </div>
        </div>

        {{-- Actualizar médico --}}
        <div class="col">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-warning text-dark">
                    <strong>Actualizar médico</strong>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title mb-2">Modificación de datos</h5>
                    <p class="card-text flex-grow-1">
                        Seleccionar un médico y actualizar su nombre, correo, teléfono
                        o especialidad de atención.
                    </p>
                    <a href="{{ route('medicos.actualizar') }}" class="btn btn-warning w-100 mt-auto">
                        Ir a actualizar
                    </a>
                </div>
            </div>
        </div>

        {{-- Eliminar médico --}}
        <div class="col">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-danger text-white">
                    <strong>Eliminar médico</strong>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title mb-2">Baja de registro</h5>
                    <p class="card-text flex-grow-1">
                        Seleccionar un médico del listado y eliminar su registro del sistema
                        cuando ya no corresponda mantenerlo activo.
                    </p>
                    <a href="{{ route('medicos.eliminar') }}" class="btn btn-danger w-100 mt-auto">
                        Ir a eliminar
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
