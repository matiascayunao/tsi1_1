@extends('template.master')

@section('contenido')
<div class="container mt-4">
    <h2>Registro de Paciente</h2>
    <p class="text-muted">
        Si es primera vez que reserva, completa el formulario de la izquierda.
        Si el paciente ya está registrado, usa el RUT en el recuadro verde.
    </p>

    <div class="row">
        {{-- CUADRO ROJO: nuevo paciente --}}
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <strong>Nuevo paciente</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('citas.guardarPaciente') }}" method="POST">
                        @csrf

                        <input type="hidden" name="rutMedico" value="{{ $rutMedico }}">
                        <input type="hidden" name="idPrevision" value="{{ $idPrevision }}">

                        <div class="mb-3">
                            <label class="form-label">Previsión seleccionada</label>
                            <input type="text" class="form-control" value="{{ $prevision->nombrePrevision }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="rutPaciente" class="form-label">RUT</label>
                            <input
                                type="text"
                                name="rutPaciente"
                                id="rutPaciente"
                                class="form-control"
                                value="{{ old('rutPaciente') }}"
                                required
                            >
                            @error('rutPaciente')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input
                                type="text"
                                name="nombre"
                                id="nombre"
                                class="form-control"
                                value="{{ old('nombre') }}"
                                required
                            >
                            @error('nombre')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="fechaNacimiento" class="form-label">Fecha de nacimiento</label>
                            <input
                                type="date"
                                name="fechaNacimiento"
                                id="fechaNacimiento"
                                class="form-control"
                                value="{{ old('fechaNacimiento') }}"
                                min="1940-01-01"
                                max="{{ now()->toDateString() }}"
                                required
                            >
                            @error('fechaNacimiento')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo</label>
                            <input
                                type="email"
                                name="correo"
                                id="correo"
                                class="form-control"
                                value="{{ old('correo') }}"
                                required
                            >
                            @error('correo')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input
                                type="text"
                                name="telefono"
                                id="telefono"
                                class="form-control"
                                value="{{ old('telefono') }}"
                                required
                            >
                            @error('telefono')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            Continuar a la reserva
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- CUADRO VERDE: paciente ya registrado --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-success">
                <div class="card-header bg-success text-white">
                    <strong>Ya estoy registrado</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('citas.usarPaciente') }}" method="POST" class="mb-0">
                        @csrf

                        <input type="hidden" name="rutMedico" value="{{ $rutMedico }}">

                        <p class="small text-muted">
                            Ingresa el RUT del paciente. Si existe en el sistema,
                            se usará su información (previsión incluida) y no se creará un registro nuevo.
                        </p>

                        <div class="mb-3">
                            <label for="rutExistente" class="form-label">RUT</label>
                            <input
                                type="text"
                                name="rutExistente"
                                id="rutExistente"
                                class="form-control"
                                value="{{ old('rutExistente') }}"
                                required
                            >
                            @error('rutExistente')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            Continuar con este paciente
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
