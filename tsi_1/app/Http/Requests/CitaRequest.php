<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CitaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Crear cita
        if ($this->isMethod('POST')) {
            return [
                'rutPaciente' => 'required|string|max:12|exists:pacientes,rutPaciente',
                'rutMedico'   => 'required|string|max:12|exists:medicos,rutMedico',
                'fechaHora'   => 'required|date',
                // En BD está como VARCHAR(200)
                'motivoCita'  => 'required|string|max:200',
            ];
        }

        // Actualizar cita (solo fechaHora en tu controlador)
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            return [
                'fechaHora' => 'required|date',
                // si quisieras permitir editar motivo:
                // 'motivoCita' => 'required|string|max:200',
            ];
        }

        return [];
    }
}
