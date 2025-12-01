@extends('template.secretaria')

@section('contenido')
<div class="container mt-4">
    {{-- Título --}}
    <div class="mb-4">
        <h2 class="mb-1">Panel de Secretaría</h2>
        <p class="text-muted mb-0">
            Desde aquí puedes acceder rápidamente a la gestión de pacientes, médicos y citas.
        </p>
    </div>

    {{-- Fila principal de accesos rápidos --}}
    <div class="row row-cols-1 row-cols-md-3 g-4">

        {{-- Gestión de Pacientes --}}
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-primary text-white">
                    Gestión de Pacientes
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="card-text">
                        Registrar nuevos pacientes, actualizar datos o consultar su información clínica y previsión.
                    </p>
                    <ul class="small text-muted mb-3">
                        <li>Agregar / editar datos de pacientes</li>
                        <li>Consultar detalle por RUT</li>
                        <li>Eliminar registros cuando corresponda</li>
                    </ul>
                    <a href="{{ route('pacientes.index') }}" class="btn btn-primary mt-auto w-100">
                        Ir a Gestión de Pacientes
                    </a>
                </div>
            </div>
        </div>

        {{-- Gestión de Médicos --}}
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-success text-white">
                    Gestión de Médicos
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="card-text">
                        Administrar los datos de los médicos del centro y sus especialidades.
                    </p>
                    <ul class="small text-muted mb-3">
                        <li>Registrar nuevos médicos</li>
                        <li>Actualizar correo y teléfono</li>
                        <li>Asignar / cambiar especialidad</li>
                    </ul>
                    <a href="{{ route('medicos.index') }}" class="btn btn-success mt-auto w-100">
                        Ir a Gestión de Médicos
                    </a>
                </div>
            </div>
        </div>

        {{-- Calendario y Citas --}}
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-info text-white">
                    Citas y Agenda
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="card-text">
                        Revisar todas las citas agendadas, filtrarlas por médico y gestionar cambios o cancelaciones.
                    </p>
                    <ul class="small text-muted mb-3">
                        <li>Calendario gigante con días pasados en rojo</li>
                        <li>Filtro por médico</li>
                        <li>Listado por día para modificar / cancelar</li>
                    </ul>
                    <a href="{{ route('citas.calendario') }}" class="btn btn-info mt-auto w-100 text-white">
                        Ver calendario de citas
                    </a>
                </div>
            </div>
        </div>

    </div>

    {{-- Segunda fila: Agendar nueva cita (centrado) --}}
    <div class="row justify-content-center mt-4">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">Agendar nueva cita</h5>
                        <p class="card-text small text-muted mb-0">
                            Seleccionar paciente, médico, fecha y hora para registrar una nueva atención.
                        </p>
                    </div>
                    <a href="{{ route('secretaria.citas.create') }}" class="btn btn-outline-primary">
                        Agendar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
