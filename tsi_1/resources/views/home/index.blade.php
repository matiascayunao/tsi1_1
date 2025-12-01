@extends('template.master')

@section('contenido')
<div class="container mt-4">
    {{-- Título --}}
    <div class="mb-4 text-center">
        <h2 class="mb-1">Bienvenido al Centro Médico BioSalud</h2>
        <p class="text-muted mb-0">
            Desde aquí puedes reservar, modificar o cancelar tu cita y conocer más sobre nosotros.
        </p>
    </div>

    {{-- Cards principales --}}
    <div class="row row-cols-1 row-cols-md-4 g-4">

        {{-- Reservar tu hora --}}
        <div class="col">
            <div class="card h-100 shadow-sm border-primary">
                <div class="card-header bg-primary text-white">
                    Reservar tu hora
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="card-text">
                        Agenda una nueva atención eligiendo médico, fecha y horario disponible.
                    </p>
                    <ul class="small text-muted mb-3">
                        <li>Selección de médico y especialidad</li>
                        <li>Horarios según disponibilidad real</li>
                        <li>Confirmación inmediata de la cita</li>
                    </ul>
                    <a href="{{ route('citas.index') }}" class="btn btn-primary mt-auto w-100">
                        Reservar ahora
                    </a>
                </div>
            </div>
        </div>

        {{-- Modificar cita --}}
        <div class="col">
            <div class="card h-100 shadow-sm border-warning">
                <div class="card-header bg-warning text-dark">
                    Modificar cita
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="card-text">
                        Cambia la fecha u hora de una cita ya reservada usando tu RUT.
                    </p>
                    <ul class="small text-muted mb-3">
                        <li>Búsqueda rápida por RUT</li>
                        <li>Reprogramación de horario</li>
                        <li>Actualización del motivo si es necesario</li>
                    </ul>
                    <a href="{{ route('citas.buscarPorRut') }}" class="btn btn-warning mt-auto w-100">
                        Modificar cita
                    </a>
                </div>
            </div>
        </div>

        {{-- Cancelar cita --}}
        <div class="col">
            <div class="card h-100 shadow-sm border-danger">
                <div class="card-header bg-danger text-white">
                    Cancelar cita
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="card-text">
                        Si no podrás asistir, cancela tu cita para liberar el horario.
                    </p>
                    <ul class="small text-muted mb-3">
                        <li>Ingreso de RUT del paciente</li>
                        <li>Visualización de citas vigentes</li>
                        <li>Cancelación segura y registrada</li>
                    </ul>
                    <a href="{{ route('citas.cancelarPorRut') }}" class="btn btn-danger mt-auto w-100">
                        Cancelar cita
                    </a>
                </div>
            </div>
        </div>

        {{-- Sobre nosotros --}}
        <div class="col">
            <div class="card h-100 shadow-sm border-info">
                <div class="card-header bg-info text-white">
                    Sobre nosotros
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="card-text">
                        Conoce nuestra historia, misión, equipo médico y ubicación.
                    </p>
                    <ul class="small text-muted mb-3">
                        <li>Quiénes somos</li>
                        <li>Especialidades y servicios</li>
                        <li>Dirección y medios de contacto</li>
                    </ul>
                    <a href="{{ route('home.sobre') }}" class="btn btn-info mt-auto w-100 text-white">
                        Ver más información
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
