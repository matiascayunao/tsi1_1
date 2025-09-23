<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $table = 'Paciente';
    protected $primaryKey = 'rutPaciente';
    public $incrementing = false; 
    protected $keyType = 'string';

    protected $fillable = [
        'rutPaciente',
        'nombre',
        'fechaNacimiento',
        'correo',
        'telefono',
        'codPrevision'
    ];

    public function prevision()
    {
        return $this->belongsTo(Prevision::class, 'codPrevision');
    }

    public function citas()
    {
        return $this->hasMany(CitaPaciente::class, 'rutPaciente');
    }
}
