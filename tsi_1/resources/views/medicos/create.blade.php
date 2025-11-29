@extends('template.secretaria')

@section('contenido')
<div class="container mt-4">
    <h2>Registrar Médico</h2>

    <form action="{{ route('medicos.store') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        <div class="mb-3">
            <label class="form-label">RUT</label>
            <input type="text" name="rutMedico" class="form-control"
                   value="{{ old('rutMedico') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombreMedico" class="form-control"
                   value="{{ old('nombreMedico') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" name="correoMedico" class="form-control"
                   value="{{ old('correoMedico') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefonoMedico" class="form-control"
                   value="{{ old('telefonoMedico') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Especialidad</label>
            <select name="idEspecialidad" class="form-select" required>
                <option value="">Seleccione una especialidad</option>
                @foreach($especialidades as $esp)
                    <option value="{{ $esp->idEspecialidad }}"
                        {{ old('idEspecialidad') == $esp->idEspecialidad ? 'selected' : '' }}>
                        {{ $esp->nombreEspecialidad }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success w-100">
            Guardar Médico
        </button>
    </form>
</div>
@endsection
