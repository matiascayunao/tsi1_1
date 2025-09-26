@extends('template.master')

@section('contenido')
<div class="container mt-4">
    <h2>Sobre Nosotros</h2>

    <div class="card shadow-sm p-4 mb-4">
        <h4> ¿Quiénes somos?</h4>
        <p>
            El <strong>Centro Médico BioSalud</strong> está ubicado en 
            <strong>Quintero, Valparaíso</strong>.  
            Nos especializamos en entregar atención médica integral, con un equipo de 
            profesionales comprometidos con la salud y el bienestar de nuestros pacientes.
            En nuestras instalaciones se encuentran las oficinas del Instituto de Seguridad del trabajo (IST), para accidentes laborales.
        </p>
    </div>

    <div class="card shadow-sm p-4 mb-4">
        <h4> Trayectoria</h4>
        <p>
            Llevamos más de <strong>30 años en operación</strong>, entregando servicios de calidad 
            a la comunidad. Durante este tiempo, hemos ampliado nuestras especialidades y modernizado 
            nuestras instalaciones para brindar una mejor atención.
        </p>
    </div>

    <div class="card shadow-sm p-4 mb-4">
    <h4> Ubicación</h4>
    <p class="mb-2">
        <strong>Dirección:</strong> Luis Cousiño 1753, Quintero, Valparaíso.
    </p>

    {{-- Galería: Frente y Sala --}}
    <div class="row g-3">
        <div class="col-12 col-md-6">
            <figure class="m-0">
                <img src="{{ asset('images/frente.jpg') }}" class="img-fluid rounded" alt="Fachada del Centro Médico">
                <figcaption class="small text-muted mt-1">Fachada / Frente del Centro</figcaption>
            </figure>
        </div>
        <div class="col-12 col-md-6">
            <figure class="m-0">
                <img src="{{ asset('images/sala.jpg') }}" class="img-fluid rounded" alt="Sala de atención del Centro Médico">
                <figcaption class="small text-muted mt-1">Sala de Atención</figcaption>
            </figure>
        </div>
    </div>

    <p class="mt-3">
        Nuestras instalaciones están diseñadas para entregar comodidad y seguridad a todos los pacientes.
    </p>
</div>

    <div class="card shadow-sm p-4 mb-4">
        <h4> Contacto</h4>
        <ul>
            <li><strong>Teléfono:</strong> 32 2934803</li>
            <li><strong>Correo:</strong> biosaludquintero@hotmail.com</li>
            <li><strong>Emergencias:</strong> +56 9 98877665</li>
        </ul>
    </div>
</div>
@endsection
