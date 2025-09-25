<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    use HasFactory;

    protected $table = 'Especialidades';
    protected $primaryKey = 'idEspecialidad';

    protected $fillable = [
        'nombreEspecialidad'
    ];

    public function medicos()
    {
        return $this->hasMany(Medico::class, 'idEspecialidad');
    }
}
