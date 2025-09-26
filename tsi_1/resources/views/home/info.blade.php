@extends('template.master')

@section('contenido')
<div class="container mt-4">
    <h2>Información para Pacientes</h2>

    <div class="card shadow-sm p-4 mb-4">
        <h4> Horarios de Atención</h4>
        <p>
            Nuestro centro atiende de <strong>lunes a viernes desde las 8:00 AM</strong>.
        </p>
        <ul>
            <li><strong>Lunes y Jueves:</strong> atención extendida hasta las <strong>22:00 hrs</strong>.</li>
            <li><strong>Martes, Miércoles y Viernes:</strong> atención hasta las <strong>18:00 - 19:00 hrs</strong> según la especialidad.</li>
        </ul>
    </div>

    <div class="card shadow-sm p-4 mb-4">
        <h4> Compra de Bonos</h4>
        <p>
            Los bonos de atención pueden ser adquiridos en sucursales de <strong>Fonasa</strong> o 
            en las oficinas de las <strong>Isapres correspondientes</strong>.  
            También están disponibles en línea a través de los portales oficiales de Fonasa e Isapres.
        </p>
    </div>

    <div class="card shadow-sm p-4 mb-4">
        <h4> Dirección del Centro Médico</h4>
        <p>
            <strong>Centro Médico BioSalud</strong><br>
            Luis Cousiño 1753, Quintero, Valparaíso.  
        </p>
        <p>
            Teléfono: <strong>32 2934803</strong> <br>
            Correo: <strong>biosaludquintero@hotmail.com</strong>
        </p>
    </div>

    <div class="card shadow-sm p-4">
        <h4>Información Variada</h4>
        <p>
            Contamos con especialistas en diversas áreas médicas.  
            Se recomienda llegar con al menos <strong>15 minutos de anticipación</strong> a su cita.  
            Para consultas generales, puede dirigirse a recepción durante el horario de atención.
        </p>
    </div>
</div>
@endsection
