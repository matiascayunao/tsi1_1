<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumenCita extends Model
{
    use HasFactory;

    protected $table = 'ResumenesCitas';
    protected $primaryKey = 'idCita';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'idCita',
        'diagnostico',
        'prescripcion',
        'numReceta'
    ];

    public function cita()
    {
        return $this->belongsTo(CitaPaciente::class, 'idCita');
    }
}
