@extends('template.master')

@section('contenido')
<div class="container mt-4">
    <h2>Registro de Paciente</h2>
    <form action="{{ route('citas.guardarPaciente') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        <input type="hidden" name="rutMedico" value="{{ $rutMedico }}">
        <input type="hidden" name="idPrevision" value="{{ $idPrevision }}">

        <div class="mb-3">
            <label class="form-label">Previsión</label>
            <input type="text" class="form-control" value="{{ $prevision->nombre }}" readonly>
        </div>

        <div class="mb-3">
            <label for="rutPaciente" class="form-label">RUT</label>
            <input type="text" name="rutPaciente" id="rutPaciente" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="fechaNacimiento" class="form-label">Fecha de nacimiento</label>
            <input type="date" name="fechaNacimiento" id="fechaNacimiento" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" name="correo" id="correo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" name="telefono" id="telefono" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success w-100">Continuar a la reserva</button>
    </form>
</div>
@endsection