<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrevisionesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('previsiones')->insert([
            ['nombrePrevision' => 'Fonasa',              'tipoPrevision' => 'Pública'],
            ['nombrePrevision' => 'Isapre Colmena',      'tipoPrevision' => 'Privada'],
            ['nombrePrevision' => 'Isapre Banmédica',    'tipoPrevision' => 'Privada'],
            ['nombrePrevision' => 'Isapre Consalud',     'tipoPrevision' => 'Privada'],
            ['nombrePrevision' => 'Isapre Cruz Blanca',  'tipoPrevision' => 'Privada'],
            ['nombrePrevision' => 'Isapre Vida Tres',    'tipoPrevision' => 'Privada'],
            ['nombrePrevision' => 'Isapre Nueva Masvida','tipoPrevision' => 'Privada'],
            ['nombrePrevision' => 'Isapre Óptima',       'tipoPrevision' => 'Privada'],
            ['nombrePrevision' => 'Isapre Fundación',    'tipoPrevision' => 'Privada'],
            ['nombrePrevision' => 'Isapre Salud Total',  'tipoPrevision' => 'Privada'],
            ['nombrePrevision' => 'Particular',          'tipoPrevision' => 'Particular'],
        ]);
    }
}
