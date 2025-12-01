@extends('template.secretaria')

@section('contenido')
<div class="container mt-4">
    <h2>Editar Médico</h2>

    <form action="{{ route('medicos.update', $medico) }}" method="POST" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')

        {{-- RUT sólo para mostrar, NO editable --}}
        <div class="mb-3">
            <label class="form-label">RUN</label>
            <input type="text"
                   class="form-control"
                   value="{{ $medico->rutMedico }}"
                   readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombreMedico" class="form-control"
                   value="{{ old('nombreMedico', $medico->nombreMedico) }}" required>
            @error('nombreMedico')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" name="correoMedico" class="form-control"
                   value="{{ old('correoMedico', $medico->correoMedico) }}">
            @error('correoMedico')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefonoMedico" class="form-control"
                   value="{{ old('telefonoMedico', $medico->telefonoMedico) }}">
            @error('telefonoMedico')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
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
            @error('idEspecialidad')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success w-100">
            Guardar cambios
        </button>
    </form>
</div>
@endsection
