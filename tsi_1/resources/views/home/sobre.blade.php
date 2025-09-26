@extends('template.master')

@section('contenido')
<div class="container mt-4">
    <h2>Sobre Nosotros</h2>

    <div class="card shadow-sm p-4 mb-4">
        <h4>🏥 ¿Quiénes somos?</h4>
        <p>
            El <strong>Centro Médico BioSalud</strong> está ubicado en 
            <strong>Quintero, Valparaíso</strong>.  
            Nos especializamos en entregar atención médica integral, con un equipo de 
            profesionales comprometidos con la salud y el bienestar de nuestros pacientes.
        </p>
    </div>

    <div class="card shadow-sm p-4 mb-4">
        <h4>📅 Trayectoria</h4>
        <p>
            Llevamos más de <strong>15 años en operación</strong>, entregando servicios de calidad 
            a la comunidad. Durante este tiempo, hemos ampliado nuestras especialidades y modernizado 
            nuestras instalaciones para brindar una mejor atención.
        </p>
    </div>

    <div class="card shadow-sm p-4 mb-4">
        <h4>📍 Ubicación</h4>
        <p>
            <strong>Dirección:</strong> Luis Cousiño 1753, Quintero, Valparaíso.  
        </p>
        <img src="{{ asset('images/centro.jpg') }}" class="img-fluid rounded mb-3" alt="Centro Médico">
        <p>
            Nuestras instalaciones están diseñadas para entregar comodidad y seguridad a todos los pacientes.
        </p>
    </div>

    <div class="card shadow-sm p-4 mb-4">
        <h4>📞 Contacto</h4>
        <ul>
            <li><strong>Teléfono:</strong> 32 2934803</li>
            <li><strong>Correo:</strong> biosaludquintero@hotmail.com</li>
            <li><strong>Emergencias:</strong> +56 9 98877665</li>
        </ul>
    </div>

    <div class="card shadow-sm p-4">
        <h4>🌟 Nuestros Valores</h4>
        <p>
            • Compromiso con la salud. <br>
            • Atención cercana y humana. <br>
            • Profesionalismo y ética médica. <br>
            • Innovación en nuestros servicios.
        </p>
    </div>
</div>
@endsection
