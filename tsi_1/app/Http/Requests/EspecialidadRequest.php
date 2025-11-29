<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EspecialidadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Para update, el {especialidad} viene en la ruta
        $especialidad = $this->route('especialidad');
        $id           = is_object($especialidad) ? $especialidad->idEspecialidad : $especialidad;

        // Regla base de unicidad
        $uniqueRule = 'unique:especialidades,nombreEspecialidad';

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $uniqueRule .= ',' . $id . ',idEspecialidad';
        }

        return [
            'nombreEspecialidad' => 'required|string|max:100|' . $uniqueRule,
        ];
    }
}
