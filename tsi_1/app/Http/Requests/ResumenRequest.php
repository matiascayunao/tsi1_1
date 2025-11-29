<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResumenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'diagnostico' => 'required|string|max:200',
            'prescripcion'=> 'required|string|max:200',
            'numReceta'   => 'nullable|integer|min:1',
        ];

        // Al crear un resumen sí necesitamos el idCita
        if ($this->isMethod('POST')) {
            $rules['idCita'] = 'required|integer|exists:citas_pacientes,idCita';
        }

        return $rules;
    }
}
