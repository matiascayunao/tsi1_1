<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrevisionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('previsiones')->insert([
            ['nombre' => 'Fonasa', 'tipoPrevision' => 'Pública'],
            ['nombre' => 'Isapre Colmena', 'tipoPrevision' => 'Privada'],
            ['nombre' => 'Isapre Banmédica', 'tipoPrevision' => 'Privada'],
            ['nombre' => 'Isapre Consalud', 'tipoPrevision' => 'Privada'],
            ['nombre' => 'Isapre Cruz Blanca', 'tipoPrevision' => 'Privada'],
            ['nombre' => 'Isapre Vida Tres', 'tipoPrevision' => 'Privada'],
            ['nombre' => 'Isapre Nueva Masvida', 'tipoPrevision' => 'Privada'],
            ['nombre' => 'Isapre Óptima', 'tipoPrevision' => 'Privada'],
            ['nombre' => 'Isapre Fundación', 'tipoPrevision' => 'Privada'],
            ['nombre' => 'Isapre Salud Total', 'tipoPrevision' => 'Privada'],
            ['nombre' => 'Particular', 'tipoPrevision' => 'Particular'],
        ]);
    }
}

