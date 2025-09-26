<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prevision extends Model
{
    use HasFactory;

    protected $table = 'previsiones';
    protected $primaryKey = 'codPrevision';
    public $timestamps = false;

    protected $fillable = [
        'codPrevision',
        'nombrePrevision',
        'tipoPrevision',
    ];

    public function pacientes()
    {
        return $this->hasMany(Paciente::class, 'codPrevision', 'codPrevision');
    }
}
