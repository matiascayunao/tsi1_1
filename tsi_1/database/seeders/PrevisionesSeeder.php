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
        ]);
    }
}

