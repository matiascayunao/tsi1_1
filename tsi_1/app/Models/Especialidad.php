<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    use HasFactory;

    protected $table = 'especialidades';
    protected $primaryKey = 'idEspecialidad';
    public $timestamps = false;

    protected $fillable = ['nombreEspecialidad'];

    public function medicos()
    {
        return $this->hasMany(Medico::class, 'idEspecialidad', 'idEspecialidad');
    }
}
