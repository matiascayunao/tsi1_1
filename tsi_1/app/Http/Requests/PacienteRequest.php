<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PacienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Reglas comunes para crear / actualizar
        $rules = [
            'nombre'          => 'required|string|max:100',
            'fechaNacimiento' => 'required|date',
            'correo'          => 'required|email|max:100',
            'telefono'        => 'required|string|max:15',
            'codPrevision'    => 'required|exists:previsiones,codPrevision',
        ];

        // Crear paciente (POST)
        if ($this->isMethod('POST')) {
            $rules['rutPaciente'] = 'required|string|max:12|unique:pacientes,rutPaciente';
            $rules['correo']     .= '|unique:pacientes,correo';
        }

        // Actualizar paciente (PUT / PATCH)
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            // En tu ruta usas {paciente} con Route Model Binding
            $paciente = $this->route('paciente');
            $rut      = is_object($paciente) ? $paciente->rutPaciente : $paciente;

            // En el form de edición NO necesitas mandar rutPaciente ni fechaNacimiento
            // Solo validamos que el correo no choque con otros pacientes
            $rules['correo'] .= '|unique:pacientes,correo,' . $rut . ',rutPaciente';
        }

        return $rules;
    }
}
