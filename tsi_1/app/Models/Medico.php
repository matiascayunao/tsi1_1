<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    use HasFactory;

    protected $table = 'Medicos';
    protected $primaryKey = 'rutMedico';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'rutMedico',
        'nombreMedico',
        'correoMedico',
        'telefonoMedico',
        'idEspecialidad'
    ];

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'idEspecialidad');
    }

    public function citas()
    {
        return $this->hasMany(CitaPaciente::class, 'rutMedico');
    }

    public function agenda()
    {
        return $this->hasMany(AgendaMedico::class, 'rutMedico');
    }
}
