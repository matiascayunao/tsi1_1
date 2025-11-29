@extends('template.secretaria')

@section('contenido')
<div class="container mt-4">
    <h2>Actualizar paciente</h2>

    <form action="{{ route('pacientes.update', $paciente->rutPaciente) }}"
          method="POST"
          class="card p-4 shadow-sm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">RUT</label>
            <input type="text"
                   class="form-control"
                   value="{{ $paciente->rutPaciente }}"
                   readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha de nacimiento</label>
            <input type="date"
                   class="form-control"
                   value="{{ $paciente->fechaNacimiento }}"
                   readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text"
                   name="nombre"
                   class="form-control"
                   value="{{ old('nombre', $paciente->nombre) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email"
                   name="correo"
                   class="form-control"
                   value="{{ old('correo', $paciente->correo) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text"
                   name="telefono"
                   class="form-control"
                   value="{{ old('telefono', $paciente->telefono) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Previsión</label>
            <select name="codPrevision" class="form-select" required>
                @foreach($previsiones as $prev)
                    <option value="{{ $prev->codPrevision }}"
                        {{ $prev->codPrevision == $paciente->codPrevision ? 'selected' : '' }}>
                        {{ $prev->nombrePrevision }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success w-100">Guardar cambios</button>
    </form>
</div>
@endsection
