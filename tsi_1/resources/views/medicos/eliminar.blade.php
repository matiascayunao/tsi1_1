@extends('template.secretaria')

@section('contenido')
<div class="container mt-4">
    <h2>Eliminar Médicos</h2>

    @if($medicos->isEmpty())
        <div class="alert alert-warning mt-3">
            No hay médicos registrados.
        </div>
    @else
        <table class="table table-hover mt-3">
            <thead class="table-light">
                <tr>
                    <th>Especialidad</th>
                    <th>Nombre</th>
                    <th>RUN</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($medicos as $medico)
                    <tr>
                        <td>{{ $medico->especialidad->nombreEspecialidad ?? '-' }}</td>
                        <td>{{ $medico->nombreMedico }}</td>
                        <td>{{ $medico->rutMedico }}</td>
                        <td>{{ $medico->correoMedico }}</td>
                        <td>{{ $medico->telefonoMedico }}</td>
                        <td class="text-end">
                            <form action="{{ route('medicos.destroy', $medico) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('¿Seguro que deseas eliminar este médico?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
