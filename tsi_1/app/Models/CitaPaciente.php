<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CitaPaciente extends Model
{
    use HasFactory;

    protected $table = 'citas_pacientes';   // nombre de la tabla
    protected $primaryKey = 'idCita';       // clave primaria

    public $timestamps = false;          // si no tienes timestamps
    // 🔹 Esto es lo que falta (o está mal escrito en tu código)
    protected $fillable = [
        'rutPaciente',
        'rutMedico',
        'fechaHora',
        'motivoCita',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'rutPaciente');
    }

    public function medico()
    {
        return $this->belongsTo(Medico::class, 'rutMedico');
    }

    public function resumen()
    {
        return $this->hasOne(ResumenCita::class, 'idCita');
    }
}
