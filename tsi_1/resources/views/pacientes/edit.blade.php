@extends('template.secretaria')

@section('contenido')
<div class="container mt-4">
    <h2>Actualizar paciente</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="formEditarPaciente"
          action="{{ route('pacientes.update', $paciente) }}"
          method="POST"
          class="card p-4 shadow-sm">
        @csrf
        @method('PUT')

        {{-- RUT (si lo permites editar, se valida igual) --}}
        <div class="mb-3" >
            <label class="form-label">RUN</label>
            <input type="text" name="rutPaciente" class="form-control"
                   value="{{ old('rutPaciente', $paciente->rutPaciente) }}" disabled>
            @error('rutPaciente')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Fecha de nacimiento --}}
        <div class="mb-3">
            <label class="form-label">Fecha de nacimiento</label>
            <input type="date"
                   name="fechaNacimiento"
                   class="form-control"
                   value="{{ old('fechaNacimiento', $paciente->fechaNacimiento) }}"
                   min="1940-01-01"
                   max="{{ \Carbon\Carbon::today()->toDateString() }}"
                   disabled>
            @error('fechaNacimiento')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Nombre --}}
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control"
                   value="{{ old('nombre', $paciente->nombre) }}" required>
            @error('nombre')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Correo --}}
        <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" name="correo" class="form-control"
                   value="{{ old('correo', $paciente->correo) }}" required>
            @error('correo')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Teléfono --}}
        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control"
                   value="{{ old('telefono', $paciente->telefono) }}" required>
            @error('telefono')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Previsión --}}
        <div class="mb-3">
            <label class="form-label">Previsión</label>
            <select name="codPrevision" class="form-select" required>
                @foreach($previsiones as $prev)
                    <option value="{{ $prev->codPrevision }}"
                        {{ old('codPrevision', $paciente->codPrevision) == $prev->codPrevision ? 'selected' : '' }}>
                        {{ $prev->nombrePrevision }}
                    </option>
                @endforeach
            </select>
            @error('codPrevision')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success w-100">
            Guardar cambios
        </button>
    </form>
</div>

<script>
// misma validación RUT que en create
function validarRutChile(rut) {
    rut = rut.replace(/\./g, '').replace(/-/g, '').toUpperCase();
    if (rut.length < 8 || rut.length > 9) return false;

    let cuerpo = rut.slice(0, -1);
    let dv     = rut.slice(-1);
    let suma = 0;
    let multiplo = 2;

    for (let i = cuerpo.length - 1; i >= 0; i--) {
        suma += multiplo * parseInt(cuerpo.charAt(i));
        multiplo = multiplo === 7 ? 2 : multiplo + 1;
    }

    let dvEsperado = 11 - (suma % 11);
    let dvResultado = dvEsperado === 11 ? '0'
                     : dvEsperado === 10 ? 'K'
                     : dvEsperado.toString();

    return dvResultado === dv;
}

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formEditarPaciente');
    const rutInput = form.querySelector('input[name="rutPaciente"]');

    form.addEventListener('submit', function (e) {
        const valor = rutInput.value.trim();
        if (!validarRutChile(valor)) {
            e.preventDefault();
            alert('El RUN del paciente no es válido. Revísalo e inténtalo nuevamente.');
            rutInput.focus();
        }
    });
});
</script>
@endsection
