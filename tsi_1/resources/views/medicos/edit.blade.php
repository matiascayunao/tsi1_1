@extends('template.secretaria')

@section('contenido')
<div class="container mt-4">
    <h2>Editar Médico</h2>

    <form action="{{ route('medicos.update', $medico) }}" method="POST" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">RUT</label>
            <input type="text" name="rutMedico" class="form-control"
                   value="{{ old('rutMedico', $medico->rutMedico) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombreMedico" class="form-control"
                   value="{{ old('nombreMedico', $medico->nombreMedico) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" name="correoMedico" class="form-control"
                   value="{{ old('correoMedico', $medico->correoMedico) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefonoMedico" class="form-control"
                   value="{{ old('telefonoMedico', $medico->telefonoMedico) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Especialidad</label>
            <select name="idEspecialidad" class="form-select" required>
                @foreach($especialidades as $esp)
                    <option value="{{ $esp->idEspecialidad }}"
                        {{ $esp->idEspecialidad == old('idEspecialidad', $medico->idEspecialidad) ? 'selected' : '' }}>
                        {{ $esp->nombreEspecialidad }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success w-100">
            Guardar cambios
        </button>
    </form>
</div>
@endsection
