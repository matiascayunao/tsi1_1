@extends('template.master')

@section('contenido')
<div class="container mt-4">
    <h2>Reserva de Hora</h2>
    <p class="text-muted">Selecciona tu previsión y especialidad para buscar disponibilidad de médicos.</p>

    <form action="{{ route('citas.buscar') }}" method="POST" class="card p-4 shadow-sm">
        @csrf
        <div class="mb-3">
            <label for="codPrevision" class="form-label">Previsión</label>
            <select name="codPrevision" id="codPrevision" class="form-select" required>
                <option value="">-- Seleccione --</option>
                @foreach($previsiones as $prevision)
                    <option value="{{ $prevision->codPrevision }}">{{ $prevision->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="idEspecialidad" class="form-label">Especialidad</label>
            <select name="idEspecialidad" id="idEspecialidad" class="form-select" required>
                <option value="">-- Seleccione --</option>
                @foreach($especialidades as $especialidad)
                    <option value="{{ $especialidad->idEspecialidad }}">{{ $especialidad->nombreEspecialidad }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Buscar médicos</button>
    </form>
</div>
@endsection
