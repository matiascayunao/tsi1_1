<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrevisionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $prevision = $this->route('prevision');
        $id        = is_object($prevision) ? $prevision->codPrevision : $prevision;

        $nombreRule = 'required|string|max:50|unique:previsiones,nombrePrevision';

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $nombreRule .= ',' . $id . ',codPrevision';
        }

        return [
            'nombrePrevision' => $nombreRule,
            'tipoPrevision'   => 'required|string|max:20',
        ];
    }
}
