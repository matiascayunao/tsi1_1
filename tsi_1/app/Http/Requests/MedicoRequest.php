<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'nombreMedico'   => 'required|string|max:100',
            'telefonoMedico' => 'required|string|max:15',
            'idEspecialidad' => 'required|exists:especialidades,idEspecialidad',
        ];

        // Crear médico
        if ($this->isMethod('POST')) {
            $rules['rutMedico']    = 'required|string|max:12|unique:medicos,rutMedico';
            $rules['correoMedico'] = 'required|email|max:100|unique:medicos,correoMedico';
        }

        // Actualizar médico
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $medico = $this->route('medico');
            $rut    = is_object($medico) ? $medico->rutMedico : $medico;

            $rules['correoMedico'] = 'required|email|max:100|unique:medicos,correoMedico,' . $rut . ',rutMedico';
        }

        return $rules;
    }
}
