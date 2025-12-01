@extends('template.secretaria')

@section('contenido')
<div class="container mt-4">
    <h2>Registrar Médico</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="formCrearMedico" action="{{ route('medicos.store') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        <div class="mb-3">
            <label class="form-label">RUT</label>
            <input type="text" name="rutMedico" class="form-control"
                   value="{{ old('rutMedico') }}" required>
            @error('rutMedico')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombreMedico" class="form-control"
                   value="{{ old('nombreMedico') }}" required>
            @error('nombreMedico')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" name="correoMedico" class="form-control"
                   value="{{ old('correoMedico') }}">
            @error('correoMedico')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefonoMedico" class="form-control"
                   value="{{ old('telefonoMedico') }}">
            @error('telefonoMedico')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
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
            @error('idEspecialidad')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success w-100">
            Guardar Médico
        </button>
    </form>
</div>

<script>
// --- Validación de RUT chileno (módulo 11) ---
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
    const form = document.getElementById('formCrearMedico');
    const rutInput = form.querySelector('input[name="rutMedico"]');

    form.addEventListener('submit', function (e) {
        const valor = rutInput.value.trim();
        if (!validarRutChile(valor)) {
            e.preventDefault();
            alert('El RUT ingresado no es válido. Revísalo e inténtalo nuevamente.');
            rutInput.focus();
        }
    });
});
</script>
@endsection
