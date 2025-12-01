@extends('template.secretaria')

@section('contenido')
<div class="container mt-4">
    <h2>Registro de Paciente</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="formCrearPaciente" action="{{ route('pacientes.store') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        {{-- Previsión --}}
        <div class="mb-3">
            <label class="form-label">Previsión</label>
            <select name="codPrevision" class="form-select" required>
                <option value="">Seleccione una previsión</option>
                @foreach($previsiones as $prev)
                    <option value="{{ $prev->codPrevision }}"
                        {{ old('codPrevision') == $prev->codPrevision ? 'selected' : '' }}>
                        {{ $prev->nombrePrevision }}
                    </option>
                @endforeach
            </select>
            @error('codPrevision')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- RUT --}}
        <div class="mb-3">
            <label class="form-label">RUN</label>
            <input type="text" name="rutPaciente" class="form-control"
                   value="{{ old('rutPaciente') }}" required>
            @error('rutPaciente')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Nombre --}}
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control"
                   value="{{ old('nombre') }}" required>
            @error('nombre')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Fecha de nacimiento --}}
        <div class="mb-3">
    <label class="form-label">Fecha de nacimiento</label>
    <input
        type="date"
        name="fechaNacimiento"
        class="form-control"
        value="{{ old('fechaNacimiento') }}"
        min="1940-01-01"
        max="{{ \Carbon\Carbon::today()->toDateString() }}"
        required
    >
    @error('fechaNacimiento')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

        {{-- Correo --}}
        <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" name="correo" class="form-control"
                   value="{{ old('correo') }}" required>
            @error('correo')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Teléfono --}}
        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control"
                   value="{{ old('telefono') }}" required>
            @error('telefono')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success w-100">
            Registrar Paciente
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
    const form = document.getElementById('formCrearPaciente');
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
