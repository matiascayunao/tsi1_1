<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaMedico extends Model
{
    use HasFactory;

    protected $table = 'agendas_medicos';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'rutMedico',
        'fecha',
        'horaInicio',
        'horaTermino',
        'fechaApertura',
        'disponibilidad',
    ];

    public function medico()
    {
        return $this->belongsTo(Medico::class, 'rutMedico', 'rutMedico');
    }
}
