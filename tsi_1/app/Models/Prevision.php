<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prevision extends Model
{
    use HasFactory;

    protected $table = 'Prevision';
    protected $primaryKey = 'codPrevision';

    protected $fillable = [
        'codPrevision',
        'nombre',
        'tipoPrevision'
    ];

    public function pacientes()
    {
        return $this->hasMany(Paciente::class, 'codPrevision');
    }
}
