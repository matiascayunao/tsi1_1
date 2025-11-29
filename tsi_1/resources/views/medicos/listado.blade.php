@extends('template.secretaria')

@section('contenido')
<div class="container mt-4">
    <h2>
        @if($modo === 'listar')
            Listado de Médicos
        @elseif($modo === 'actualizar')
            Actualizar Médicos
        @else
            Eliminar Médicos
        @endif
    </h2>

    @if($medicos->isEmpty())
        <div class="alert alert-warning mt-3">No hay médicos registrados.</div>
    @else
        <table class="table table-hover mt-3">
            <thead class="table-light">
                <tr>
                    <th>Especialidad</th>
                    <th>Nombre</th>
                    <th>RUT</th>
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
                            @if($modo === 'listar')
                                <a href="{{ route('medicos.show', $medico->rutMedico) }}"
                                   class="btn btn-sm btn-info">
                                    Ver detalle
                                </a>
                            @elseif($modo === 'actualizar')
                                <a href="{{ route('medicos.edit', $medico->rutMedico) }}"
                                   class="btn btn-sm btn-warning">
                                    Editar
                                </a>
                            @else {{-- eliminar --}}
                                <form action="{{ route('medicos.destroy', $medico->rutMedico) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('¿Seguro que deseas eliminar este médico?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Eliminar
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
