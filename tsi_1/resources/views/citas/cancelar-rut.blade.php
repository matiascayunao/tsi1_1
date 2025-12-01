@extends('template.master')

@section('contenido')
<div class="container mt-4">
    <h2>Cancelar Cita</h2>
    <form action="{{ route('citas.mostrarCancelar') }}" method="POST" class="card p-4 shadow-sm" id="formCancelarRut">
        @csrf
        <div class="mb-3">
            <label for="rutPaciente" class="form-label">Ingrese RUT del Paciente</label>
            <input type="text" name="rutPaciente" id="rutPaciente" class="form-control"
                   placeholder="12345678-9" required>
        </div>
        <button type="submit" class="btn btn-danger w-100">Buscar citas</button>
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
    const form = document.getElementById('formCancelarRut');
    const rutInput = document.getElementById('rutPaciente');

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
