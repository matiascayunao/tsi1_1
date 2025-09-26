@extends('template.master')

@section('contenido')
<div class="container mt-4">
    <h2>Cancelar Cita</h2>
    <form action="{{ route('citas.mostrarCancelar') }}" method="POST" class="card p-4 shadow-sm">
        @csrf
        <div class="mb-3">
            <label for="rutPaciente" class="form-label">Ingrese RUT del Paciente</label>
            <input type="text" name="rutPaciente" id="rutPaciente" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-danger w-100">Buscar citas</button>
    </form>
</div>
@endsection
